<?php

    namespace Itrk\Resources\Partner\Order;

    use Itrk\Resources\BaseApiResource;

    /**
     * Vorläufige Kontakt- / Benutzerdaten
     *
     * @property string     $email
     * @property string|int $anrede (10=Male, 11=Female, 12=Others) s. Config::SALUT_*
     * @property string     $vorname
     * @property string     $name
     * @property string     $hash
     */
    class ProposedContact extends BaseApiResource {

    }
