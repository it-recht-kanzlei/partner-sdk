<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * Vertragsdaten
     *
     * @property int         $id                                   ITRK Vertrags-ID
     * @property string      $name                                 ITRK-Vertragsname
     * @property int         $bundle                               Bundle-ID
     * @property string      bundle_name                           Name des Bundles
     * @property float       $monthly_price                        Monatlicher Preis des Vertrags
     * @property string      $contract_begin                       Datum des Vertragsbeginns
     * @property string|null $contract_end                         Datum des Vertragsendes
     * @property string|null $contract_minimum_date                Mindestvertragslaufzeit
     * @property string|null $createdate                           Erstelldatum
     * @property string      $order_id                             Erstelldatum
     */
    class Contract extends BaseApiResource {

    }
