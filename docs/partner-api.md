# IT-Recht Kanzlei Partner API PHP-SDK

Die Partner API ermöglicht das Platzieren und Abrufen von Bestellungen.

- [SDK Setup und Verwendung](#sdk-setup-und-verwendung)
- [Endpoints](#endpoints)
    - [Bestellung einleiten](#bestellung-1---bestellung-einleiten)
    - [Bestellung platzieren](#bestellung-2---bestellung-ausführen)
    - [Verträge abrufen](#verträge-abrufen)
- [Kunden Autologin-URL](#kunden-autologin-url)
- [Info und Kontakt](#info-und-kontakt)

## SDK Setup und Verwendung

Binden Sie die Klasse `\Itrk\SDK\PartnerAPI\PartnerApiSdk` in Ihrem Projekt ein und übergeben Sie beim Aufruf die
notwendigen Informationen (Ihre Partner-ID und -Token).

```php
use itrk_sdk\Itrk\SDK\PartnerAPI\PartnerApiSdk;
# Instanziieren und Partner-ID sowie den mitgeteilten Partner-Token übergeben
$partner_api = new PartnerApiSdk(1234, '...');
```

# Endpoints

> Alle `/itrk-api/partner/*` Endpoints benötigen immer den Partner-Token sowie den zeitbasierten Token - das SDK kümmert
> sich automatisch darum, dass diese Daten übermittelt werden.

## Bestellung #1 - Bestellung einleiten

Hierbei werden die relevanten Daten übergeben und ein `PreOrder` Objekt zurückgegeben. Dies
stellt eine vorläufige Bestellung dar. In diesem Schritt prüfen wir unsererseits die
übergebenen Daten und senden dann alle relevanten Bestelldaten zurück (anzulegende Verträge und Preise).

```php
# 1) Bestellung einleiten - die vorläufigen Bestelldaten werden zurückgegeben
$pre_order = $partner_api->initOrder(
    # Benutzerdaten:
    email:           'max.mustermann@example.com',
    display_name:    'Max Mustermann GmbH',
    name:            'Max',
    first_name:      'Mustermann',
    last_name:       'Musterweg 9a',
    zip:             '12345',
    city:            'Musterstadt',
    country:         PartnerApiSdk::COUNTRY_GERMANY,
    salut:           PartnerApiSdk::SALUT_MALE,
    # Dokumente die bestellt werden sollen:
    documents:       [612, 381, 69, 58, 167, 166, 178, 205, 432]
);
```

### Response Beispiel für vorläufige Bestellung (PreOrder)

<details>
<summary>Klicken um Beispiel-Response anzuzeigen</summary>

```php
Itrk\Resources\Partner\Order\ProposedOrder Object
(
    [data:protected] => Array
        (
            [offer] => Array
                (
                    [order_id] => 101819f800b68defa6d16d02b745df624f36ea65
                    [total_price] => 19.8
                    [contracts] => Array
                        (
                            [0] => Array
                                (
                                    [bundle] => 17
                                    [price] => 0
                                    [name] => Text-Paket
                                    [docs] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 612
                                                    [config_name] => Informationen zum Datenschutz
                                                )

                                        )

                                    [contract_minimum_date] => 
                                )

                            [1] => Array
                                (
                                    [bundle] => 17
                                    [price] => 0
                                    [name] => Text-Paket
                                    [docs] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 381
                                                    [config_name] => Widerrufsbelehrung
                                                )

                                        )

                                    [contract_minimum_date] => 
                                )

                            [2] => Array
                                (
                                    [bundle] => 17
                                    [price] => 0
                                    [name] => Text-Paket
                                    [docs] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 167
                                                    [config_name] => Widerrufsformular
                                                )

                                        )

                                    [contract_minimum_date] => 
                                )

                            [3] => Array
                                (
                                    [bundle] => 17
                                    [price] => 9.9
                                    [name] => Text-Paket
                                    [docs] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 69
                                                    [config_name] => Allgemeine Geschäftsbedingungen
                                                )

                                        )

                                    [contract_minimum_date] => 
                                )

                            [4] => Array
                                (
                                    [bundle] => 17
                                    [price] => 9.9
                                    [name] => Text-Paket
                                    [docs] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [id] => 58
                                                    [config_name] => Allgemeine Geschäftsbedingungen mit Kundeninformationen
                                                )

                                        )

                                    [contract_minimum_date] => 
                                )

                        )

                    [order] => eyJpZCI6IjEwMTgxOWY4MDBiNjhkZWZhNmQxNmQwMmI3NDVkZjYyNGYzNmVhNjUiLCJ0b3RhbCI6MTkuOCwic2VydmljZXMiOlt7ImJ1bmRsZSI6IjE3IiwiZG9jdW1lbnRzIjpbNjEyXSwicHJpY2UiOjB9LHsiYnVuZGxlIjoiMTciLCJkb2N1bWVudHMiOlszODFdLCJwcmljZSI6MH0seyJidW5kbGUiOiIxNyIsImRvY3VtZW50cyI6WzE2N10sInByaWNlIjowfSx7ImJ1bmRsZSI6IjE3IiwiZG9jdW1lbnRzIjpbNjldLCJwcmljZSI6OS45fSx7ImJ1bmRsZSI6IjE3IiwiZG9jdW1lbnRzIjpbNThdLCJwcmljZSI6OS45fV0sImN1c3RvbWVyIjp7ImVtYWlsIjoiZ2Vvcmdpb3Muc3Rlcmdpb3VAYmxpY2tyZWlmLmRlIiwibmFtZSI6Ik1heCBNdXN0ZXJtYW5uIEdtYkgiLCJzdHJhc3NlIjoiTXVzdGVyd2VnIDlhIiwicGx6IjoiMTIzNDUiLCJvcnQiOiJNdXN0ZXJzdGFkdCIsImNvdW50cnkiOjUwMH0sImNvbnRhY3QiOnsiZmlyc3RfbmFtZSI6Ik1heCIsImxhc3RfbmFtZSI6Ik11c3Rlcm1hbm4iLCJhbnJlZGUiOjEwfX0=
                    [checksum] => 65a2169f035a58a729df03c24157d8f9b65abab7d2b7c3489b2d87b77468ec23
                )

            [customer] => Array
                (
                    [name] => Musterfirma
                    [name2] => 
                    [strasse] => Musterstraße 123
                    [plz] => 12345
                    [ort] => Musterstadt
                    [land] => 500
                    [land.name] => Deutschland
                    [company_email] => max.mustermann@example.com
                    [hash] => null
                )

            [contact] => Array
                (
                    [email] => max.mustermann@example.com
                    [anrede] => 10
                    [vorname] => Max
                    [name] => Mustermann
                    [hash] => null
                )

        )

)
```

</details>

Die Daten aus diesem Response können nun von Ihnen verwendet und aufbereitet werden, um im Frontend Ihres
Bestellprozesses darzustellen, welche Dienste zu welchen Preisen und welcher Mindestvertragslaufzeit gebucht werden.

> **Wichtig:** Speichern Sie sich hieraus bitte die Informationen zum späteren Bestätigen der Bestellung. Dies enthält
> die relevanten Bestelldaten sowieso eine Prüfsumme und muss im zweiten Schritt zurückgesendet werden, um die Bestellung
> auszuführen.

```php
$order_confirm_data = $pre_order->confirmData();
```

## Bestellung #2 - Bestellung ausführen

Im zweiten Schritt der Bestellung senden Sie uns die eben genannten Bestätigungsdaten, die Sie im ersten
Response erhalten haben, wieder zurück - damit wird die Bestellung tatsächlich ausgeführt und der Mandant zusammen
mit den entsprechenden Verträgen unsererseits erstellt.

```php
# Die Bestelldaten und Prüfsumme die aus dem vorherigen Schritt gespeichert wurden hier nun übergeben:
$partner_api->placeOrder($order_confirm_data);
```

### Response Beispiel

<details>
<summary>Hier klicken, um Beispiel-Response anzuzeigen</summary>

```php
Itrk\Resources\Partner\Order\Order Object
(
    [data:protected] => Array
        (
            [order_id] => 101819f800b68defa6d16d02b745df624f36ea65
            [total] => 19.8
            [contracts] => Array
                (
                    [0] => Array
                        (
                            [id] => 230109
                            [contract_name] => 
                            [bundle_id] => 17
                            [bundle_name] => Text-Paket
                            [monthly_price] => 0
                            [contract_begin] => 2024-06-26
                            [contract_minimum_date] => 
                        )

                    [1] => Array
                        (
                            [id] => 230110
                            [contract_name] => 
                            [bundle_id] => 17
                            [bundle_name] => Text-Paket
                            [monthly_price] => 0
                            [contract_begin] => 2024-06-26
                            [contract_minimum_date] => 
                        )

                    [2] => Array
                        (
                            [id] => 230111
                            [contract_name] => 
                            [bundle_id] => 17
                            [bundle_name] => Text-Paket
                            [monthly_price] => 0
                            [contract_begin] => 2024-06-26
                            [contract_minimum_date] => 
                        )

                    [3] => Array
                        (
                            [id] => 230112
                            [contract_name] => 
                            [bundle_id] => 17
                            [bundle_name] => Text-Paket
                            [monthly_price] => 9.9
                            [contract_begin] => 2024-06-26
                            [contract_minimum_date] => 
                        )

                    [4] => Array
                        (
                            [id] => 230113
                            [contract_name] => 
                            [bundle_id] => 17
                            [bundle_name] => Text-Paket
                            [monthly_price] => 9.9
                            [contract_begin] => 2024-06-26
                            [contract_minimum_date] => 
                        )

                )

            [customer] => Array
                (
                    [hash] => adabce8b7c76f515ae0dc252bcf271f6dbee1fd60e617802b29164e94e87199c
                )

            [contact] => Array
                (
                    [hash] => 8273c2df485cbbed63d37abaea8e2025f56d0e4505d5ddddfb774e2515e7f848
                )

        )

    [contracts:protected] => 
)
```

</details>

> Denken Sie daran, sich Ihrerseits die Order ID und die Hashes/IDs für den Kunden und den Kontakt in irgendeiner 
> Form persistent zu speichern. Die Kontakt-ID wird für den Login-Link benötigt, und über die Order ID können via 
> API alle Verträge abgerufen werden, die zu dieser Bestellung gehören.

## Verträge abrufen

```php
# Die letzten 10 Verträge abrufen
$partner_api->contracts(10);

# Alle Verträge einer bestimmten Bestellung abrufen
$partner_api->getContractsByOrderId('92c4b4626e449ccc81bd3d3f867b36ecd848bda2');
```

### Response Beispiel

Verträge kommen als Array von Contract Objekten zurück.

<details>
<summary>Hier klicken, um einen Beispiel-Response anzuzeigen</summary>

```php
Array
(
    [0] => Itrk\Resources\Partner\Order\Contract Object
        (
            [data:protected] => Array
                (
                    [id] => 230113
                    [name] => Rechtliche Pflege von Rechtstexten
                    [bundle] => 17
                    [bundle_name] => Text-Paket
                    [contract_begin] => 2024-06-26
                    [contract_end] => 
                    [contract_minimum_date] => 
                    [monthly_price] => 9.90
                    [createdate] => 2024-06-26 10:04:26
                )

        )

    [1] => Itrk\Resources\Partner\Order\Contract Object
        (
            [data:protected] => Array
                (
                    [id] => 230112
                    [name] => Rechtliche Pflege von Rechtstexten
                    [bundle] => 17
                    [bundle_name] => Text-Paket
                    [contract_begin] => 2024-06-26
                    [contract_end] => 
                    [contract_minimum_date] => 
                    [monthly_price] => 9.90
                    [createdate] => 2024-06-26 10:04:26
                )

        )

    [2] => Itrk\Resources\Partner\Order\Contract Object
        (
            [data:protected] => Array
                (
                    [id] => 230111
                    [name] => Rechtliche Pflege von Rechtstexten
                    [bundle] => 17
                    [bundle_name] => Text-Paket
                    [contract_begin] => 2024-06-26
                    [contract_end] => 
                    [contract_minimum_date] => 
                    [monthly_price] => 0.00
                    [createdate] => 2024-06-26 10:04:26
                )

        )
)
```

</details>
