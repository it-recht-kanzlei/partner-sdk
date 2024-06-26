# Offene API

Es gibt eine Reihe offener Endpoints die verwendet werden können. Verwenden Sie hierfür das
`GetApi` Objekt.

```php
$get_api = new \Itrk\Helper\Api\GetApi();
```

> Hinweis: unsere offenen Endpoints erfordern keine Authentifizierung.

# Endpoints

## Dokumente abfragen

Dieser Endpunkt liefert Informationen über Dokumente die über die Partner-API bestellt werden können.

````php
# Alle Dokumente abfragen
$get_api->documents();
````

## Einzelnes Dokument abfragen

````php
$get_api->document(123);
````

### Beispiel-Response eines einzelnen Dokuments

```php
Itrk\Helper\Resources\Document Object
(
    [data:protected] => Array
        (
            [id] => 123
            [config_name] => Name des Dokuments
            [document_monthly_price] => 5.99
        )

)
```

> Der Response für mehrere Dokumente ist identisch, nur dass dabei mehrere in `Document` Objekte in einem Array
> zurückgegeben werden.

## Ländercode-Mapping abrufen

Es gibt eine Liste von Ländern und numerischen Codes. Der numerische Ländercode wird u.a. übergeben
im Bestellvorgang um zusätzlich zur Adresse eines Kunden auch das Land anzugeben.

Dieser Endpoint gibt eine Liste von `Country` Objekten zurück, die die numerische Länderkennung und den Namen enthalten.

````php
# Ländercode-Mapping abfragen
$get_api->countries();
````

