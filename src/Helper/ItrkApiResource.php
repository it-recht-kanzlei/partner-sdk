<?php

    namespace Itrk\Helper;

    /**
     * Ein Resource Object bildet die Nutzdaten ab, die unter "data" im Response von der API zurück kommen.
     */
    class ItrkApiResource {

        protected array $data = [];

        /**
         * @param $data
         */
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

        /**
         * Key aus Daten-Array holen oder Standardwert zurückgeben
         *
         * @param mixed $key
         * @param mixed $default
         *
         * @return mixed|null
         */
        public function get($key, $default = null) {
            return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
        }

        /**
         * Magic getter
         *
         * @param $key
         *
         * @return mixed|null
         */
        public function __get($key) {
            return $this->get($key);
        }

    }
