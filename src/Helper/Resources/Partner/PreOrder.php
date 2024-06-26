<?php

    namespace Itrk\Helper\Resources\Partner;

    use Itrk\Helper\ItrkApiResource;

    /**
     * Vorläufige Bestelldaten
     *
     * @param array $offer    Angebotsdaten - enthält anzulegende Verträge und Preise
     * @param array $customer Kundendaten
     * @param array $contact  Kontaktdaten / Benutzerdaten
     */
    class PreOrder extends ItrkApiResource {

        protected ?Offer $offer;
        protected ?PreContact $contact;
        protected ?PreCustomer $customer;

        /**
         * @return Offer|null
         */
        public function offer(): ?Offer {
            $this->offer ??= new Offer($this->get('offer'));

            return $this->offer;
        }

        /**
         * @return PreContact|null
         */
        public function contact(): ?PreContact {
            $this->contact ??= new PreContact($this->get('contact'));

            return $this->contact;
        }

        /**
         * @return PreCustomer|null
         */
        public function customer(): ?PreCustomer {
            $this->customer ??= new PreCustomer($this->get('customer'));

            return $this->customer;
        }

        /**
         * @return string
         */
        public function orderId(): string {
            return $this->offer()->order_id;
        }

        /**
         * Diese Daten werden für den nächsten Schritt benötigt, um die Bestellung mit den festgelegten Parametern
         * verbindlich auszuführen.
         *
         * @return array[]
         */
        public function confirmData(): array {
            return ['order' => ['data' => $this->offer()->order, 'checksum' => $this->offer()->checksum]];
        }

    }
