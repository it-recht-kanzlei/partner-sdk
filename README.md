# IT-Recht Kanzlei PHP-SDK

Dieses SDK bietet Unterstützung bei der Einrichtung und Verbindung unserer Dienste und APIs.

## Einbinden des SDK

Laden Sie die `autoload.php` an beliebiger Stelle innerhalb Ihrer Projektstruktur.

```php
require_once 'pfad/zu/itrk-sdk/autoload.php';
```

Wir bieten zweierlei APIs an:

### Partner-API

Die Partner-API dienst zum Ausführen von Bestellungen und Abrufen von Verträgen.

**[Anleitung zur Verwendung der Partner API aufrufen](docs/partner-api.md)**

### Offene Get-Api

Die offene API stellt Endpunkte zur Verfügung für die keine Authentifizierung erforderlich ist, beispielsweise zum
Abrufen von Dokumenten oder dem Ländercode-Mapping.

**[Anleitung zur Verwendung der offenen API aufrufen](docs/get-api.md)**

### Startparameter

#### Auf Testumgebung arbeiten

Wir haben Ihnen ggf. mitgeteilt, welchen unserer Server Sie zum Testen verwenden sollen. Legen Sie diesen einmalig fest.

```php
\Itrk\Helper\Config::setHostname('testsystem.it-recht-kanzlei.de');
```

Ggf. wird ein Basic Auth benötigt, die entsprechenden Daten können Sie wie folgt festlegen:

```php
\Itrk\Helper\Config::setBasicAuth('username', 'password');
```

### Sandbox Modus

Wenn die API nicht in einem unserer Testsysteme verwendet wird und um weiterhin die Möglichkeit
zu haben, Operationen zu simulieren, gibt es den Sandbox Modus.

```php
# Sandbox Modus aktivieren
\Itrk\Helper\Config::setSandboxMode(true);
```

> Achten Sie darauf, dass, wenn Sie eine Bestellung im Sandbox Modus platzieren, Sie diese nachher über
> den `/itrk-api/partner/contracts` Endpoint auch nur dann abrufen können, wenn der Sandbox Modus aktiv ist.

# Info und Kontakt

Bei Fragen oder Unterstützung bei der Nutzung des SDK wenden Sie sich gern an uns

IT-Recht Kanzlei, Alter Messeplatz 2, 80339 München  
Telefon: +49 89 1301433-0  
Fax: +49 89 1301433-60  
E-Mail: [info@it-recht-kanzlei.de](mailto:info@it-recht-kanzlei.de)

![ITRK Logo](https://www.it-recht-kanzlei.de/gfx/Logos/logo.svg)
