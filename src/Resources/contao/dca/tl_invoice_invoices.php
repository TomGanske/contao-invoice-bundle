<?php

use CtEye\Invoice\Invoice;
use Dompdf\Dompdf;
use Dompdf\Options;

$GLOBALS['TL_DCA']['tl_invoice_invoices'] = array
(
  'config' => array
  (
    'dataContainer'	   => 'Table',
    'ctable'           => array('tl_invoice_invoicesElement'),
    'switchToEdit'     => true,
    'enableVersioning' => true,
    'onload_callback'  => array(array('tl_invoice_invoices','setPaidOn')),
    'onsubmit_callback'=> array(array('tl_invoice_invoices','onSubmitCallback')),
    'sql'              => array
    (
       'keys' => array
        (
           'id'         => 'primary'
        )
    )
  ),

  'list' => array
  (
    'sorting' => array
    (
        'mode'			  => 1,
        'fields'          => array('payDay'),
        'flag'            => 10,
        'panelLayout'     => 'filter;search,limit,sort'
	),

    'label' => array
    (
      'fields'          => array('id'),
      'label_callback'  => array('tl_invoice_invoices','label')
    ),
  
    'global_operations' => array
    (
      'createHostingInvoices' => array
      (
          'label' => $GLOBALS['TL_LANG']['tl_invoice_invoices']['createHostingInvoices'],
          'href'  => 'key=createHostingInvoices',
          'icon'  => 'bundles/cteyeinvoice/icon/hosting.svg'
      ),
      'amountOverview' => array
      (
          'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['amountOverview'],
          'href'          => 'key=amountOverview',
          'icon'          => 'bundles/cteyeinvoice/icon/amount.svg',
          'attributes'	  => 'onclick="Backend.openModalIframe({\'width\':1200,\'height\':605,\'title\':\' '.$GLOBALS['TL_LANG']['Invoice']['amountOverview'].'\',\'url\':this.href});return false"'
      ),
      'financialDocument' => array
      (
          'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['financialDocument'],
          'href'          => 'key=financialDocument',
          'icon'          => 'bundles/cteyeinvoice/icon/amount.svg',
          'attributes'	  => 'onclick="Backend.openModalIframe({\'width\':1200,\'height\':605,\'title\':\' '.$GLOBALS['TL_LANG']['Invoice']['financialDocument'].'\',\'url\':this.href});return false"'
      )
    ),
    
    'operations' => array
    (
      'edit' => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['edit'],
          'href'	  => 'table=tl_invoice_invoicesElement',
          'icon'      => 'edit.gif'
      ),
      'editheader' => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['editheader'],
          'href'      => 'act=edit',
          'icon'      => 'header.gif'
      ),
      'invoiceHtml' => array
      (
         'label'      => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['invoiceHtml'],
         'href'       => 'key=invoiceHtml',
         'icon'       => 'bundles/cteyeinvoice/icon/html.svg',
         'attributes' => 'onclick="Backend.openModalIframe({\'width\':750,\'height\':405,\'title\':\' '.$GLOBALS['TL_LANG']['tl_invoice_invoices']['headTitle'].'\',\'url\':this.href});return false"'
       ),
      'delete'  => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['delete'],
          'href'      => 'act=delete',
          'icon'      => 'delete.gif',
          'attributes'=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_invoice_invoices']['delete'] . '\'))return false;Backend.getScrollOffset()"',
      ),
      'saveInvoiceAsPdf'   => array
      (
          'label'     => $GLOBALS['TL_LANG']['tl_invoice_invoices']['createPdf'],
          'href'      => 'key=saveInvoiceAsPdf',
          'icon'      => 'bundles/cteyeinvoice/icon/pdf.svg',
          'attributes'=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_invoice_invoices']['createPdf'] . '\'))return false;Backend.getScrollOffset()"',
          'button_callback'=> array('tl_invoice_invoices','showPdfButton')
      ),
      'sendEmail'   => array
      (
          'label'     => $GLOBALS['TL_LANG']['tl_invoice_invoices']['sendEmail'],
          'href'      => 'key=sendEmail',
          'icon'      => 'bundles/cteyeinvoice/icon/sendEmail.svg',
          'button_callback'=> array('tl_invoice_invoices','iconEmail')
      )
    )
  ),

  'palettes' => array
  (
    '__selector__'  =>  array('priceManuell'),
    'default'	      =>'
                       {customer_legend:hide},customerId;
                       {service_legend:hide},serviceTable;
                       {price_legend:hide},pricePerHour,totalHours;
                       {miles_legend:hide},pricePerMiles,miles,milePrice;
                       {info_legend:hide},date,invoiceId,totalPrice,taxprice,priceManuell;
                       {status_legend:hide},finished,isPaid,paidOn,isSaved,isPrinted,isSend'
  ),

  'subpalettes' => array
  (
      'priceManuell'       => 'price'
  ),

  'fields' => array
  (
    'id' => array
    (
        'sql'           => "int(10) unsigned NOT NULL auto_increment"
    ),
    'tstamp' => array
    (  
        'sql'           => "int(10) unsigned NOT NULL default '0'"
    ),
    'payDay' => array
    (
        'sql'           => "int(10) unsigned NULL"
    ),
    'customerId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['customerId'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'select',
      'options_callback'=> array('tl_invoice_invoices','loadCustomers'),
      'eval'            => array('includeBlankOption'=>true,'submitOnChange'=>true,'tl_class'=>'clr'),
      'sql'             => "smallint(2) unsigned DEFAULT '0' NOT NULL"
    ),
    'invoiceId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['invoiceId'],
      'inputType'       => 'text',
      'exclude'         => true,
      'search'          => true,
      'load_callback'   => array(array('tl_invoice_invoices','loadInvoiceId')),
      'eval'            => array('readonly'=>true,'tl_class'=>'w50'),
      'sql'             => "varchar(10) NOT NULL DEFAULT ''"
    ),
    'serviceTable' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['serviceTable'],
        'inputType'       => 'select',
        'exclude'         => true,
        'filter'          => true,
        'options_callback'=> array('tl_invoice_invoices','serviceOptions'),
        'eval'            => array('includeBlankOption'=>true,'tl_class'=>'w50'),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'date' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['date'],
      'exclude'         => true,
      'sorting'         => true,
      'inputType'       => 'text',
      'flag'            => 9,
      'eval'            => array('rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
      'sql'             => "int(10) unsigned NULL"
    ),
    'totalHours' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['totalHours'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "smallint(4) unsigned DEFAULT '0' NOT NULL"
    ),
    'pricePerHour' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['pricePerHour'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "double precision default '0.00' NOT NULL"
    ),
    'pricePerMiles' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['pricePerMiles'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "double precision default '0.00' NOT NULL"
    ),
    'miles' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['miles'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "smallint(4) unsigned DEFAULT '0' NOT NULL"
    ),
    'milePrice' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['milePrice'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('readonly'=>true,'tl_class'=>'w50'),
        'sql'           => "double precision default '0' NOT NULL"
    ),
    'totalPrice' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['totalPrice'],
        'exclude'       => true,
        'inputType'     => 'text',
        'load_callback' => array(array('tl_invoice_invoices','loadTotalPrice')),
        'eval'          => array('readonly'=>true,'tl_class'=>'w50'),
        'sql'           => "double precision default '0.00' NOT NULL"
    ),
    'taxprice' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['taxprice'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('readonly'=>true,'tl_class'=>'w50'),
        'sql'           => "double precision default '0.00' NOT NULL"
    ),
    'priceManuell' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['priceManuell'],
        'exclude'       => true,
        'inputType'     => 'checkbox',
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12'),
        'sql'           => "char(1) NOT NULL default '0'"
    ),
    'price' => array
    (
          'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['price'],
          'exclude'       => true,
          'inputType'     => 'text',
          'search'        => true,
          'eval'          => array('tl_class'=>'clr'),
          'sql'           => "double precision default '0.00' NOT NULL"
    ),
    'finished' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['finished'],
        'exclude'       => true,
        'inputType'     => 'checkbox',
        'filter'        => true,
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12'),
        'sql'           => "char(1) NOT NULL default '0'"
    ),
    'isPaid' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['isPaid'],
        'exclude'       => true,
        'filter'        => true,
        'inputType'     => 'checkbox',
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12'),
        'sql'           => "char(1) NOT NULL default '0'"
    ),
    'paidOn' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['paidOn'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard clr'),
        'sql'           => "int(10) unsigned NULL"
    ),
    'isSaved' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['isSaved'],
        'exclude'       => true,
        'filter'        => true,
        'inputType'     => 'checkbox',
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12 clr'),
        'sql'           => "char(1) NOT NULL default '0'"
    ),
    'isPrinted' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['isPrinted'],
        'exclude'       => true,
        'filter'        => true,
        'inputType'     => 'checkbox',
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12'),
        'sql'           => "char(1) NOT NULL default '0'"
    ),
    'isSend' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoices']['isSend'],
        'exclude'       => true,
        'filter'        => true,
        'inputType'     => 'checkbox',
        'eval'          => array('submitOnChange'=>true,'tl_class'=>'w50 m12'),
        'sql'           => "char(1) NOT NULL default '0'"
    )
   )
);

