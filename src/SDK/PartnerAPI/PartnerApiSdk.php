<?php

    namespace Itrk\SDK\PartnerAPI;

    use Itrk\Api\PartnerApi;
    use Itrk\Resources\BaseApiResource;
    use Itrk\Resources\Partner\Order\Contract;
    use Itrk\Resources\Partner\Order\Order;
    use Itrk\Resources\Partner\Order\ProposedOrder;
    use Itrk\System\Enums\Country;
    use Itrk\System\Enums\Salut;
    use function Itrk\totp;
    use function Itrk\url;

    /**
     * Stellt Methoden bereit um Bestellungen auszuführen und Verträge abzurufen.
     */
    class PartnerApiSdk {

        /** @var int Ihre Partner-ID */
        protected int $partner_id = 0;

        /** @var string Ihr Partner-Token, den wir Ihnen mitgeteilt haben */
        protected string $partner_token = '';

        /**
         * @param int    $partner_id    Ihre Partner-ID
         * @param string $partner_token Ihr Ihnen bereits mitgeteilter Partner-Token
         */
        public function __construct(int $partner_id, string $partner_token) {
            $this->setPartnerId($partner_id);
            $this->setPartnerToken($partner_token);
        }

        /**
         * @return PartnerApi
         */
        public function api(): PartnerApi {
            return new PartnerApi($this->partner_token);
        }

        /**
         * Ihre Partner-ID festlegen
         *
         * @param int $id
         *
         * @return $this
         */
        public function setPartnerId(int $id): self {
            $this->partner_id = $id;

            return $this;
        }

        /**
         * Legen Sie hier den Partner-Token fest den wir Ihnen mitgeteilt haben
         *
         * @param string $token
         *
         * @return $this
         */
        public function setPartnerToken(string $token): self {
            $this->partner_token = $token;

            return $this;
        }

        /**
         * Gibt die URL zurück, mit der sich der Mandant direkt im Portal einloggen kann ohne Anmeldedaten einzugeben.
         *
         * @param string $user_hash
         *
         * @return string
         */
        public function contactLoginUrl(string $user_hash): string {
            return url('action/external_login.php?partner=' . $this->partner_id . '&_tok=' . totp($this->partner_id, 'mFb2CMJVhtHWQHpTnFMiFMdpmNMeTJWU') . '&user=' . $user_hash);
        }

        /**
         * Gibt ein Array zurück, wenn erwartet wird, dass der response ein gültiges JSON ist.
         *
         * @param $response
         *
         * @return mixed
         */
        protected function responseArray($response) {
            return json_decode((string)$response, true) ?: [];
        }

        # -- API Endpoints

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
         * @return array|Contract[]
         */
        public function contracts(int $limit = null, int $offset = 0, string $order_id = '', array $ids = [], bool $with_documents = false): array {
            return $this->api()->contracts($limit, $offset, $order_id, $ids, $with_documents);
        }

        /**
         * Verträge anhand der Order ID abrufen
         *
         * @param string $order_id
         * @param bool   $with_documents
         *
         * @return array|Contract[]
         */
        public function getContractsByOrderId(string $order_id, bool $with_documents = false): array {
            return $this->contracts(null, 0, $order_id, [], $with_documents);
        }

        /**
         * Gibt Verträge anhand der übergebenen IDs zurück
         *
         * @param array    $ids
         * @param int|null $limit
         * @param int      $offset
         * @param bool     $with_documents
         *
         * @return array|Contract[]
         */
        public function getContractsWithIds(array $ids, ?int $limit = null, int $offset = 0, bool $with_documents = false): array {
            return $this->contracts($limit, $offset, '', $ids, $with_documents);
        }

        /**
         * Step #1 - Bestellung einleiten
         * Hierbei werden die Kundendaten übergeben sowie die zu buchenden Dokumente und/oder bundles.
         *
         * @param string $email
         * @param string $display_name
         * @param string $first_name
         * @param string $last_name
         * @param string $street
         * @param string $zip
         * @param string $city
         * @param int    $country
         * @param int    $salut
         * @param array  $documents
         * @param array  $bundles
         *
         * @return BaseApiResource|ProposedOrder
         */
        public function initOrder(string $email, string $display_name, string $first_name, string $last_name, string $street, string $zip, string $city, int $country = Country::GERMANY, int $salut = Salut::OTHERS, array $documents = [], array $bundles = []): ProposedOrder {
            $order_data = [
                'order' => [
                    'customer' => [
                        'email'   => $email,
                        'name'    => $display_name,
                        'strasse' => $street,
                        'plz'     => $zip,
                        'ort'     => $city,
                        'country' => $country,
                    ],
                    'contact'  => [
                        'first_name' => $first_name,
                        'last_name'  => $last_name,
                        'anrede'     => $salut,
                    ],
                    'services' => [
                        'bundles'   => $bundles,
                        'documents' => $documents
                    ]
                ]
            ];

            return $this->api()->initOrder($order_data);
        }

        /**
         * Mit den Daten und der Prüfsumme die bei der Bestell-Einleitung zurückgegeben wurden, kann die Bestellung
         * im zweiten Schritt final platziert werden.
         *
         * @param string $confirm_data
         *
         * @return Order
         * @see ProposedOrder::confirmData()
         */
        public function placeOrder(string $confirm_data): Order {
            return $this->api()->placeOrder($confirm_data);
        }

    }
