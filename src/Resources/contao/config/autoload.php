<?php

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
    'CtEye\\Invoice\\Invoice'              => 'src/CtEye/invoice-bundle/src/Resources/contao/classes/Invoice.php',
    'CtEye\\Invoice\\InvoiceErrorHandler'  => 'src/CtEye/invoice-bundle/src/Resources/contao/classes/InvoiceErrorHandler.php',
    'CtEye\\Invoice\\FinancialDocument'    => 'src/CtEye/invoice-bundle/src/Resources/contao/classes/FinancialDocument.php',
    'CtEye\\Invoice\\InvoiceData'          => 'src/CtEye/invoice-bundle/src/Resources/contao/classes/InvoiceData.php',
    'CtEye\\Invoice\\InvoiceEmail'         => 'src/CtEye/invoice-bundle/src/Resources/contao/classes/InvoiceEmail.php',

    // Models
    'InvoiceSettingsModel'                 => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceSettingsModel.php',
    'InvoiceInvoicesModel'                 => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceInvoicesModel.php',
    'InvoiceCustomersModel'                => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceCustomersModel.php',
    'InvoiceInvoicesElementModel'          => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceInvoicesElementModel.php',
    'InvoiceBusinessModel'                 => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceBusinessModel.php',
    'InvoiceDocTransModel'                 => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceDocTransModel.php',
    'InvoiceServicesModel'                 => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceServicesModel.php',
    'InvoiceOutboxModel'                   => 'src/CtEye/invoice-bundle/src/Resources/contao/models/InvoiceOutboxModel.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	// Templates
	'be_invoiceHTML'       		    => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
    'be_invoicePDF'       	        => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
    'be_amountOverview'             => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
    'be_showListofHostingUpdates'   => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
    'be_financialDocument.html5'    => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
    'be_invoiceFormSubmitted'       => 'src/CtEye/invoice-bundle/src/Resources/contao/templates',
));
