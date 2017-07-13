<?php

namespace CtEye\Invoice;

use Contao\Input;

class FinancialDocument extends Invoice
{
    public function financialDocument()
    {
        // RESET CSS
        $GLOBALS['TL_CSS']['resetBackend']  = 'bundles/cteyeinvoice/css/resetBackend.css';
        $GLOBALS['TL_CSS']['bootstrap']     = 'bundles/cteyeinvoice/css/bootstrap.min.css';

        // Variables
        $year       = (!empty(Input::get('year')) ? Input::get('year') : date("Y") );

        // Objects
        $oBusiness  = \InvoiceBusinessModel::findAll()->last();
        $aCustomers = \InvoiceCustomersModel::findAll()->fetchAll();
        $oInvoices  = \InvoiceInvoicesModel::currentYear($year);
        $oAllYears  = \InvoiceInvoicesModel::getAllYears();


        foreach($aCustomers as $v) {
            $arrCustomers[$v['invoiceId']] = $v;
        }

        // Backend Template
        $oTemplate = new \BackendTemplate('be_financialDocument');

        $oTemplate->business     = $oBusiness;
        $oTemplate->invoices     = $oInvoices;
        $oTemplate->customers    = $arrCustomers;
        $oTemplate->years        = $oAllYears;
        $oTemplate->year         = $year;
        $oTemplate->annualAmount = \InvoiceInvoicesModel::amountSum();
        $oTemplate->settings     = InvoiceData::$settings;

        return($oTemplate->parse());
    }
}