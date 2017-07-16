<?php

$GLOBALS['TL_DCA']['tl_invoice_customers'] = array
(
  'config' => array
  (
    'dataContainer'	  => 'Table',
    'switchToEdit'    => true,
    'onsubmit_callback'=>array(array('tl_invoice_customers','createCustomIdFolder')),
    'sql'             => array
    (
       'keys' => array
        (
           'id' => 'primary'
        )
    )
  ),

  'list' => array
  (

    'sorting' => array
    (
        'fields'        => array('invoiceId'),
        'panelLayout'   => 'filter,search,limit,sort'
	),

    'label' => array
    (
      'fields'          => array('company'),
      'label_callback'  => array('tl_invoice_customers','label')
    ),
  
    'global_operations' => array
    (
      'all' => array
      (
        'label'         => &$GLOBALS['TL_LANG']['MSC']['all'],
        'href'          => 'act=select',
        'class'         => 'header_edit_all',
        'attributes'    => 'onclick="Backend.getScrollOffset()" accesskey="e"'
      )
    ),
    
    'operations' => array
    (

      'edit' => array
      (
          'label'   => &$GLOBALS['TL_LANG']['tl_invoice_customers']['edit'],
          'href'	=> 'act=edit',
          'icon'    => 'edit.gif'
      ),
      'show' => array
      (
          'label'   => &$GLOBALS['TL_LANG']['tl_invoice_customers']['show'],
          'href'    => 'act=show',
          'icon'    => 'show.gif'
      ),
      'delete'  => array(
          'label'   => &$GLOBALS['TL_LANG']['tl_invoice_customers']['delete'],
          'href'    => 'act=delete',
          'icon'    => 'delete.gif'
      )
  ),
  ),

  'palettes' => array
  (
    '__selector__'		=>	array('setTax'),
    'default'	        => '{info_legend},invoiceId,company,title,salutation,firstname,lastname,street,zip,town,country;
                            {setting_legend:hide},settingId;
                            {domain_legend},email,domainName,tld;
                            {payment_legend},period;
                            {hosting_legend},host;'

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
    'invoiceId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['invoiceId'],
      'exclude'         => true,
      'search'          => true,
      'filter'          => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "smallint(4) unsigned DEFAULT '0' NOT NULL"
    ),
    'company' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['company'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'title' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['title'],
        'exclude'         => true,
        'inputType'       => 'select',
        'options'         => array(
            $GLOBALS['TL_LANG']['tl_invoice_customers']['title']['value'][0],
            $GLOBALS['TL_LANG']['tl_invoice_customers']['title']['value'][1],
            $GLOBALS['TL_LANG']['tl_invoice_customers']['title']['value'][2],
        ),
        'eval'            => array(
            'includeBlankOption' => true,
            'chosen'=>true,
            'tl_class' => 'w50'
        ),
        'sql'           => "varchar(10) NOT NULL default ''"
    ),
    'salutation' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['salutation'],
        'exclude'         => true,
        'inputType'       => 'select',
        'options'         => array(
            $GLOBALS['TL_LANG']['tl_invoice_customers']['salutation']['value'][0],
            $GLOBALS['TL_LANG']['tl_invoice_customers']['salutation']['value'][1],
            $GLOBALS['TL_LANG']['tl_invoice_customers']['salutation']['value'][2],
        ),
        'eval'            => array(
            'includeBlankOption' => true,
            'chosen'=>true,
            'tl_class'=>'w50'
        ),
        'sql'           => "varchar(3) NOT NULL default ''"
    ),
    'firstname' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_customers']['firstname'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "varchar(255) NOT NULL default ''"
    ),
    'lastname' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['lastname'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'street' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['street'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'clr'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'zip' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['zip'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(10) NOT NULL default ''"
    ),
    'town' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['town'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'country' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['country'],
      'exclude'         => true,
      'inputType'       => 'select',
      'options'         => $this->getCountries(),
      'eval'            => array(
        'mandatory'=>true,
        'includeBlankOption'=>true,
        'chosen'=>true,
        'tl_class'=>'w50'
      ),
      'sql'             => "varchar(3) NOT NULL default ''"
    ),
    'settingId' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['settingId'],
        'exclude'         => true,
        'inputType'       => 'select',
        'foreignKey'      => 'tl_invoice_settings.CONCAT("ID: ", id," - ",language)',
        'eval'            => array(
            'mandatory'=>true,
            'includeBlankOption'=>true,
            'chosen'=>true,
            'tl_class'=>'w50'
        ),
        'sql'             => "smallint(2) unsigned NOT NULL default '0'"
    ),
    'email' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['email'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array('mandatory'=>true,'tl_class'=>'w50'),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'domainName' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['domainName'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array('mandatory'=>true,'tl_class'=>'w50 clr'),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'tld' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['tld'],
        'exclude'         => true,
        'inputType'       => 'select',
        'options'         => $GLOBALS['Invoice']['tld'],
        'eval'            => array('mandatory'=>true,'chosen'=>true,'tl_class'=>'w50'),
        'sql'             => "varchar(4) NOT NULL default ''"
    ),
    'period' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['period'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "smallint(2) unsigned DEFAULT '0' NOT NULL"
    ),
    'host' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_customers']['host'],
        'exclude'         => true,
        'search'          => true,
        'inputType'       => 'checkbox',
        'eval'            => array('tl_class'=>'clr m12'),
        'sql'             => "char(1) NOT NULL default '0'"
    )
   )
);

class tl_invoice_customers extends Backend
{
    /**
     * return Custom Label > html code
    */
    public function label($label)
    {
        return sprintf('<span style="display:inline-block;font-weight:400;width:200px;border-right:#e9e9e9 solid 1px">%s</span>
                        <span style="display:inline-block;width:200px;text-align:center;border-right:#e9e9e9 solid 1px">%s</span>
                        <span style="display:inline-block;padding-left:20px;"><a href="http://%s%s" target="_blank" rel="nofollow">%s%s</a></span>',
            ((!empty($label['company'])) ? $label['company'] : $label['firstname']. ' '. $label['lastname']),
            ($label['host']) ? 'Hosting: Yes' : '',
            $label['domainName'],
            $label['tld'],
            $label['domainName'],
            $label['tld']);
    }


    /**
     * Create Custom Folder for Invoices sorted by invoiceId !
     * @param DataContainer $dc
    */
    public function createCustomIdFolder($dc)
    {
        $objSettings = InvoiceSettingsModel::findByPk($dc->activeRecord->settingId);

        // get root Path saved in Settings
        $uuid           = \Contao\StringUtil::binToUuid($objSettings->invoiceTree);
        $objFile        = FilesModel::findByUuid($uuid);
        $path           = $objFile->path;

        // set destination path on SERVER
        $destinationPath = $_SERVER['DOCUMENT_ROOT']."/".$path."/".$dc->activeRecord->invoiceId;


        #var_dump($_SERVER);
        #var_dump($_SERVER['DOCUMENT_ROOT']);
        #var_dump($destinationPath);

        // create custom folder by invoiceId as Primary Key
        if(!file_exists($destinationPath))
            mkdir($destinationPath,0777);
    }
}