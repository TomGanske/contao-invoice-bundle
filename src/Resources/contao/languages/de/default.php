<?php
$GLOBALS['TL_LANG']['MOD']['CtEyeInvoice']      = 'Invoice bei CT-EYE';
$GLOBALS['TL_LANG']['MOD']['achievements']      = array('Service');
$GLOBALS['TL_LANG']['MOD']['InvoiceClients']    = array('Kunden');
$GLOBALS['TL_LANG']['MOD']['InvoiceInvoice']    = array('Rechnungen');
$GLOBALS['TL_LANG']['MOD']['InvoiceSettings']   = array('Einstellungen');
$GLOBALS['TL_LANG']['MOD']['InvoiceHosting']    = array('Hosting');
$GLOBALS['TL_LANG']['MOD']['InvoiceService']    = array('Service');
$GLOBALS['TL_LANG']['MOD']['InvoiceOutbox']     = array('Ausgang');
$GLOBALS['TL_LANG']['MOD']['InvoiceBusiness']   = array('Firma');
$GLOBALS['TL_LANG']['default']['headline']      = array('Überschrift','Bitte geben Sie eine Überschrift ein.');


// Custom Headlines
$GLOBALS['TL_LANG']['invoice']['createHostingInvoices'] = 'Kunden-Hosting Liste';
$GLOBALS['TL_LANG']['Invoice']['amountOverview']        = 'Jahresübersicht';
$GLOBALS['TL_LANG']['Invoice']['financialDocument']     = 'Finanzdokument';
$GLOBALS['TL_LANG']['Invoice']['financialOffice']       = '<strong>DOKUMENT FÜR FINANZAMT <u>JAHR %s</u></strong>';

// Chart Description
$GLOBALS['TL_LANG']['Invoice']['yAxis']                 = 'Betrag';

// Error Messages for Class InvoiceErrorHandler
$GLOBALS['TL_LANG']['InvoiceErrorHandler']['field_error'] = 'ACHTUNG: Das Feld <strong>%s</strong> muss ausgefüllt werden!';

// Info Messages for pdf Handler
$GLOBALS['TL_LANG']['InvoicePdf']['pdfExists']     = 'Die Rechnungsnummer: <strong>%s existiert bereits</strong> und kann nicht zweimal gespeichert werden. Löschen Sie erst die zuvor erstellte Rechnung und speichern Sie das Dokument anschließend neu!';
$GLOBALS['TL_LANG']['InvoicePdf']['pdfcreated']    = "Die <strong>Rechnung ( %s )</strong> wurde im PDF Format gespeichert unter folgendem Pfad <strong>%s</strong>.";

// special Field Messages
$GLOBALS['TL_LANG']['Invoice']['automatically']                     = 'automatisch ...';
$GLOBALS['TL_LANG']['Invoice']['settings']                          = 'Einstellungen';
$GLOBALS['TL_LANG']['Invoice']['translation']                       = 'Übersetzung';
$GLOBALS['TL_LANG']['Invoice']['noTranslationExists']               = 'keine Übersetzung vorhanden';
$GLOBALS['TL_LANG']['Invoice']['noDomains']                         = 'Keine Domain gefunden!';
$GLOBALS['TL_LANG']['Invoice']['noInvoicesToCreate']                = 'Keine Rechnung erstellt!';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['paid']         = 'bezahlt';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['in_process']   = 'in Bearbeitung ...';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['pending']      = 'offen ...';
$GLOBALS['TL_LANG']['Invoice']['payment']['status']['overdue']      = 'Zahlung überfällig';

// Create auto DB Messages
$GLOBALS['TL_LANG']['Invoice']['headline']['hosting']               = 'Hosting - Vertrag';

// Custom text for submitted email as successful response
$GLOBALS['TL_LANG']['Invoice']['emailSubmitted']                    = 'Rechnung <strong>%s</strong> wurde <u>erfolgreich</u> an den Kunden <strong>%s</strong> versand.';
$GLOBALS['TL_LANG']['Invoice']['emailSubmittedError']               = '<strong>Ein Fehler ist aufgetreten.</strong><br/>Die Rechnungsnummer <strong>%s</strong> konnte <u>nicht erfolgreich</u> gesendet zum Kunden <strong>%s</strong> gesendet werden.';

// Template Buttons, Links
$GLOBALS['TL_LANG']['MSC']['nextBT']                                = 'Weiter';

// Financial Dokument Messages
$GLOBALS['TL_LANG']['Invoice']['noData']                            = 'Keine Daten gespeichert.';