<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * Daten der ausgeführten Bestellung
     *
     * @param string $order_id
     * @param float  $total
     * @param array  $contracts
     */
    class Order extends BaseApiResource {

        /** @var array|null|Contract[] */
        protected ?array $contracts = null;

        /** @var Contact|null $contact */
        protected ?Contact $contact;

        /** @var Customer|null $customer */
        protected ?Customer $customer;

        /**
         * @return array|Contract[]
         */
        public function contracts(): ?array {
            $this->contracts ??= Contract::fabricate($this->contracts);

            return $this->contracts;
        }

        /**
         * @return Contact|null
         */
        public function contact(): ?Contact {
            $this->contact ??= new Contact($this->get('contact'));

            return $this->contact;
        }

        /**
         * @return Customer|null
         */
        public function customer(): ?Customer {
            $this->customer ??= new Customer($this->get('customer'));

            return $this->customer;
        }

    }
