<?php

    namespace Itrk\Helper;

    /**
     * Allgemeine API Klasse.
     * Die entsprechenden Kindklassen überschreiben ggf. die curl() Methode und deklarieren
     * je endpoint eine Methode.
     */
    class ItrkApi {

        /**
         * @return Curl
         */
        public function curl(): Curl {
            return Curl::create();
        }

    }
