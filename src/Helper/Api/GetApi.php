<?php

    namespace Itrk\Helper\Api;

    use Itrk\Helper\Curl;
    use Itrk\Helper\ItrkApi;
    use Itrk\Helper\ItrkApiResource;
    use Itrk\Helper\Resources\Country;
    use Itrk\Helper\Resources\Document;

    /**
     * Diese Klasse stellt Methoden bereit für den Zugriff auf die offene ITRK API.
     * Eine Authentifizierung ist hier für keinen der Endpoints erforderlich.
     */
    class GetApi extends ItrkApi {

        public function curl(): Curl {
            return parent::curl()->prependUrlPath('itrk-api/get');
        }

        /**
         * Gibt eine Liste von Dokumenten zurück die im Bestellprozess gebucht werden können
         *
         * @return ItrkApiResource[]|Document[]
         */
        public function documents() {
            return $this->curl()->get('documents')->send()->toResources(Document::class);
        }

        /**
         * Gibt ein einzelnes Dokument anhand der übergebenen ID zurück
         *
         * @param int $id
         *
         * @return ItrkApiResource|Document
         */
        public function document(int $id) {
            return $this->curl()->get('document')->send(['id' => $id])->toResource(Document::class);
        }

        /**
         * Gibt eine Liste von Ländern mit deren Ländercode zurück
         *
         * @return ItrkApiResource[]|Country[]
         */
        public function countries() {
            return $this->curl()->get('countries')->send()->toResources(Country::class);
        }

    }