class tl_invoice_invoices extends Invoice
{

  // calc TotalPrice
  public function loadTotalPrice($varValue,$objDca)
  {
      $invoiceElements = InvoiceInvoicesElementModel::findBy('pid',$objDca->activeRecord->id);
      $totalPrice      = 0;


      /**
       * Return Error Message if invoice has no child records.
      */
      if(is_null($invoiceElements)){
          Message::addError($GLOBALS['TL_LANG']['tl_invoice_invoices']['noInvoiceEntries']);
          return;
      }


      // count invoice child records
      while($invoiceElements->next()) {
          $totalPrice += $invoiceElements->price;
      }

      // Price Calculated or Manuel insert
      if( ! $objDca->activeRecord->priceManuell )
      {
          if( $objDca->activeRecord->totalHours !== 0 )
          {
              $totalPrice = ($objDca->activeRecord->pricePerHour * $objDca->activeRecord->totalHours) + ($objDca->activeRecord->pricePerMiles * $objDca->activeRecord->miles) + $totalPrice;
          }
          else {
              $totalPrice = ($objDca->activeRecord->pricePerMiles * $objDca->activeRecord->miles) + $totalPrice;
          }
      }
      else {
          $totalPrice = $objDca->activeRecord->price + $totalPrice;
      }


      // Update Price
      $oData = InvoiceInvoicesModel::findByPk($objDca->id);
      $oData->price = $totalPrice;
      $oData->save();


      return $totalPrice;
  }

