<?php

    namespace Itrk\Helper;

    use function Itrk\Functions\get_array_item;

    /**
     * Diese Klasse kapselt den Response der Api in ein dafür vorgesehenes (hiervon erbendes) Objekt.
     */
    class ItrkApiResponse {

        protected string $body = '';
        protected array $data = [];

        /**
         * @param $data
         */
        public function __construct($data) {
            $this->body = (string)$data;
            $this->data = json_decode($this->body, true) ?: [];
        }

        /**
         * Gibt einen Wert aus dem Array zurück oder einen Standardwert
         *
         * @param mixed $key
         * @param mixed $default
         *
         * @return mixed|null
         */
        public function get($key, $default = null) {
            return get_array_item($this->data, $key, $default);
        }

        /**
         * Gibt den Response body als String zurück
         *
         * @return string
         */
        public function toString(): string {
            return $this->body;
        }

        /**
         * Gibt den gesamten Response als Array zurück
         *
         * @return array|mixed
         */
        public function toArray() {
            return $this->data;
        }

        /**
         * @return array
         */
        public function data(): array {
            return (array)$this->get('data');
        }

        /**
         * Gibt ein Resource Objekt zurück
         *
         * @param string $class
         *
         * @return ItrkApiResource
         */
        public function toResource(string $class = ItrkApiResource::class): ItrkApiResource {
            $class = (class_exists($class) ? $class : ItrkApiResource::class);

            return new $class($this->data());
        }

        /**
         * Gibt ein Array von Resource Objekten zurück
         *
         * @param string $class
         *
         * @return array|ItrkApiResource[]
         */
        public function toResources(string $class = ItrkApiResource::class): array {
            return ItrkApiResource::fabricate($this->data(), $class);
        }

    }
