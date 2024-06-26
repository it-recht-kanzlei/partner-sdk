<?php

    namespace Itrk\Helper\Resources\Partner;

    use Itrk\Helper\ItrkApiResource;

    /**
     * Vorläufige Kundendaten
     *
     * @property string     $name          Kunden-Anzeigename
     * @property string     $name2         Alternativer Anzeigename
     * @property string     $strasse       Straße
     * @property string|int $plz           Postleitzahl
     * @property string     $ort           Ort/Stadt
     * @property string|int $land          Ländercode (500=DE)
     * @property string     $company_email E-Mail Adresse
     * @property string     $hash          Hash
     */
    class PreCustomer extends ItrkApiResource {

    }
