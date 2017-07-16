# Installation von Contao Invoice Bundle

Es gibt zwei Installationsmöglichkeiten.

* mit dem Contao-Manger, nur für die Contao Managed-Editon
* über die Kommandozeile, für Contao Standard-Edition und Managed-Editon


## Installation über den Contao-Manager

* Suche das Paket: `cteye/invoice-bundle` auf www.packagist.com
* Installation der Erweiterung
* Klick auf "Install Tool"
* Anmelden und Datenbank Update durchführen


## Installation über die Kommandozeile

### Installation in einer Contao Managed-Edition

Installation in einer Composer-basierenden Contao 4.3+ Managed-Edition:

* `composer require "cteye/invoice-bundle"`
* Aufruf http(s)://deine-domain.de/contao/install
* Datenbank Update durchführen


### Installation in einer Contao Standard-Edition

Installation in einer Composer-basierenden Contao 4.3+ Standard-Edition:

* `composer require "cteye/invoice-bundle"`

Füge folgende Zeile in `app/AppKernel.php` am Ende des Array `$bundles` ein:

* `new CtEye\InvoiceBundle\CtEyeInvoiceBundle(),`

Anschließend muss der Cache geleert werden mit folgenden Befehlen:

* `vendor/bin/contao-console cache:clear --env=prod`
* `vendor/bin/contao-console cache:warmup -e prod`
* Aufruf http(s)://deine-domain.de/contao/install
* Datenbank Update durchführen