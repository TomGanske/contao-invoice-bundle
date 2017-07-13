<?php
$GLOBALS['TL_LANG']['MOD']['CtEyeInvoice']      = 'Invoice by CT-EYE';
$GLOBALS['TL_LANG']['MOD']['achievements']      = array('Service');
$GLOBALS['TL_LANG']['MOD']['InvoiceClients']    = array('Customers');
$GLOBALS['TL_LANG']['MOD']['InvoiceInvoice']    = array('Invoices');
$GLOBALS['TL_LANG']['MOD']['InvoiceSettings']   = array('Settings');
$GLOBALS['TL_LANG']['MOD']['InvoiceHosting']    = array('Hosting');
$GLOBALS['TL_LANG']['MOD']['InvoiceService']    = array('Service');
$GLOBALS['TL_LANG']['MOD']['InvoiceOutbox']     = array('Outbox');
$GLOBALS['TL_LANG']['MOD']['InvoiceBusiness']   = array('Company');
$GLOBALS['TL_LANG']['default']['headline']      = array('Headline','Please insert a Headline.');


// Custom Headlines
$GLOBALS['TL_LANG']['invoice']['createHostingInvoices'] = 'Client hosting list';
$GLOBALS['TL_LANG']['Invoice']['amountOverview']        = 'Amount Overview';
$GLOBALS['TL_LANG']['Invoice']['financialDocument']     = 'Financial Document';
$GLOBALS['TL_LANG']['Invoice']['financialOffice']       = '<strong>DOCUMENT FOR FINANCIAL OFFICE <u>YEAR %s</u></strong>';

// Chart Description
$GLOBALS['TL_LANG']['Invoice']['yAxis']                 = 'Amount';

// Error Messages for Class InvoiceErrorHandler
$GLOBALS['TL_LANG']['InvoiceErrorHandler']['field_error'] = 'Error: The field <strong>%s</strong> need to fill out!';

// Info Messages for pdf Handler
$GLOBALS['TL_LANG']['InvoicePdf']['pdfExists']     = 'The Invoice Nr: <strong>%s already exists</strong> and can not be saved twice. Remove first the Invoice and replace it by the newer one!';
$GLOBALS['TL_LANG']['InvoicePdf']['pdfcreated']    = "The <strong>Invoice ( %s )</strong> was created as PDF file and saved under the <strong>%s</strong> path.";

// special Field Messages
$GLOBALS['TL_LANG']['Invoice']['automatically']                     = 'automatically ...';
$GLOBALS['TL_LANG']['Invoice']['settings']                          = 'Settings';
$GLOBALS['TL_LANG']['Invoice']['translation']                       = 'Translation';
$GLOBALS['TL_LANG']['Invoice']['noTranslationExists']               = 'translation does not exists';
$GLOBALS['TL_LANG']['Invoice']['noDomains']                         = 'No Domains found!';
$GLOBALS['TL_LANG']['Invoice']['noInvoicesToCreate']                = 'No Invoices to create!';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['paid']         = 'paid';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['in_process']   = 'in process ...';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['pending']      = 'pending ...';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['overdue']      = 'overdue';

// Create auto DB Messages
$GLOBALS['TL_LANG']['Invoice']['headline']['hosting']               = 'Contract Service';

// Custom text for submitted email as successful response
$GLOBALS['TL_LANG']['Invoice']['emailSubmitted']                    = 'Invoice number <strong>%s</strong> was <u>successful</u> submitted to the customer <strong>%s</strong>.';
$GLOBALS['TL_LANG']['Invoice']['emailSubmittedError']               = '<strong>An ERROR occurred.</strong><br/>Invoice number <strong>%s</strong> could not <u>successfully</u> submitted to the customer <strong>%s</strong>.';

// Template Buttons, Links
$GLOBALS['TL_LANG']['MSC']['nextBT']                                = 'Next';