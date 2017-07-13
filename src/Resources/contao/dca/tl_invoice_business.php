<?php

$GLOBALS['TL_DCA']['tl_invoice_business'] = array
(
  'config' => array
  (
    'dataContainer'     => 'Table',
    'onload_callback'   => array(array('tl_invoice_business','closeDataSet')),
    'switchToEdit'      => true,
    'enableVersioning'  => true,
    'sql'               => array
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
          'mode'			=> 1,
          'flag'          => 1,
          'fields'        => array('company')
      ),

      'label' => array
      (
          'fields'          => array('company'),
          'label'           => '%s'
      ),

      'operations' => array
      (
          'edit' => array
          (
              'label'   => &$GLOBALS['TL_LANG']['tl_invoice_business']['edit'],
              'href'	=> 'act=edit',
              'icon'    => 'edit.gif'
          ),
          'show' => array
          (
              'label'   => &$GLOBALS['TL_LANG']['tl_invoice_business']['show'],
              'href'    => 'act=show',
              'icon'    => 'show.gif'
          ),
          'delete'  => array(
              'label'   => &$GLOBALS['TL_LANG']['tl_invoice_business']['show'],
              'href'    => 'act=delete',
              'icon'    => 'delete.gif'
          )
      ),
  ),

  'palettes' => array
  (
    '__selector__'	=>	array('setTax'),
    'default'	=>'{company_legend:hide},company,vatnr,title,salutation,firstname,lastname,street,zip,town,country;
                   {contact_legend:hide},email,url,phone;
                   {bank_legend:hide},bank,iban,bic;
                   {tax_legend:hide},setTax;
                   {paypal_legend:hide},payPalEmail;
                   {sign_legend:hide},sign;
                   {logo_legend:hide},logo;
                   {email_legend:hide},emailCopy;'

  ),

  'subpalettes'	=> array
  (
      'setTax'					=> 'tax,taxStartDate'
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
    'company' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['company'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'mandatory' => true,
          'tl_class'=>'clr'
      ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'vatnr' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['vatnr'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'tl_class'=>'clr'
        ),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'title' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['title'],
      'exclude'         => true,
      'inputType'       => 'select',
      'options'         => array(
          $GLOBALS['TL_LANG']['tl_invoice_business']['title']['value'][0],
          $GLOBALS['TL_LANG']['tl_invoice_business']['title']['value'][1],
          $GLOBALS['TL_LANG']['tl_invoice_business']['title']['value'][2],
      ),
      'eval'            => array(
          'includeBlankOption' => true,
          'tl_class' => 'w50'
      ),
      'sql'             => "varchar(10) NOT NULL default ''"
    ),
    'salutation' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['salutation'],
        'exclude'         => true,
        'inputType'       => 'select',
        'options'         => array(
            $GLOBALS['TL_LANG']['tl_invoice_business']['salutation']['value'][0],
            $GLOBALS['TL_LANG']['tl_invoice_business']['salutation']['value'][1],
            $GLOBALS['TL_LANG']['tl_invoice_business']['salutation']['value'][2],
        ),
        'eval'            => array(
            'mandatory' => true,
            'includeBlankOption' => true,
            'tl_class'=>'w50'
        ),
        'sql'             => "varchar(3) NOT NULL default ''"
    ),
    'firstname' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_business']['firstname'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array(
            'tl_class'=>'w50'
        ),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'lastname' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['lastname'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'mandatory' => true,
          'tl_class'=>'w50'
      ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'street' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['street'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'mandatory' => true,
          'tl_class'=>'clr'
      ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'zip' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['zip'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'mandatory' => true,
          'tl_class'=>'w50'
      ),
      'sql'             => "varchar(10) NOT NULL default ''"
    ),
    'town' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['town'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'mandatory' => true,
          'tl_class'=>'w50'
      ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'country' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['country'],
      'exclude'         => true,
      'inputType'       => 'select',
      'options'         => $this->getCountries(),
      'eval'            => array(
          'mandatory' => true,
          'includeBlankOption' => true,
          'chosen' => true,
          'tl_class'=>'w50'
      ),
      'sql'             => "varchar(3) NOT NULL default ''"
    ),
    'bank' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['bank'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'tl_class'=>'clr'
        ),
        'sql'             => "varchar(130) NOT NULL default ''"
    ),
    'payPalEmail' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['payPalEmail'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'rgxp' => "email",
            'tl_class'=>'clr'
        ),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'iban' => array
    (
          'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['iban'],
          'exclude'         => true,
          'inputType'       => 'text',
          'eval'            => array(
              'tl_class'=>'w50'
          ),
          'sql'             => "varchar(31) NOT NULL default ''"
    ),
    'bic' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['bic'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'tl_class'=>'w50'
        ),
        'sql'             => "varchar(11) NOT NULL default ''"
    ),
    'url' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['url'],
      'exclude'         => true,
      'inputType'       => 'text',
      'eval'            => array(
          'tl_class'=>'w50',
          'rgxp' => 'url'
          ),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'email' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['email'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'tl_class'=>'w50',
            'rgxp' => 'email'
        ),
        'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'phone' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['phone'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array(
            'tl_class'=>'w50',
            'rgxp' => 'phone'
        ),
        'sql'             => "varchar(255) NOT NULL default ''"
   ),
    'sign' => array
    (
       'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['sign'],
       'exclude'         => true,
       'inputType'       => 'fileTree',
       'eval'            => array(
           'filesOnly'=>true,
           'extensions'=>Config::get('validImageTypes'),
           'fieldType'=>'radio',
           'tl_class'=>'clr'),
       'sql'             => "binary(16) NULL"
    ),
    'logo' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_business']['logo'],
        'exclude'         => true,
        'inputType'       => 'fileTree',
        'eval'            => array(
            'filesOnly'=>true,
            'extensions'=>Config::get('validImageTypes'),
            'fieldType'=>'radio',
            'tl_class'=>'clr'),
        'sql'             => "binary(16) NULL"
    ),
    'setTax' => array
    (
        'label'               => &$GLOBALS['TL_LANG']['tl_invoice_business']['setTax'],
        'inputType'           => 'checkbox',
        'eval'                => array('tl_class'=>'m12 clr','submitOnChange'=>true),
        'sql'                 => "char(1) NOT NULL default ''"
    ),
    'tax' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_business']['tax'],
        'inputType'         => 'text',
        'eval'              => array('tl_class'=>'w50'),
        'sql'               => "smallint(2) unsigned NOT NULL default '0'"
    ),
    'taxStartDate' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_business']['taxStartDate'],
        'inputType'         => 'text',
        'eval'              => array('rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
        'sql'               => "int(10) unsigned NULL"
    ),
    'emailCopy' => array
    (
        'label'               => &$GLOBALS['TL_LANG']['tl_invoice_business']['emailCopy'],
        'inputType'           => 'checkbox',
        'eval'                => array('tl_class'=>'m12 clr','submitOnChange'=>true),
        'sql'                 => "char(1) NOT NULL default ''"
    ),
  )
);

class tl_invoice_business extends Backend
{
    /**
     * Close DataContainer if one data set was found.
    */
    public function closeDataSet()
    {
        $GLOBALS['TL_DCA']['tl_invoice_business']['config']['closed']  = (InvoiceBusinessModel::countAll() > 0) ? true : false;
    }
}