<?php

    namespace Itrk\Resources;

    /**
     * Ein Resource Object bildet die Nutzdaten ab, die unter "data" im Response von der API zurück kommen.
     */
    class BaseApiResource implements \ArrayAccess {

        /**
         * Diese property hält die Nutzdaten, die die API zurückliefert (also das was unter "data" im JSON zu finden
         * ist).
         *
         * @var array
         */
        protected array $data = [];

        /**
         * @param $data
         */
        public function __construct($data) {
            $this->data = (array)$data;
        }

        /**
         * @param array|mixed $data
         * @param string      $class
         *
         * @return array|self[]
         */
        public static function fabricate($data, $class = self::class): array {
            if (!is_array($data)) {
                return [];
            }
            $class     = (class_exists($class) ? $class : self::class);
            $resources = [];
            foreach ($data as $resource_data) {
                $resources[] = new $class($resource_data);
            }

            return $resources;
        }

        /**
         * Prüft, ob der angefragte Key existiert
         *
         * @param $key
         *
         * @return bool
         */
        public function has($key): bool {
            return array_key_exists($key, $this->data);
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
            return $this->has($key) ? $this->data[$key] : $default;
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

        public function offsetExists($offset): bool {
            return $this->has($offset);
        }

        #[\ReturnTypeWillChange] public function offsetGet($offset) {
            return $this->get($offset);
        }

        public function offsetSet($offset, $value): void {
        }

        public function offsetUnset($offset): void {
        }

    }
