Contao 4 - Invoice Bundle
---


### Information
```
Developer:  Tom Ganske, CT-EYE
Website:    http://www.ct-eye.com
Year:       2017
Version:    0.0.2
CMS:        Contao 4 Bundle
```


### Installation

This bundle is still located under your web-root/src/cteye/.
Open the app/AppKernel.php and add this line below to the function.
    
    public function registerBundles()
    {
        $bundles = [
            ...
            new CtEye\InvoiceBundle\CtEyeInvoiceBundle()
            ];
    }

Open the terminal and insert:
```
composer dump-autoload
```

Open your browser and install all tables.

```
http://www.your-domain.com/contao/install
```


### Description
Manage your invoices inside the Contao 4 Backend.
Add your business details and service. Create your customers and manage them over your backend. Create and edit invoices, save as PDF and send it by an e-mail to your customers.
Outgoing e-mails will be logged.

Create annual business year overviews and print them out and send it to your financial office.


### Overview
 - Setup your business details
 - Create unlimited customers
 - Create unlimited services
 - Create language specific settings and connect it to your customers (multi language support)
 - Create custom saving path for your invoice pdf documents set up in settings 
 - Save invoices as PDF file or print them
 - Send full HTML e-mails to your customer and log the outbox date and time
 - Open amount overview and compare last and current year
 - Open and print the financial document for your selected year
 - +++ Tax: you can setup your tax by a date so it will be calculated if your business charge it
  
  

This software is open source. The developer assumes no liability in any regard.