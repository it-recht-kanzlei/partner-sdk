<?php

    namespace Itrk\Helper;

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

        public static function setHostname(string $hostname) {
            self::$hostname = $hostname;
        }

        public static function getHostname() {
            return self::$hostname;
        }

        public static function setSandboxMode(bool $set = true) {
            self::$sandboxMode = $set;
        }

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
