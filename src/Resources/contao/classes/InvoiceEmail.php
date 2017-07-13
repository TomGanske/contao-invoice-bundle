<?php

namespace CtEye\Invoice;


use Contao\BackendTemplate;
use Contao\Controller;
use Contao\Database;
use Contao\Environment;
use Contao\Input;
use Contao\TextArea;
use Contao\TextField;
use Contao\Message;
use Contao\StringUtil;
use Contao\FilesModel;
use System;
use Psr\Log\LogLevel;
use Contao\CoreBundle\Monolog\ContaoContext;

class InvoiceEmail extends Invoice
{
    /**
     * Create E-Mail Submit Form and check Input Fields. If true save data in Database and redirect.
    */
    public function prepareSendEmailAttachedInvoice()
    {
        /**
         * Load language file to translate the context.
        */
        \System::loadLanguageFile('tl_invoice_invoices');

        /**
         * Add Backend CSS Style.
         */
        $GLOBALS['TL_CSS'][]  = 'bundles/cteyeinvoice/css/Backend.css';

        /**
         * Backend Template Object
         */
        $objTemplate = new BackendTemplate('be_invoiceFormSubmitted');

        $objTemplate->goNext    = $GLOBALS['TL_LANG']['MSC']['nextBT'];
        $objTemplate->hrefNext  = Environment::get('base') . 'contao?do=InvoiceInvoice';


        /**
         *  Objects
        */
        $invoice    = \InvoiceInvoicesModel::findByPk(Input::get('id'));
        $customer   = \InvoiceCustomersModel::findBy("invoiceId",$invoice->customerId);


        /**
         * Properties
        */
        $hash           = hash(sha256,$customer->company.$invoice->invoiceId);
        $arrProcedures  = array();
        $arrValues      = array();
        $data           = array(
                            array('tstamp'=>time(),
                                  'customerId'=>$customer->id,
                                  'invoiceId'=>$invoice->invoiceId,
                                  'customEmail'=>$customer->email,
                                  'hash'=> $hash)
                          );

        /**
         * Prepare data for saving in Database
        */
        foreach( $data as $row )
        {
            $arrProcedures[] = '(?,?,?,?,?)';
            $arrValues[] = $row['tstamp'];
            $arrValues[] = $row['customerId'];
            $arrValues[] = $row['invoiceId'];
            $arrValues[] = $row['customEmail'];
            $arrValues[] = $row['hash'];
        }
        Database::getInstance()->prepare("INSERT INTO tl_invoice_outbox (tstamp,customerId,invoiceId,customEmail,hash) VALUES " . implode(',', $arrProcedures))->execute($arrValues);


        /**
         * Save Object invoice.
         */
        $invoice->isSend = true;
        $invoice->save();

        /**
         * Call function to send E-Mail.
        */
        $send = $this->sendEmailToCustomer($invoice,$customer);

        /**
         * Check if E-Mail could successfully submitted.
        */
        if($send)
            $objTemplate->message   = sprintf($GLOBALS['TL_LANG']['Invoice']['emailSubmitted'],$invoice->invoiceId,$customer->invoice);
        else
            $objTemplate->message   = sprintf($GLOBALS['TL_LANG']['Invoice']['emailSubmitted'],$invoice->invoiceId,$customer->invoice);

        return $objTemplate->parse();
    }


    /**
     * Send E-Mail to customer include the invoice attached.
     *
     * @param object $invoice
     * @param object $customer
     *
     * @return bool
     */
    protected function sendEmailToCustomer($invoice, $customer)
    {
        $objEmail = new \Email();

        $objEmail->from     = static::$business->email;
        $objEmail->fromName = static::$business->company;
        $objEmail->priority = 2;
        $objEmail->subject  = static::$settings[$customer->settingId]['subject'];
        $objEmail->html     = str_replace(array("%customer%","%invoice%","[nbsp]"), array($customer->company,$invoice->invoiceId,' '), static::$settings[$customer->settingId]['html']);

        /**
         * Set reply to E-Mail address.
        */
        $replyTo = '"'.static::$business['company'] .'" <'. static::$business['email'] .'>';
        $objEmail->replyTo($replyTo);

        /**
         * Get attachment path.
        */
        $uuid               = StringUtil::binToUuid(static::$settings[$customer->settingId]['invoiceTree']);
        $objAttachFile      = FilesModel::findByUuid($uuid);

        /**
         * Define full path of Invoice and MIME Type
        */
        $objEmail->attachFile($_SERVER['DOCUMENT_ROOT']."/".$objAttachFile->path."/".$customer->invoiceId.'/'.$invoice->invoiceId.'.pdf','application/pdf');

        /**
         * Send E-Mail CC.
        */
        $objEmail->sendCc(static::$business['email']);

        /**
         * Send E-Mail to customer.
        */
        #$bSubmitted = $objEmail->sendTo(static::$business['email']);
        $bSubmitted = $objEmail->sendTo($customer->email);

        if($bSubmitted) {
            /**
             * Log Message.
             */
            System::getContainer()
                ->get('monolog.logger.contao')
                ->log(LogLevel::INFO, 'An E-Mail for Invoice Nr: ' . $invoice->invoiceId . ' was send to customer' . $customer->company . '.', array(
                    'contao' => new ContaoContext(__CLASS__ . '::' . __FUNCTION__, TL_CONFIGURATION)));

            return true;
        }
        else {

            /**
             * Log Message.
             */
            System::getContainer()
                ->get('monolog.logger.contao')
                ->log(LogLevel::INFO, 'E-Mail with Invoice Nr: ' . $invoice->invoiceId . ' could not be send. An ERROR occurred.', array(
                    'contao' => new ContaoContext(__CLASS__ . '::' . __FUNCTION__, TL_CONFIGURATION)));

            return false;
        }
    }
}