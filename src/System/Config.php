<?php

    namespace Itrk\System;

    /**
     * Bietet die Möglichkeit, globale Konfigurationen vorzunehmen
     */
    class Config {

        public const TOTP_SECRET = 'YpAGuzXGin2cGs7hvHj5Ltk3yiFsPZso';

        # Anrede
        public const SALUT_MALE   = 10;
        public const SALUT_FEMALE = 11;
        public const SALUT_OTHERS = 12;

        /** @var int Länder-ID Eine Liste der möglichen Länder IDs kann unter `/itrk-api/get/countries` (offener Endpunkt) abgerufen werden */
        public const COUNTRY_GERMANY = 500;

        /** @var string Ggf. erfordern manche Testing-Hosts Basic Auth */
        public static string $basicAuthUsername = '';
        public static string $basicAuthPassword = '';

        # Configurations

        protected static string $hostname = 'it-recht-kanzlei.de';
        protected static bool $sandboxMode = false;

        /**
         * Hostname festlegen
         *
         * @param string $hostname
         *
         * @return void
         */
        public static function setHostname(string $hostname) {
            self::$hostname = $hostname;
        }

        /**
         * Hostname abrufen
         *
         * @return string
         */
        public static function getHostname(): string {
            return self::$hostname;
        }

        /**
         * Sandbox-Modus aktivieren/deaktivieren
         *
         * @param bool $set
         *
         * @return void
         */
        public static function setSandboxMode(bool $set = true) {
            self::$sandboxMode = $set;
        }

        /**
         * Prüft, ob der Sandbox-Modus aktiv ist
         *
         * @return bool
         */
        public static function isSandboxMode(): bool {
            return self::$sandboxMode;
        }

        /**
         * Basic Auth Daten festlegen
         *
         * @param string $username
         * @param string $password
         */
        public static function setBasicAuth(string $username, string $password) {
            self::$basicAuthUsername = $username;
            self::$basicAuthPassword = $password;
        }

    }
