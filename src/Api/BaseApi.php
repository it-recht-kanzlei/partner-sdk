<?php

    namespace Itrk\Api;

    use Itrk\System\Net\Curl;

    /**
     * Allgemeine API Klasse.
     * Die entsprechenden Kindklassen überschreiben ggf. die curl() Methode und deklarieren
     * je endpoint eine Methode.
     */
    class BaseApi {

        /**
         * Gibt das (und ggf. vorkonfigurierte) Curl Objekt zurück, das für das aktuelle Api Objekt verwendet werden
         * soll.
         *
         * @return Curl
         */
        public function curl(): Curl {
            return Curl::create();
        }

    }
