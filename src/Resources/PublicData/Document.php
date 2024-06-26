<?php

    namespace Itrk\Resources\PublicData;

    use Itrk\Resources\BaseApiResource;

    /**
     * @property int    id                     Die ID mit der ein Dokument bei einer Bestellung gebucht werden kann
     * @property string $config_name           Anzeigename des Dokuments
     * @property float  document_monthly_price Monatliche Kosten
     */
    class Document extends BaseApiResource {

    }
