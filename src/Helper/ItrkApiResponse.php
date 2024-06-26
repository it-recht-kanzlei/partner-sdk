<?php

    namespace Itrk\Helper;

    use function Itrk\Functions\get_array_item;

    class ItrkApiResponse {

        protected string $body = '';
        protected array $data = [];

        public function __construct($data) {
            $this->body = (string)$data;
            $this->data = json_decode($this->body, true) ?: [];
        }

        public function get($key, $default = null) {
            return get_array_item($this->data, $key, $default);
        }

        public function toString(): string {
            return $this->body;
        }

        public function toArray() {
            return $this->data;
        }

        /**
         * @return array
         */
        public function data() {
            return (array)$this->get('data');
        }

        /**
         * @param string $class
         *
         * @return ItrkApiResource
         */
        public function toResource(string $class = ItrkApiResource::class): ItrkApiResource {
            $class = (class_exists($class) ? $class : ItrkApiResource::class);

            return new $class($this->data());
        }

        /**
         * @param string $class
         *
         * @return array|ItrkApiResource[]
         */
        public function toResources(string $class = ItrkApiResource::class): array {
            return ItrkApiResource::fabricate($this->data(), $class);
        }

    }
