<?php

    namespace Itrk\Api;

    use Itrk\Resources\BaseApiResource;
    use Itrk\Resources\PublicData\Country;
    use Itrk\Resources\PublicData\Document;
    use Itrk\System\Net\Curl;

    /**
     * Diese Klasse stellt Methoden bereit für den Zugriff auf die offene ITRK API.
     * Eine Authentifizierung ist hier für keinen der Endpoints erforderlich.
     */
    class PublicData extends BaseApi {

        /**
         * Parameterisiert die cUrl Verbindung und gibt sie zurück
         *
         * @return Curl
         */
        public function curl(): Curl {
            return parent::curl()->prependUrlPath('itrk-api/get');
        }

        /**
         * Gibt eine Liste von Dokumenten zurück die im Bestellprozess gebucht werden können
         *
         * @return BaseApiResource[]|Document[]
         */
        public function documents(): array {
            return $this->curl()->get('documents')->send()->toResources(Document::class);
        }

        /**
         * Gibt ein einzelnes Dokument anhand der übergebenen ID zurück
         *
         * @param int $id
         *
         * @return BaseApiResource|Document
         */
        public function document(int $id) {
            return $this->curl()->get('document')->send(['id' => $id])->toResource(Document::class);
        }

        /**
         * Gibt eine Liste von Ländern mit deren Ländercode zurück
         *
         * @return BaseApiResource[]|Country[]
         */
        public function countries(): array {
            return $this->curl()->get('countries')->send()->toResources(Country::class);
        }

    }
