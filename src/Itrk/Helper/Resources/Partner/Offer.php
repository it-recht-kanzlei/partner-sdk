<?php

    namespace Itrk\Helper\Resources\Partner;

    use Itrk\Helper\ItrkApiResource;

    /**
     * @property string  $order_id    Bestellnummer
     * @property float   $total_price Gesamtpreis pro Monat
     * @property array[] $contracts   Verträge
     * @property string  $order       Base64-String der an uns zurückgesendet werden muss, um die Order zu platzieren
     * @property string  $checksum    Prüfsumme, die zusammen mit $order an uns zurück gesendet werden muss
     */
    class Offer extends ItrkApiResource {

        protected ?array $contracts = null;

        public function contracts(): ?array {
            $this->contracts ??= PreContract::fabricate($this->contracts);

            return $this->contracts;
        }

    }
