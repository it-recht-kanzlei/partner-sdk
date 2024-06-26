<?php

    namespace Itrk\Helper\Resources\Partner;

    use Itrk\Helper\ItrkApiResource;
    use Itrk\Helper\Resources\Document;

    /**
     * Vorläufige Vertragsdaten
     *
     * @property string|int  $bundle                Bundle-ID
     * @property float       $price                 Monatlicher Preis des Vertrags
     * @property string      $name                  Name des Vertrags
     * @property array       $docs                  Dokumente
     * @property null|string $contract_minimum_date Mindestvertragslaufzeit
     */
    class PreContract extends ItrkApiResource {

        protected ?array $documents = null;

        public function documents() {
            $this->documents ??= Document::fabricate($this->docs);

            return $this->documents;
        }

    }
