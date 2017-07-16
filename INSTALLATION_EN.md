# Installation of Contao Invoice Bundle

There are two ways to install the bundle.

* with the Contao-Manger, only for Contao Managed-Editon
* via the command line, for Contao Standard-Edition and Managed-Editon


## Installation with Contao-Manager

* Search for package: `cteye/invoice-bundle` on www.packagist.com
* Install the package
* Click on "Install Tool" 
* Login and update the database


## Installation via command line

### Installation for Contao Managed-Edition

Installation in a Composer-based Contao 4.3+ Managed-Edition:

* `composer require "cteye/invoice-bundle"`
* Call http(s)://your-domain.com/contao/install
* Login and update the database


### Installation for Contao Standard-Edition

Installation in a Composer-based Contao 4.3+ Standard-Edition

* `composer require "cteye/invoice-bundle"`

Add follow line in `app/AppKernel.php` at the end of the `$bundles` array:

* `new CtEye\InvoiceBundle\CtEyeInvoiceBundle(),`

Clear the cache:

* `vendor/bin/contao-console cache:clear --env=prod`
* `vendor/bin/contao-console cache:warmup -e prod`
* Call http(s)://your-domain.com/contao/install
* Login and update the database
