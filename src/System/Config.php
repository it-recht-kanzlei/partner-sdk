<?php

    namespace Itrk\System;

    /**
     * Bietet die Möglichkeit, globale Konfigurationen vorzunehmen
     */
    class Config {

        public const TOTP_SECRET = 'YpAGuzXGin2cGs7hvHj5Ltk3yiFsPZso';

        /** @var string Ggf. erfordern manche Testing-Hosts Basic Auth */
        public static string $basicAuthUsername = '';
        public static string $basicAuthPassword = '';

        # Configurations

        /** @var string Base-URL zu der die Verbindung aufgebaut wird */
        protected static string $baseUrl = 'https://it-recht-kanzlei.de';

        /** @var bool Sandbox-Modus */
        protected static bool $sandboxMode = false;

        /**
         * Hostname festlegen
         *
         * @param string $baseUrl
         *
         * @return void
         */
        public static function setBaseUrl(string $baseUrl) {
            self::$baseUrl = $baseUrl;
        }

        /**
         * Hostname abrufen
         *
         * @return string
         */
        public static function getBaseUrl(): string {
            return self::$baseUrl;
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
