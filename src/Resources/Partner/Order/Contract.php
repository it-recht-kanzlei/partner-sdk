<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * Vertragsdaten
     *
     * @property int         $id                              ITRK Vertrags-ID
     * @property string      $contract_name                   ITRK-Vertragsname
     * @property int         $bundle_id                       Bundle-ID
     * @property float       $monthly_price                   Monatlicher Preis des Vertrags
     * @property string      $contract_begin                  Datum des Vertragsbeginns
     * @property null|string $contract_minimum_date           Mindestvertragslaufzeit
     */
    class Contract extends BaseApiResource {

    }
