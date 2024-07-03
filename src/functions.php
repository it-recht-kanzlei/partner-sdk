<?php

    namespace Itrk;

    use Itrk\System\Config;

    /**
     * Baut eine URL für den hinterlegten Host und gibt sie zurück
     *
     * @param string|array $to     URI Pfad
     * @param array        $params Optional: Request Parameter
     *
     * @return string
     */
    function url($to = '', array $params = []): string {
        $to = (array)$to;
        foreach ($to as $k => &$path) {
            $path = trim((string)$path, '/');
            if ($path === '') {
                unset($to[$k]);
            }
        }
        $url = Config::getBaseUrl();

        $data = [];
        if (Config::isSandboxMode()) {
            $data['sandbox'] = 1;
        }
        $data = array_replace($data, $params);

        return $url . ($to ? '/' . implode('/', $to) : '') . ($params ? '?' . http_build_query($data) : '');
    }

    /**
     * Legacy-Version des zeitbasierten Tokens.
     *
     * @return string
     * @deprecated Verwenden Sie stattdessen
     *
     */
    function legacy_token(): string {
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
     *
     * @return string
     */
    function totp(string $data = '', ?string $secret = null, ?int $period = 3600): string {
        return hash('sha256', (int)(time() / $period) . ($secret ?? Config::TOTP_SECRET) . $data);
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
