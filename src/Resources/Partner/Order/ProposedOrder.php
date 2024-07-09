<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * Vorläufige Bestelldaten
     *
     * @param array $offer    Angebotsdaten - enthält anzulegende Verträge und Preise
     * @param array $customer Kundendaten
     * @param array $contact  Kontaktdaten / Benutzerdaten
     */
    class ProposedOrder extends BaseApiResource {

        protected ?Offer $offer;
        protected ?ProposedContact $contact;
        protected ?ProposedCustomer $customer;

        /**
         * @return Offer|null
         */
        public function offer(): ?Offer {
            $this->offer ??= new Offer($this->get('offer'));

            return $this->offer;
        }

        /**
         * @return ProposedContact|null
         */
        public function contact(): ?ProposedContact {
            $this->contact ??= new ProposedContact($this->get('contact'));

            return $this->contact;
        }

        /**
         * @return ProposedCustomer|null
         */
        public function customer(): ?ProposedCustomer {
            $this->customer ??= new ProposedCustomer($this->get('customer'));

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
         * @return string
         */
        public function confirmData(): string {
            return $this->offer()->data;
        }

    }
