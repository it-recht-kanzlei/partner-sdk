<?php

    namespace Itrk\System\Net;

    use Itrk\Api\BaseApiResponse;
    use Itrk\System\Config;
    use function Itrk\url;

    /**
     * cUrl Helper Klasse für die Verbindung zur API
     */
    class Curl {

        /** @var string Der URL-Pfad - dieser Pfad wird (falls definiert) NACH $staticUrlPath mit angehängt */
        protected string $path = '';

        /** @var array Hält Informationen zum zuletzt ausgeführten cUrl request */
        protected array $lastInfo = [];

        /** @var array Die cUrl Options, die beim zuletzt ausgeführten request verwendet wurden */
        protected array $lastOptions = [];

        /** @var null|bool|string Der Response des zuletzt abgesendeten cUrl requests */
        protected $lastResponse;

        /** @var string Ggf. erfordern manche Testing-Hosts Basic Auth */
        protected string $basicAuthUsername = '';
        protected string $basicAuthPassword = '';

        /** @var array Assoziatives Array mit Headern */
        protected array $headers = [];

        /** @var string Requset Method */
        protected string $requestMethod = 'GET';

        /** @var array Optional: diverse Request Parameter */
        protected array $urlParams = [];

        /** @var string Start-Pfad der nach dem Domain-Part statisch eingefügt wird */
        protected string $staticUrlPath;

        /** @var array Standard cUrl Optionen */
        protected array $curl_options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Accept: */*',
            ],
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_FRESH_CONNECT  => true,

            # Im Fall von etwaigen Verbindungsproblemen, kann es mitunter hilfreich sein, diverse Checks temporär zu deaktiveren
            // CURLOPT_SSL_VERIFYHOST       => false,
            // CURLOPT_SSL_VERIFYPEER       => false,
            // CURLOPT_SSL_VERIFYSTATUS     => false,
            // CURLOPT_PROXY_SSL_VERIFYHOST => false,
            // CURLOPT_PROXY_SSL_VERIFYPEER => false,
            // CURLOPT_VERBOSE              => true,

        ];

        /** @var string|null Body der gesendet werden soll */
        protected ?string $body = null;

        public function __construct() {
            $this->setBasicAuth(Config::$basicAuthUsername, Config::$basicAuthPassword);
        }

        /**
         * Gibt ein Curl Objekt zurück (und ermöglicht dabei das chaining)
         *
         * @return self
         */
        public static function create(): self {
            return new self();
        }

        /**
         * @param mixed  $body       Der Body string. Falls dies ein Array oder Objekt ist, wird der übergebene Wert
         *                           json-encoded und als Body verwendet.
         * @param string $set_method Automatisch auf die angegebene request method umswitchen
         *
         * @return $this
         */
        public function setBody($body, string $set_method = 'POST'): self {
            switch (true) {
                # Daten werden json-encoded und dann als Body versendet
                case is_array($body) || is_object($body):
                    $this->body = json_encode($body);
                    break;
                # Daten werden zu string gecasted und dann im Body versendet
                default:
                    $this->body = (string)$body;
            }
            $this->method($set_method);

            return $this;
        }

        /**
         * @param string $path
         *
         * @return $this
         */
        public function setPath(string $path): self {
            $this->path = trim($path, '/');

            return $this;
        }

        /**
         * Legt einen Start-Pfad fest, der für alle Requests aus diesem Objekt heraus gilt.
         *
         * @param string $path
         *
         * @return $this
         */
        public function prependUrlPath(string $path): self {
            $this->staticUrlPath = trim($path, '/');

            return $this;
        }

        /**
         * Legt den Content-Type fest
         *
         * @param string $value
         *
         * @return $this
         */
        public function setContentType(string $value): self {
            return $this->addHeader('Content-Type', $value);
        }

        /**
         * Basic Auth Daten festlegen
         *
         * @param string $username
         * @param string $password
         *
         * @return $this
         */
        public function setBasicAuth(string $username, string $password): self {
            $this->basicAuthUsername = $username;
            $this->basicAuthPassword = $password;

            return $this;
        }

        /**
         * Fügt eine einzelne cUrl Option hinzu
         *
         * @param int          $key
         * @param scalar|array $value
         *
         * @return $this
         */
        public function addCurlOption(int $key, $value): self {
            $this->curl_options[$key] = $value;

            return $this;
        }

        /**
         * Fügt mehrere cUrl Optionen hinzu
         *
         * @param array $options
         *
         * @return $this
         */
        public function addCurlOptions(array $options): self {
            $this->curl_options = array_replace_recursive($this->curl_options, $options);

            return $this;
        }

        /**
         * Fügt einen Header Eintrag hinzu
         *
         * @param string       $header_name
         * @param scalar|array $value
         *
         * @return $this
         */
        public function addHeader(string $header_name, $value): self {
            $this->headers[rtrim(trim(mb_strtolower($header_name)), ':')] = $value;

            return $this;
        }

        /**
         * Fügt mehrere Header Einträge über ein assoziatives Array hinzu
         *
         * @param array $headers Beispiel: ["Content-Type" => "application/json"]
         *
         * @return $this
         */
        public function addHeaders(array $headers): self {
            foreach ($headers as $name => $value) {
                $this->addHeader($name, $value);
            }

            return $this;
        }

        /**
         * Gibt die gesetzten Header in einem flachen Array zurück
         *
         * @return array Beispiel: [0 => "Content-Type: application/json"]
         */
        public function getHeaders(): array {
            $result = [];
            foreach ($this->headers as $name => $value) {
                $result[] = $name . ': ' . $value;
            }

            return $result;
        }

        /**
         * Gibt die cUrl Optionen zurück und fügt ggf. weitere gesetzt Optionen hinzu
         *
         * @return array
         */
        public function getCurlOptions(): array {
            $options                     = $this->curl_options;
            $options[CURLOPT_HTTPHEADER] = $this->getHeaders();

            # Basic auth
            if ($this->basicAuthUsername !== '' && $this->basicAuthPassword !== '') {
                $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
                $options[CURLOPT_USERPWD]  = $this->basicAuthUsername . ':' . $this->basicAuthPassword;
            }

            # Body senden
            if ($this->body !== null) {
                $options[CURLOPT_POSTFIELDS] = $this->body;
            }

            # Request Methode
            $options[CURLOPT_CUSTOMREQUEST] = $this->requestMethod;

            return $options;
        }

        /**
         * Eine Information aus dem letzten cUrl Request abrufen
         *
         * @param string $option
         *
         * @return mixed|null
         */
        public function curlLastInfo(string $option) {
            return $this->lastInfo[$option] ?? null;
        }

        /**
         * Legt die Request Methode fest
         *
         * @param string $method
         *
         * @return $this
         */
        public function method(string $method): Curl {
            $this->requestMethod = strtoupper($method);

            return $this;
        }

        /**
         * Fügt einen oder mehrere URL Parameter hinzu
         *
         * @param array $params The parameters to be added
         *
         * @return self Returns the instance of the current object
         */
        public function addUrlParams(array $params): self {
            $this->urlParams = array_replace_recursive($this->urlParams, $params);

            return $this;
        }

        /**
         * @return string
         */
        public function getUrl(): string {
            return url([$this->staticUrlPath, $this->path], $this->urlParams);
        }

        # -- Send request

        /**
         * Zum Ausführen eines cUrl Requests
         *
         * @param array $url_params Optional: request parameter
         *
         * @return BaseApiResponse
         */
        public function send(array $url_params = []): BaseApiResponse {
            $this->addUrlParams($url_params);
            $url = $this->getUrl();
            $ch  = curl_init($url);

            # cUrl Optionen festlegen
            curl_setopt_array($ch, $this->getCurlOptions());

            $this->lastResponse = curl_exec($ch);
            $this->lastInfo     = curl_getinfo($ch) ?: [];
            $this->lastOptions  = $this->getCurlOptions();
            curl_close($ch);


            return new BaseApiResponse($this->lastResponse);
        }

        /**
         * GET Request absenden
         *
         * @param string|null $path
         *
         * @return $this
         */
        public function get(?string $path = null): self {
            return $this->setPath($path)->method('GET');
        }

        /**
         * POST Request absenden
         *
         * @param string|null $path
         * @param null        $body
         *
         * @return $this
         */
        public function post(?string $path = null, $body = null): self {
            return $this->setPath($path)->method('POST')->setBody($body);
        }

        /**
         * PATCH Request absenden
         *
         * @param string|null $path
         *
         * @return $this
         */
        public function patch(?string $path = null): self {
            return $this->setPath($path)->method('PATCH');
        }

        /**
         * DELETE Request absenden
         *
         * @param string|null $path
         *
         * @return $this
         */
        public function delete(?string $path = null): self {
            return $this->setPath($path)->method('DELETE');
        }

    }
