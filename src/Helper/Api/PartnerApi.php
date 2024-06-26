<?php

    namespace Itrk\Helper\Api;

    use Itrk\Helper\Curl;
    use Itrk\Helper\ItrkApi;
    use Itrk\Helper\ItrkApiResource;
    use Itrk\Helper\Resources\Partner\Contract;
    use Itrk\Helper\Resources\Partner\Order;
    use Itrk\Helper\Resources\Partner\PreOrder;
    use function Itrk\Functions\totp;

    /**
     * Stellt Methoden für den Zugriff auf alle Partner-relevanten Endpoints bereit:
     * - Bestellung einleiten (1) und ausführen (2)
     * - Verträge abrufe
     */
    class PartnerApi extends ItrkApi {

        protected string $partnerToken = '';

        public function __construct(string $partner_token) {
            $this->partnerToken = $partner_token;
        }

        public function curl(): Curl {
            return parent::curl()
                ->addHeaders([
                    'X-Auth-Partner-Token' => $this->partnerToken,
                    'X-Api-Secret'         => totp()
                ])
                ->prependUrlPath('itrk-api/partner');
        }

        /**
         * Allgemeine Methode für Requests an den `/itrk-api/partner/contracts` Verträge Endpoint
         *
         * @param int|null $limit          Optional: kann verwendet werden, um die Menge an abzufragenden Verträgen
         *                                 einzuschränken. Automatisches Limit ist 1000.
         * @param int      $offset         Optional: Offset kann für Paginierung genutzt werden
         * @param string   $order_id       Optional: Order-ID angeben, um alle Verträge abzurufen die zu einer
         *                                 bestimmten Bestellung gehören.
         * @param array    $ids            Optional: eine Liste von Vertrags-IDs um bestimmte Verträge abzurufen
         * @param bool     $with_documents Optional: true übergeben, um zusätzlich zu den Verträgen auch die
         *                                 verbundenen Dokumente abzufragen
         *
         * @return Contract[]
         */
        public function contracts(int $limit = null, int $offset = 0, string $order_id = '', array $ids = [], bool $with_documents = false): array {
            $params = [];
            if ($order_id) {
                $params['order'] = $order_id;
            }
            if ($ids) {
                $params['ids'] = implode(',', $ids);
            }
            if ($limit) {
                $params['limit'] = $limit;
            }
            if ($offset) {
                $params['offset'] = $offset;
            }
            if ($with_documents) {
                $params['with_documents'] = 1;
            }

            return $this->curl()->get('contracts')->send($params)->toResources(Contract::class);
        }

        /**
         * Gibt alle Verträge einer bestimmten Bestellung zurück
         *
         * @param string $order_id
         *
         * @return Contract[]
         */
        public function getContractsByOrderId(string $order_id) {
            return $this->contracts(null, 0, $order_id);
        }

        /**
         * Bestellvorgang einleiten
         *
         * @param array $data
         *
         * @return ItrkApiResource|PreOrder
         */
        public function initOrder(array $data): PreOrder {
            return $this->curl()->post('order', $data)->send()->toResource(PreOrder::class);
        }

        /**
         * Bestellung ausführen
         *
         * @param array $data
         *
         * @return ItrkApiResource|Order
         */
        public function placeOrder(array $data): Order {
            return $this->curl()->post('order', $data)->send()->toResource(Order::class);
        }

    }