  /**
   * Check and Create Invoice-Nr.
   * @param string $varValue
   * @param DataContainer $objDca
   *
   * @return string
   */
  public function loadInvoiceId($varValue,$objDca)
  {
      if(!empty($varValue) && $objDca->activeRecord->finished)
          return $varValue;


      // no customer select or order isn`t finished
      if(empty($objDca->activeRecord->customerId) || empty($objDca->activeRecord->finished))
        $varValue = '';
      else {
          // Count Customer Invoices by customer number
          $sql = InvoiceInvoicesModel::countById($objDca->activeRecord->customerId,array());

          $counter = count($sql);

          if($counter > 0)
              $varValue = $objDca->activeRecord->customerId.'-'.$counter++;
          else
              $varValue = $objDca->activeRecord->customerId.'-1';
      }

      if(empty($objDca->activeRecord->date) && !empty($varValue))
          CtEye\Invoice\InvoiceErrorHandler::fieldMissing($GLOBALS['TL_LANG']['tl_invoice_invoices']['date'][0]);

      // Save Invoice ID in Database
      Database::getInstance()
          ->prepare("UPDATE tl_invoice_invoices SET 
                            invoiceId=? 
                            WHERE 
                            id=?")
          ->execute($varValue,$objDca->activeRecord->id);


      return (empty($varValue)) ? $GLOBALS['TL_LANG']['Invoice']['automatically'] : $varValue;
  }

  /**
   * Load Customers
   * @param string $varValue
   * @return int $invoiceId
  */
  public function loadCustomers($varValue)
  {
      $customers = InvoiceCustomersModel::findAll();
      $collection = [];

      if(null !== $customers)
      {
          foreach($customers as $v)
          {
              $collection[$v->invoiceId] = "Nr: ".$v->invoiceId." | ".$v->company;
          }
      }

      return $collection;
  }

  // return Custom Label
  public function label($label)
  {
      $customer = InvoiceCustomersModel::findBy('invoiceId',$label['customerId']);

      $status   = $GLOBALS['TL_LANG']['Invoice']['payment']['status']['paid'];

      if(!$label['finished']) {
        $bg_color = "green";
        $color = "#fff";
        $status = $GLOBALS['TL_LANG']['Invoice']['payment']['status']['in_process'];
      }
      else if($label['finished'] && !$label['isPaid'] && time() > $label['payDay']) {
        $bg_color = 'red';
        $color = "#fff";
        $status = $GLOBALS['TL_LANG']['Invoice']['payment']['status']['overdue'];
      }
      else if($label['finished'] && !$label['isPaid'] && time() < $label['payDay']) {
          $bg_color = '#d7b15d';
          $color = "#fff";
          $status = $GLOBALS['TL_LANG']['Invoice']['payment']['status']['pending'];
      }
      else if($label['finished'] && $label['isPaid']) {
          $status = $GLOBALS['TL_LANG']['Invoice']['payment']['status']['paid'];
      }

      $date = ($label['paidOn'] == $label['payDay']) ? $label['payDay'] : $label['paidOn'] ;





      return sprintf('<span style="display:inline-block;width:50px">%s</span>
                      <span style="display:inline-block;width:180px;">%s</span>
                      <span style="display:inline-block;width:100px;font-weight:bolder">%s</span>
                      <span style="display:inline-block;width:120px;text-align:center;background-color:%s;color:%s;padding:2px 5px;border-radius:5px;">%s</span>
                      <span style="display:inline-block;width:auto;background-color:%s;color:%s;padding:2px 5px;border-radius:5px;">%s</span>',
            (($label['invoiceId'] == 0) ? '': $label['invoiceId'] ),
            ((!empty($customer->company)) ? $customer->company : $customer->firstname . ' ' . $customer->lastname),
            self::getPrice($label['totalPrice']+$label['taxprice'],static::$settings[$customer->settingId]),
            $bg_color,
            $color,
            $status,
            $bg_color,
            $color,
            date($GLOBALS['TL_CONFIG']['dateFormat'],$date)
        );
  }

  // set the Paid-On Date from payDay or the custom selected value
  public function setPaidOn($oDca)
  {
      if(is_null($oDca->id))
          return ;

      $invoice = InvoiceInvoicesModel::findByPk($oDca->id);

      if(!empty($invoice->paidOn))
          return $invoice->paidOn;

      // save field paidOn
      $invoice->paidOn = $invoice->payDay;
      $invoice->save();

      return $invoice->payDay;
  }

  /**
   * DCA onSubmitCallback Function and reset also the sendByEmail Date field if email wasn`t submitted.
   * @param DataContainer $objDca
   * @return null
  */
  public function onSubmitCallback($objDca)
  {
    $kmPrice = 0;
    $iCustomPayDays = Database::getInstance()->prepare("SELECT period FROM tl_invoice_customers WHERE invoiceId=?")->execute(Input::post('customerId'))->fetchAssoc();


    if($objDca->activeRecord->pricePerMiles > 0 && $objDca->activeRecord->miles > 0)
          $kmPrice = $objDca->activeRecord->pricePerMiles * $objDca->activeRecord->miles;

    if(static::$business['setTax'] && ($objDca->activeRecord->payDay > static::$business['taxStartDate']) ) {
        // Check for Tax
        $taxprice     = ($objDca->activeRecord->totalPrice * static::$business['tax']) / 100;
    } else
    {
        $taxprice = 0;
    }

    $update             = InvoiceInvoicesModel::findByPk($objDca->id);
    $update->price      = Input::post('price');
    $update->totalPrice = Input::post('totalPrice');
    $update->payDay     = strtotime('+'.$iCustomPayDays['period'].' days'.Input::post('date'));
    $update->milePrice  = $kmPrice;
    $update->taxprice   = $taxprice;

    /**
     * Save Object.
    */
    $update->save();

    return null;
  }


  // return Service and fill the option list
  public function serviceOptions()
  {
      $sql = InvoiceServicesModel::findAll(array('ORDER BY id'));

      if(is_null($sql))
          return;

      while ($sql->next())
      {
            $service[$sql->serviceTable] = $sql->service;
      }
      return $service;
  }

  // ModalFrame HTML Invoice
  public function invoiceHtml()
  {
    // RESET CSS
    $GLOBALS['TL_CSS']['resetBackend']  = 'bundles/cteyeinvoice/css/resetBackend.css';
    $GLOBALS['TL_CSS']['bootstrap']     = 'bundles/cteyeinvoice/css/bootstrap.min.css';

    // get Invoice
    $invoice = InvoiceInvoicesModel::findBy('id',\Input::get('id'));

    // get Invoice Element
    $invoicesElement = InvoiceInvoicesElementModel::findBy('pid',\Input::get('id'));

    if(is_null($invoicesElement))
        return;

    // get Customer
    $customer = InvoiceCustomersModel::findBy('invoiceId',$invoice->customerId);

    // Load SIGN & LOGO image path
    $objSignFile    = \FilesModel::findByUuid(self::$business['sign']);
    $signImageUrl   = ($objSignFile === null) ? null : $objSignFile->path;

    $objLogoFile    = \FilesModel::findByUuid(self::$business['logo']);
    $logoImageUrl   = ($objLogoFile === null) ? null : $objLogoFile->path;


    if(\Input::get('do')=='InvoiceInvoice'  && \Input::get('key')=='invoiceHtml')
    {
      # Template result
      $oTemplate = new \BackendTemplate('be_invoiceHTML');

      $oTemplate->sign                 = $signImageUrl;
      $oTemplate->logo                 = $logoImageUrl;

      $oTemplate->invoice              = $invoice;
      $oTemplate->invoicesElement      = $invoicesElement;

      $oTemplate->customer             = $customer;
      $oTemplate->business             = static::$business;
      $oTemplate->settings             = static::$settings[$customer->settingId];
      $oTemplate->translation          = static::$translation[$customer->settingId];

      return($oTemplate->parse());
    }
  }

  // save Invoice as PDF file use dompdf extension
  public function saveInvoiceAsPdf()
  {
      // RESET CSS
      $GLOBALS['TL_CSS']['pdfBackend']  = 'bundles/cteyeinvoice/css/pdfBackend.css';

      if(\Input::get('do')=='InvoiceInvoice'  && \Input::get('key')=='saveInvoiceAsPdf')
      {
            // Objects
            $invoice            = InvoiceInvoicesModel::findByPk(\Contao\Input::get('id'));
            $invoicesElement    = InvoiceInvoicesElementModel::findBy('pid',\Contao\Input::get('id'));
            $customer           = InvoiceCustomersModel::findBy('invoiceId',$invoice->customerId);


            // Properties
            $objT           = new \BackendTemplate('be_invoicePDF');
            $uuid           = \Contao\StringUtil::binToUuid(static::$settings[$customer->settingId]['invoiceTree']);
            $objFile        = FilesModel::findByUuid($uuid);
            $path           = $objFile->path;
            $translation    = static::$translation[$customer->settingId];
            $settings       = static::$settings[$customer->settingId];

            // Load SIGN & LOGO image path
            $objSignFile = \FilesModel::findByUuid(static::$business['sign']);
            $sign   = ($objSignFile === null) ? null : $objSignFile->path;

            $objLogoFile = \FilesModel::findByUuid(static::$business['logo']);
            $logo   = ($objLogoFile === null) ? null : $objLogoFile->path;


            // save path for PDF files
            $customFolder = $_SERVER['DOCUMENT_ROOT']."/".$path."/".$customer->invoiceId.'/';

            // check if Invoice exists as PDF already
            if(file_exists($customFolder.$invoice->invoiceId.'.pdf')) {
                $objT->exists       = true;
                $objT->invoiceId    = $invoice->invoiceId;
                return ($objT->parse());
            }
            else {

                // DOM PDF Start
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);

                // instantiate and use the domPDF class
                $dompdf = new Dompdf($options);


                // Loop Elements
                $i = 1;
                $loopElements = '';
                while ($invoicesElement->next()) {
                    $loopElements .= '<tr>
                                    <td style="border-bottom:#dddddd solid 1px">
                                        ' . $i . '
                                    </td>
                                    <td style="border-bottom:#dddddd solid 1px">
                                        <strong>' . $invoicesElement->headline . '</strong><br/>
                                        ' . str_replace("[nbsp]", " ", $invoicesElement->description) . '
                                    </td>
                                    <td style="border-bottom:#dddddd solid 1px;text-align:right">' .
                        (!empty($invoicesElement->price) ? static::getPrice((double)$invoicesElement->price, $settings) : '' ). '
                                    </td>
                                 </tr>';
                    $i++;
                }

                // set Tax
                if($this->business['setTax']) {
                    $taxString = '<tr>
                                        <td colspan="2" style="text-align:right">'.$translation['subtotal'].'</td>
                                        <td style="text-align:right">
                                            '.static::getPrice($invoice->totalPrice,$settings) . '
                                        </td>
                                   </tr>
                                   <tr>
                                        <td colspan="2" style="text-align:right">'.$translation['taxtitle']. ' ' . $this->business['tax'] . ' %</td>
                                        <td style="text-align:right">+
                                            '.static::getPrice($invoice->taxprice,$settings) . '
                                        </td>
                                    </tr>';
                }


                // html variable with code
                $html = '
                    <div>
                        <div style="width:38%;float:left;border-left:#e9e9e9 solid 1px;border-right:#e9e9e9 solid 1px;padding-left:15px">
                            <strong style="color:#e2b347;">' . $translation['_to'] . '</strong><br>
                            <strong>' . ((!empty($customer->company)) ? $customer->company : $customer->title . ' ' . $customer->firstname . ' ' . $customer->lastname ) . '</strong><br>
                            ' . $customer->street . '<br>
                            ' . $customer->zip . ' ' . $customer->town . '<br>
                            ' . $this->getCountries()[$customer->country] . '<br>
                            ' . $customer->email . '
                        </div>
                        <div style="width:58%;float:left;padding-left:15px;padding-top:18px;">
                            <span style="width:30%;display:inline-block">
                                <strong style="color:#e2b347;">' . $translation['_from'] . '</strong><br>
                                ' . static::$business['company'] . '<br>
                                ' . static::$business['firstname'] . ' ' . static::$business['lastname'] . '<br>
                                ' . static::$business['email'] . '<br>
                                ' . static::$business['phone'] . '
                            </span>
                            <span style="width:30%;display:inline-block">
                                <br>
                                <br>
                                ' . static::$business['street'] . '<br>
                                ' . static::$business['zip'] . ' ' . static::$business['town'] . '<br>
                                ' . $this->getCountries()[static::$business['country']] . '
                            </span>
                            <span style="width:30%;display:inline-block;text-align:right;">
                                <img src="' . $logo . '" border="0" width="100px" style="margin-top:13px"/>
                            </span>
                        </div>                
                    </div>
                    
                    <div style="padding-top:150px;">
                        <span style="width:30%;display:inline-block">' . $translation['invoiceNo'] . ' ' . $invoice->invoiceId . '</span>
                        <span style="width:35%;display:inline-block;text-align:center">' . $translation['invoiceDate'] . ' ' . date($GLOBALS['TL_CONFIG']['dateFormat'], $invoice->date) . '</span>
                        <span style="width:35%;display:inline-block;text-align:right">' . $translation['invoiceDue'] . ' ' . date($GLOBALS['TL_CONFIG']['dateFormat'], $invoice->payDay) . '</span>
                    </div>
                    
                    <h4 style="font-size:25px;">' . $translation['invoiceTitle'] . '</h4>
                    
                    
                    <div>
                        <table style="width:100%;border-collapse:collapse;">
                            <thead style="border-bottom:#dddddd solid 2px;">
                                <tr>
                                    <th colspan="3" style="padding:0 0 10px 0;font-weight:bold;">' . $translation['service'] . '</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color:#f9f9f9;border-top:#dddddd solid 2px;">
                                    <th style="padding:10px 0 10px 0;font-weight:bold;width:45px;">' . $translation['pos'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['description'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;text-align:right">' . $translation['price'] . '</th>
                                </tr>
                            ' .
                                $loopElements.
                                $taxString
                            . '
                            
                            </tbody>
                            <tfoot style="border-top:#dddddd solid 1px;">
                                <tr>
                                    <td colspan="2" style="font-weight:bold;text-align:right;padding-top:10px;">' . $translation['totalprice'] . '</td>
                                    <td style="width:100px;text-align:right;padding-top:10px;font-weight:bold;">
                                        ' . static::getPrice($invoice->totalPrice + $invoice->taxprice, $settings) . '
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div>
                        <hr>
                        ' . $translation['regards'] . '
                        <p><img src="' . $sign . '" border="0" width="100px" style="margin-top:13px"/></p>
                        <p>' . static::$business['firstname'] . ' ' . static::$business['lastname'] . '</p>
                        <p>&nbsp;</p>
                    </div>
                    
                    <div>
                        <p>' . $settings->footerComment . '</p>
                    </div>
                    
                    <div>
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="border-bottom:#dddddd solid 2px;">
                                    <th colspan="5" style="padding:0 0 10px 0;font-weight:bold;">' . $translation['bankHeadline'] . '</th>
                                </tr>
                            </thead>
                            <tbody style="border-top:#dddddd solid 2px;">
                                <tr style="background-color:#f9f9f9;">
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['bankRecipient'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['bankIBAN'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['bankBIC'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['bankName'] . '</th>
                                    <th style="padding:10px 0 10px 0;font-weight:bold;">' . $translation['vatnr'] . '</th>
                                </tr>
                                <tr style="border-top:#dddddd solid 1px;">
                                    <td>' . static::$business['firstname'] . ' ' . static::$business['lastname'] . '</td>
                                    <td>' . static::$business['iban'] . '</td>
                                    <td>' . static::$business['bic'] . '</td>
                                    <td>' . static::$business['bank'] . '</td>
                                    <td>' . static::$business['vatnr'] . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';


                $dompdf->loadHtml($html);

                // (Optional) Setup the paper size and orientation
                $dompdf->setPaper('A4', 'portrait');

                // Render the HTML as PDF
                $dompdf->render();

                // Output the generated PDF to Browser
                #$dompdf->stream();

                // Save the generated PDF at the server
                file_put_contents($customFolder . $invoice->invoiceId . ".pdf", $dompdf->output());

                $invoice->isSaved = 1;
                $invoice->save();

                $objT->notExists = true;
                $objT->customer = $customer;
                $objT->invoice = $invoice;
                $objT->path = $path.'/'.$customer->invoiceId.'/';
                return ($objT->parse());
            }
      }
  }

  /**
     * show Pdf Button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     * @param string  $strTable
     * @param array   $arrRootIds
     * @param array   $arrChildRecordsIds
     * @param bool    $blnCircularReference
     * @param string  $strPrevious
     * @param string  $strNext
     * @param array   $this
     *
     * @return string
     */
  public function showPdfButton($row, $href, $label, $title, $icon, $attributes)
  {
      $href .= '&amp;id='.$row['id'];

      return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>' . Image::getHtml((!$row['isSaved']) ? $icon : $icon  ) . '</a> ';
  }

  /**
   * Icon sendEmail Function
  */
  public function iconEmail($row, $href, $label, $title, $icon, $attributes)
  {
      $href .= '&amp;id='.$row['id'];

      $link = (!$row['isSend']) ? '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>' . Image::getHtml($icon ) . '</a> ' : '<a title="'.specialchars($GLOBALS['TL_LANG']['tl_invoice_invoices']['sendEmail'][2]).'"'.$attributes.'>' . Image::getHtml( 'bundles/cteyeinvoice/icon/successEmail.svg' ) . '</a> ';

      return $link;
  }
}