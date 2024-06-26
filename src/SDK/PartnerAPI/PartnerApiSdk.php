<?php

    namespace Itrk\SDK\PartnerAPI;

    use Itrk\Helper\Api\PartnerApi;
    use Itrk\Helper\Config;
    use Itrk\Helper\Curl;
    use Itrk\Helper\ItrkApiResource;
    use Itrk\Helper\Resources\Partner\Contract;
    use Itrk\Helper\Resources\Partner\Order;
    use Itrk\Helper\Resources\Partner\PreOrder;
    use function Itrk\Functions\totp;
    use function Itrk\Functions\url;

    class PartnerApiSdk {

        /** @var int Ihre Partner-ID */
        protected int $partner_id = 0;

        /** @var string Ihr Partner-Token, den wir Ihnen mitgeteilt haben */
        protected string $partner_token = '';

        /** @var Curl Stellt die Verbindung her und legt automatisch alle benötigten Werte und Parameter fest */
        protected Curl $curl;

        /**
         * @param int    $partner_id    Ihre Partner-ID
         * @param string $partner_token Ihr Ihnen bereits mitgeteilter Partner-Token
         */
        public function __construct(int $partner_id, string $partner_token) {
            $this->setPartnerId($partner_id);
            $this->setPartnerToken($partner_token);

            $this->curl = new Curl();
            $this->curl->prependUrlPath('itrk-api/partner');
            $this->curl->addHeaders([
                'X-Auth-Partner-Token' => $this->partner_token,
                'X-Api-Secret'         => totp()
            ]);
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
         * Zum Ausführen eines cUrl Requests
         *
         * @param string            $path                der URL Pfad
         * @param array             $url_params          Optional: request parameter
         * @param string            $method              Request Methode
         * @param array|string|null $body                Der Body der mitgesendet werden soll - standardmäßig NULL, es
         *                                               wird also kein Body gesendet. Body kann ein string sein, oder
         *                                               ein array (welches json-encoded wird).
         * @param array             $headers             Optional: zusätzliche Header
         * @param array             $custom_curl_options Optional: hiermit können zusätzliche cUrl Optionen gesetzt und
         *                                               ggf. Standard-Optionen überschrieben werden.
         *
         * @return bool|string
         */
        public function curl(string $path, array $url_params = [], string $method = 'GET', $body = null, array $headers = [], array $custom_curl_options = []) {
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
         * @return array|mixed
         */
        public function getContractsByOrderId(string $order_id, bool $with_documents = false) {
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
         * @return array|mixed
         */
        public function getContractsWithIds(array $ids, ?int $limit = null, int $offset = 0, bool $with_documents = false) {
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
         * @return ItrkApiResource|PreOrder
         */
        public function initOrder(string $email, string $display_name, string $first_name, string $last_name, string $street, string $zip, string $city, int $country = Config::COUNTRY_GERMANY, int $salut = Config::SALUT_OTHERS, array $documents = [], array $bundles = []) {
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
         * @param array $confirm_data
         *
         * @return Order
         * @see PreOrder::confirmData()
         */
        public function placeOrder(array $confirm_data) {
            return $this->api()->placeOrder($confirm_data);
        }

    }
