<?php

// Top Panel


// Editing

$GLOBALS['TL_LANG']['tl_invoice_invoices']['new']             = array('Neue Rechnung','Erstellen Sie eine neue Rechnung.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['show']            = array('','Details anzeigen.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['edit']            = array('Rechnungselemente bearbeiten','Rechnungselemente bearbeiten.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['editheader']      = array('Rechnung bearbeiten','Rechnung bearbeiten.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['delete']          = array('','Wollen Sie die Rechnung %s wirklich löschen?');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['createPdf']       = array('','Rechnung %s als PDF speichern?');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['invoiceHtml']	  = array('','Rechnungvorschau im HTML Format.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['deleteConfirm']   = 'Wollen Sie die Rechnung mit der Nr: %s wirklich löschen?';

//Buttons
$GLOBALS['TL_LANG']['tl_invoice_invoices']['createHostingInvoices'] = 'Erstelle Hosting Rechnungen';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['amountOverview']        = 'Jahresübersicht';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['financialDocument']     = 'Finanzamt Dokument';

// Global Operations
$GLOBALS['TL_LANG']['tl_invoice_invoices']['sendEmail'][1]    = 'Rechnung per E-Mail an den Kunden versenden.';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['sendEmail'][2]    = 'Eine E-Mail mit der Rechnung wurde bereits an den Kunden versand.';


// Legend
$GLOBALS['TL_LANG']['tl_invoice_invoices']['customer_legend'] = 'Kunde';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['info_legend']     = 'Rechnungsdetails';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['service_legend']  = 'Service';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['price_legend']    = 'Stundenpreis und Gesamtpreis';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['miles_legend']    = 'Reisekosten';
$GLOBALS['TL_LANG']['tl_invoice_invoices']['status_legend']   = 'Projektstatus';

// Labels
$GLOBALS['TL_LANG']['tl_invoice_invoices']['customer'] 	    = array('Kunde','Wählen Sie einen Kunden aus der Liste aus.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['service'] 	    = array('Service','Wählen Sie einen Service aus der List aus. Diese Angabe ist Optional.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['pricePerHour']  = array('Stundenpreis','Tragen Sie hier den Preis pro Stunde im Format: 0.00 ein.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['totalHours'] 	= array('Gesamtstunden','Tragen Sie hier die Gesamtstunden ein.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['pricePerMiles'] = array('Preis pro Kilometer','Tragen Sie hier den Preis pro Kilometer ein.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['miles']		    = array('Kilometer','Tragen Sie hier die Gesamtkilometer ein.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['milePrice']	    = array('Gesamtkilometerpreis','Der Gesamtpreis für die Kilometer wird vom System automatisch berechnet.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['price'] 		= array('Gesamtpreis manuell eingeben','Geben Sie hier den Gesamtpreis manuell ein.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['invoice_nr'] 	= array('Rechnungsnummer','Die Rechnungsnummer wird automatisch vom System ermittelt.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['date'] 		    = array('Rechnungs-Datum','Legen Sie hier das Rechnungsdatum fest.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['totalPrice']	= array('Projektkosten gesamt','Die Gesamtkosten bestehen aus den Stundenpreisen + Kilometerkosten.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['taxprice']	    = array('MwSt.','Mehrwehrtsteuer.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['priceManuell']	= array('Preis manuell festlegen?','Aktivieren Sie die Checkbox um den Preis manuell einzugeben.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['isPaid'] 		= array('Bezahlt ?','Aktiviere die Checkbox wenn die Rechnung bezahlt wurde.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['finished'] 	    = array('Projekt beendet?','Aktiviere die Checkbox wenn das Projekt beendet ist?');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['isSaved'] 	    = array('Als PDF speichern ?','Soll die Rechnung im PDF Format auf dem Server gespeichert werden?');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['isPrinted'] 	= array('Rechnung drucken ?','Wurde die Rechnung bereits gedruckt so ist die Checkbox aktiv ?');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['isSend'] 	    = array('Rechnung per E-Mail versand ?','Ist die Checkbox aktiv so wurde die Rechnung an den Kunden bereits per E-Mail versand.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['sendEmailDate'] = array('Ausgangsdatum der E-Mail?','Datum wann die E-Mail an den Kunden verschickt wurde.');
$GLOBALS['TL_LANG']['tl_invoice_invoices']['paidOn']        = array('bezahlt am','Geben Sie hier das Datum ein, wann die Rechnung durch den Kunden beglichen wurde.');

// Message
$GLOBALS['TL_LANG']['tl_invoice_invoices']['noData']		    = "Es wurden keine Daten für die ID: %s gefunden.";
$GLOBALS['TL_LANG']['tl_invoice_invoices']['noInvoiceEntries']	= "<strong>Die Rechnung hat keine Inhaltselemente. </strong>Bitte <u>hinterlegen Sie Rechnungselemente</u> und anschließend wird das System den Endpreis automatisch berechnen.";

// Headline
$GLOBALS['TL_LANG']['tl_invoice_invoices']['headTitle']	        = "Rechnung";

// Table Headline
$GLOBALS['TL_LANG']['tl_invoice_invoices']['dashboard']['thStatus']    = "Status";
$GLOBALS['TL_LANG']['tl_invoice_invoices']['dashboard']['thInvoiceNr'] = "Nr";
$GLOBALS['TL_LANG']['tl_invoice_invoices']['dashboard']['thCompany']   = "Firma";
$GLOBALS['TL_LANG']['tl_invoice_invoices']['dashboard']['thPrice']     = "Kosten";

// Table Text
$GLOBALS['TL_LANG']['tl_invoice_invoices']['table']['tax']              = "MwSt";

// Amount
$GLOBALS['TL_LANG']['tl_invoice_invoices']['amountTitle']               = "monatliches Einkommen";