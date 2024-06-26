<?php

    namespace Itrk\Helper;

    /**
     * Ein Resource Object bildet die Nutzdaten ab, die unter "data" im Response von der API zurück kommen.
     */
    class ItrkApiResource {

        protected array $data = [];

        public function __construct($data) {
            $this->data = (array)$data;
        }

        /**
         * @param array  $data
         * @param string $class
         *
         * @return array|self[]
         */
        public static function fabricate(array $data, $class = self::class): array {
            $class     = (class_exists($class) ? $class : self::class);
            $resources = [];
            foreach ($data as $resource_data) {
                $resources[] = new $class($resource_data);
            }

            return $resources;
        }

        public function get($key, $default = null) {
            return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
        }

        public function __get($key) {
            return $this->get($key);
        }

    }
