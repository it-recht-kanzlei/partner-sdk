<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * @property string  $order_id    Bestellnummer
     * @property float   $total_price Gesamtpreis pro Monat
     * @property array[] $contracts   Verträge
     * @property string  $order_data        Base64-String der an uns zurückgesendet werden muss, um die Order zu platzieren
     */
    class Offer extends BaseApiResource {

        /** @var array|null|ProposedContract */
        protected ?array $offered_contracts = null;

        /**
         * Gibt vorläufige Verträge zurück
         *
         * @return array|null|ProposedContract[]
         */
        public function contracts(): ?array {
            $this->offered_contracts ??= ProposedContract::fabricate($this->contracts, ProposedContract::class);

            return $this->offered_contracts;
        }

    }
