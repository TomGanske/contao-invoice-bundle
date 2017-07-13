<?php

$GLOBALS['TL_DCA']['tl_invoice_hosting'] = array
(
  'config' => array
  (
    'dataContainer'	  => 'Table',
    'ctable'          => 'tl_invoice_hosting_url',
    'switchToEdit'    => true,
    'enableVersioning'=> true,
    'sql'             => array
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
        'fields'          => array('customerId'),
        'flag'            => 1,
	),
    'label' => array
    (
      'fields'          => array('customerId'),
      'label_callback'  => array('tl_invoice_hosting','label')
    ),

    'operations' => array
    (
      'edit' => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['edit'],
          'href'	  => 'table=tl_invoice_hosting_url',
          'icon'      => 'edit.gif'
      ),
      'editheader' => array(
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['editheader'],
          'href'      => 'act=edit',
          'icon'      => 'header.gif'
      ),
      'delete'  => array
      (
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['show'],
          'href'        => 'act=delete',
          'icon'        => 'delete.gif'
      )
  ),
  ),
  'palettes' => array
  (
    'default'	      =>'customerId,hostStart,hostEnd,price,invoices;'
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
    'customerId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['customerId'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'select',
      'options_callback'=> array('tl_invoice_hosting','getCustomers'),
      'eval'            => array(
          'mandatory' => true,
          'includeBlankOption'=>true,
          'chosen' => true,
          'tl_class'=>'clr'
      ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'hostStart' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['hostStart'],
        'exclude'         => true,
        'inputType'       => 'text',
        'flag'            => 9,
        'eval'            => array('mandatory' => true,'rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
        'sql'             => "int(10) unsigned NULL"
    ),
    'hostEnd' => array
    (
          'label'           => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['hostEnd'],
          'exclude'         => true,
          'inputType'       => 'text',
          'flag'            => 9,
          'eval'            => array('mandatory' => true,'rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
          'sql'             => "int(10) unsigned NULL"
      ),
    'price' => array
    (
          'label'         => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['price'],
          'exclude'       => true,
          'inputType'     => 'text',
          'eval'          => array('mandatory'=>true,'tl_class'=>'w50'),
          'sql'           => "double precision default '0.00' NOT NULL"
      ),
    'invoices' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_hosting']['invoices'],
        'exclude'           => true,
        'inputType'         => 'select',
        'options_callback'  => array('tl_invoice_hosting','loadInvoices'),
        'eval'              => array('includeBlankOption'=>true,'chosen'=>true,'tl_class'=>'clr'),
        'sql'               => "varchar(255) NOT NULL default ''"
    )
   )
);


class tl_invoice_hosting extends Backend
{
    public $customers;
    public $childs;
    public $settings;

    public function __construct()
    {
        $customers = Database::getInstance()->prepare("SELECT * FROM tl_invoice_customers ORDER BY id")->execute()->fetchAllAssoc();
        foreach($customers as $value) {
            $this->customers[$value['id']] = $value;
        }

        $childs = Database::getInstance()->prepare("SELECT * FROM tl_invoice_hosting_url ORDER BY id")->execute()->fetchAllAssoc();
        foreach($childs as $value) {
            $this->childs[$value['pid']][] = $value;
        }

        $settings = Database::getInstance()->prepare("SELECT * FROM tl_invoice_settings ORDER BY id")->execute()->fetchAllAssoc();
        foreach($settings as $value) {
            $this->settings[$value['id']] =  $value;
        }
    }

    public function label($label)
    {
        $totalPrice = $label['price'];
        foreach((array)$this->childs[$label['id']] as $v) {
            $totalPrice += $v['price'];
        }

        return sprintf('
                    <span style="display:inline-block;width:200px">%s</span>
                   |<span style="display:inline-block;width:100px;text-align:center">%s %s</span>
                   |<span style="display:inline-block;width:100px;text-align:center">%s Domain(s)</span>',
            $this->customers[$label['customerId']]['company'],
            number_format(
                $totalPrice,
                $this->settings[$this->customers[$label['customerId']]['settingId']]['centValue'],
                $this->settings[$this->customers[$label['customerId']]['settingId']]['dec_point'],
                $this->settings[$this->customers[$label['customerId']]['settingId']]['thousands_sep']),
                $this->settings[$this->customers[$label['customerId']]['settingId']]['currency'],
                count($this->childs[$label['id']])
        );
    }

    public function loadInvoices($objDca)
    {
        $data = '';
        $invoices = Database::getInstance()
            ->prepare("SELECT * FROM tl_invoice_invoices WHERE customerId=? AND serviceTable=?")
            ->execute($objDca->activeRecord->customerId,'tl_invoice_hosting');

        while($invoices->next())
        {
            $data[$invoices->invoiceId] = $GLOBALS['TL_LANG']['Invoice']['document']['invoiceNo']. ' ' . $invoices->invoiceId . ' | '.$GLOBALS['TL_LANG']['Invoice']['document']['invoiceDate'] . ' '  . date($GLOBALS['TL_CONFIG']['dateFormat'],$invoices->date) . ' | ' .$GLOBALS['TL_LANG']['Invoice']['document']['invoiceDue'] . ' ' . date($GLOBALS['TL_CONFIG']['dateFormat'],$invoices->payDay);
        }

        return $data;
    }

    public function getCustomers()
    {
        $sql = Database::getInstance()
            ->prepare("SELECT * FROM tl_invoice_customers WHERE host=1 ORDER BY id")
            ->execute();

        while($sql->next())
        {
            $data[$sql->id] = "Nr: ".$sql->invoiceId ." ".$sql->company;
        }
        return $data;
    }
}