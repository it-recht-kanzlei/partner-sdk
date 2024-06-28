<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;
    use Itrk\Resources\PublicData\Document;

    /**
     * Vorläufige Vertragsdaten
     *
     * @property string|int  $bundle                Bundle-ID
     * @property float       $price                 Monatlicher Preis des Vertrags
     * @property string      $name                  Name des Vertrags
     * @property array[]     $docs                  Dokumente
     * @property null|string $contract_minimum_date Mindestvertragslaufzeit
     */
    class ProposedContract extends BaseApiResource {

        /** @var array|null|Document[] $documents */
        protected ?array $documents = null;

        /**
         * @return array|BaseApiResource[]|null|Document[]
         */
        public function documents(): ?array {
            $this->documents ??= Document::fabricate($this->docs);

            return $this->documents;
        }

    }
