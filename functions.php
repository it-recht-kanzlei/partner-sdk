<?php

    namespace Itrk\Functions;

    use Itrk\Helper\Config;

    /**
     * @param string $to
     *
     * @return string
     */
    function itrk_path(string $to = ''): string {
        $to = trim($to, DIRECTORY_SEPARATOR);

        return ITRK_DIR . ($to === '' ? '' : DIRECTORY_SEPARATOR . $to);
    }

    /**
     * Baut eine URL für den hinterlegten Host und gibt sie zurück
     *
     * @param string      $to
     * @param array       $params
     * @param string|null $hostname
     *
     * @return string
     */
    function url(string $to = '', array $params = [], ?string $hostname = null): string {
        $url = 'https://' . ($hostname ?? Config::getHostname());
        $to  = str_replace('/', '/', trim($to, '/'));
        $to  = $to === '' ? '' : '/' . $to;

        $data = [];
        if (Config::isSandboxMode()) {
            $data['sandbox'] = 1;
        }
        $data = array_replace($data, $params);

        return $url . $to . ($params ? '?' . http_build_query($data) : '');
    }

    /**
     * Legacy-Version des zeitbasierten Tokens.
     *
     * @return string
     * @deprecated Verwenden Sie stattdessen
     *
     */
    function legacy_token() {
        return sha1(date('YmdH', time()) . 'jVyDG2gMJVK4Xhiu');
    }

    /**
     * Generiert einen zeitbasierten Token
     *
     * @param string      $data      Optional zusätzliche Daten
     * @param string|null $secret    Optional: ggf. erfordert in Zukunft ein API Call ein anderes Secret als das
     *                               Standard-Secret
     * @param int|null    $period    Optional: Die Dauer die der Token gültig ist - standardmäßig 1 Stunde.
     *                               Modifizieren Sie diesen Wert nur, wenn wir Ihnen für den jeweiligen
     *                               Anwandungsfall explizit mitgeteilt haben, dass ein anderer Wert als der
     *                               Standardwert verwendet werden soll.
     * @param int         $maxlength Optional: Länge auf die der Token gekürzt wird.
     *                               Modifizieren Sie diesen Wert nur, wenn explizit angefordert.
     *
     * @return string
     */
    function totp(string $data = '', ?string $secret = null, ?int $period = 3600, int $maxlength = 0): string {
        $secret = $secret ?? Config::TOTP_SECRET;
        $hash   = hash('sha256', (string)(int)(time() / $period) . $secret . $data);

        return ($maxlength ? substr($hash, 0, abs($maxlength)) : $hash);
    }

    /**
     * Gibt ein Item aus einem Array zurück oder einen angegebenen Standardwert
     *
     * @param array $array
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed|null
     */
    function get_array_item(array $array, $key, $default = null) {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }
