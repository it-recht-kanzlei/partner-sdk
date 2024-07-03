# IT-Recht Kanzlei PHP-SDK

Dieses SDK bietet Unterstützung bei der Einrichtung und Verbindung unserer Dienste und APIs.

# Einbinden des SDK

Fügen Sie das SDK wie gewöhnlich via Composer hinzu:

```shell
composer require it-recht-kanzlei/itrk-partner-sdk
```

Die Partner-API dient zum Ausführen von Bestellungen und Abrufen von Verträgen.

**[Anleitung zur Verwendung der Partner API aufrufen](docs/partner-api.md)**

# Startparameter (Optional)

## Auf Testumgebung arbeiten

Wir haben Ihnen ggf. mitgeteilt, ob und welchen unserer Server Sie zum Testen verwenden können. Legen Sie diesen
einmalig fest.

```php
\Itrk\System\Config::setBaseUrl('https://testsystem.it-recht-kanzlei.de');
```

Ggf. wird ein Basic Auth benötigt, die entsprechenden Daten können Sie wie folgt festlegen:

```php
\Itrk\System\Config::setBasicAuth('username', 'password');
```

## Sandbox Modus

Wenn die API nicht in einem unserer Testsysteme verwendet wird und um weiterhin die Möglichkeit
zu haben, Operationen zu simulieren, gibt es den Sandbox Modus.

```php
# Sandbox Modus aktivieren
\Itrk\System\Config::setSandboxMode(true);
```

> Achten Sie darauf, dass, wenn Sie eine Bestellung im Sandbox Modus platzieren, Sie diese nachher über
> den `/itrk-api/partner/contracts` Endpoint auch nur dann abrufen können, wenn der Sandbox Modus aktiv ist.

# Offene API

Die offene API stellt Endpunkte zur Verfügung für die keine Authentifizierung erforderlich ist, beispielsweise zum
Abrufen von Dokumenten oder dem Ländercode-Mapping.

**[Anleitung zur Verwendung der offenen API aufrufen](docs/public-data-api.md)**

# Info und Kontakt

Bei Fragen oder Unterstützung bei der Nutzung des SDK wenden Sie sich gern an uns:

IT-Recht Kanzlei, Alter Messeplatz 2, 80339 München  
Telefon: +49 89 1301433-0  
Fax: +49 89 1301433-60  
E-Mail: [info@it-recht-kanzlei.de](mailto:info@it-recht-kanzlei.de)

![ITRK Logo](https://www.it-recht-kanzlei.de/gfx/Logos/logo.svg)
