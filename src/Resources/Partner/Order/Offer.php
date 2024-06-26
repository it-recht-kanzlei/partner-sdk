<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * @property string  $order_id    Bestellnummer
     * @property float   $total_price Gesamtpreis pro Monat
     * @property array[] $contracts   Verträge
     * @property string  $order       Base64-String der an uns zurückgesendet werden muss, um die Order zu platzieren
     * @property string  $checksum    Prüfsumme, die zusammen mit $order an uns zurück gesendet werden muss
     */
    class Offer extends BaseApiResource {

        /** @var array|null|ProposedContract */
        protected ?array $contracts = null;

        /**
         * Gibt vorläufige Verträge zurück
         *
         * @return array|null|ProposedContract
         */
        public function contracts(): ?array {
            $this->contracts ??= ProposedContract::fabricate($this->contracts);

            return $this->contracts;
        }

    }
