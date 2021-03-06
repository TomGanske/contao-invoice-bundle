<?php

array_insert($GLOBALS['BE_MOD'],0, array('CtEyeInvoice' => array
(
	'InvoiceInvoice'			=> array(
        'tables' 		        => array('tl_invoice_invoices','tl_invoice_invoicesElement'),
		'invoiceHtml'	        => array('tl_invoice_invoices','invoiceHtml'),
        'saveInvoiceAsPdf'	    => array('tl_invoice_invoices','saveInvoiceAsPdf'),
        'createHostingInvoices' => array('CtEye\\Invoice\\Invoice', 'createHostingInvoices'),
        'amountOverview'	    => array('CtEye\\Invoice\\Invoice','amountOverview'),
        'financialDocument'	    => array('CtEye\\Invoice\\FinancialDocument','financialDocument'),
        'sendEmail'             => array('CtEye\\Invoice\\InvoiceEmail','prepareSendEmailAttachedInvoice')
    ),
    'InvoiceClients' => array
    (
        'tables'    => array('tl_invoice_customers')
    ),
    'InvoiceHosting' => array
    (
        'tables'    => array('tl_invoice_hosting','tl_invoice_hosting_url')
    ),
    'InvoiceService' => array
    (
        'tables'    => array('tl_invoice_services')
    ),
    'InvoiceOutbox' => array
    (
        'tables'    => array('tl_invoice_outbox')
    ),
    'InvoiceBusiness' => array
    (
        'tables'    => array('tl_invoice_business')
    ),
    'InvoiceSettings' => array
    (
        'tables'    => array('tl_invoice_settings','tl_invoice_docTrans')
    )
)));


// Top Level Domains
$GLOBALS['Invoice']['tld'] = array('.com','.ch','.de','.org','.biz','.io','.info');


if (TL_MODE == 'BE')
    $GLOBALS['TL_CSS'][]        = 'bundles/cteyeinvoice/css/backend.css|screen';