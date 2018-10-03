<?php

$GLOBALS['TL_DCA']['tl_invoice_settings'] = array
(

  'config' => array
  (
      'dataContainer'	  => 'Table',
      'switchToEdit'	  => true,
      'enableVersioning'  => true,
      'sql'               => array
      (
          'keys' => array
          (
            'id'        => 'primary',
            'language'  => 'unique'
          )
      )
  ),

  'list' => array
  (
    'sorting' => array
    (	
	),
	
	'label' => array
	(
		'fields'			=> array('id'),
        'label_callback'    => array('tl_invoice_settings','label')
	),

    'global_operations' => array
    (
        'translation' => array
        (
            'label'         => &$GLOBALS['TL_LANG']['tl_invoice_settings']['translation'],
            'href'          => 'table=tl_invoice_docTrans&amp;key=show',
            'class'         => 'header_new',
            'attributes'    => 'onclick="Backend.getScrollOffset()" accesskey="e"'
        )
    ),

    'operations' => array
    (
      'edit' => array
      (
        'label'               	=> &$GLOBALS['TL_LANG']['tl_invoice_settings']['edit'],
        'href'				  	=> 'act=edit',
        'icon'                	=> 'edit.gif',
      ),
      'delete'  => array(
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_settings']['delete'],
          'href'        => 'act=delete',
          'icon'        => 'delete.gif'
      ),
      'show' => array
      (
          'label'               => &$GLOBALS['TL_LANG']['tl_invoice_settings']['show'],
          'href'                => 'act=show',
          'icon'                => 'show.gif'
      )
    )
	
  ),

  'palettes' => array
  (

    'default'	        =>'	{language_legend:hide},language;
                            {format_legend:hide},currency,centValue,dec_point,thousands_sep;
                            {textblock_legend:hide},subject,html;
                            {path_legend:hide},invoiceTree;
                            {footer_legend},footerComment;'
  ),
   # implement later if be sure to use it really
   #{invoiceDate_legend:hide},invoiceDate,invoicePayDate;

  'fields' => array
  (
    'id' => array
    (
        'sql'               => "int(10) unsigned NOT NULL auto_increment"
    ),
    'tstamp' => array
    (
        'sql'               => "int(10) unsigned NOT NULL default '0'"
    ),
    'language' => array
    (
          'label'           => &$GLOBALS['TL_LANG']['tl_invoice_settings']['language'],
          'inputType'       => 'select',
          'options'         => $this->getCountries(),
          'search'          => true,
          'eval'            => array('tl_class'=>'w50','unique'=>true,'mandatory'=>true,'includeBlankOption'=>true,'chosen'=>true),
          'sql'             => "varchar(3) NOT NULL default ''"
    ),
    'currency' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_settings']['currency'],
      'inputType'            	=> 'select',
      'options'					=> array('-','฿','B/.','₵','₡','圓','₫','Դ','ƒ','₴','₭','kr','₦','元','₪','S/.','₱','£','€','$','R','R$','៛','﷼','₽','৲','૱','௹','〒','₮','₩','¥','Zł'),
      'search'                  => true,
      'eval'                    => array('tl_class'=>'w50'),
      'sql'                     => "varchar(19) NOT NULL default ''"
    ),
    'centValue' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_settings']['centValue'],
      'inputType'            	=> 'select',
      'options'					=> array(0,2),
      'eval'                    => array('tl_class'=>'w50'),
      'sql'                     => "char(1) NOT NULL default '0'"
    ),
    'dec_point' => array
    (
        'label'              => &$GLOBALS['TL_LANG']['tl_invoice_settings']['dec_point'],
        'inputType'          => 'select',
        'options'			   => array(',','.'),
        'eval'               => array('tl_class'=>'w50'),
        'sql'                => "char(1) NOT NULL default ','"
    ),
    'thousands_sep' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_settings']['thousands_sep'],
        'inputType'            	=> 'select',
        'options'					=> array('.',','),
        'search'                  => true,
        'eval'                    => array('tl_class'=>'w50'),
        'sql'               => "char(1) NOT NULL default '.'"
    ),
    'invoiceDate' => array
    (
          'label'           => &$GLOBALS['TL_LANG']['tl_invoice_settings']['invoiceDate'],
          'exclude'         => true,
          'inputType'       => 'text',
          'flag'            => 9,
          'eval'            => array('mandatory' => true,'rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
          'sql'             => "int(10) unsigned NULL"
      ),
    'invoicePayDate' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_settings']['invoicePayDate'],
        'exclude'         => true,
        'inputType'       => 'text',
        'flag'            => 9,
        'eval'            => array('mandatory' => true,'rgxp'=>'date','datepicker'=>true,'tl_class'=>'w50 wizard'),
        'sql'             => "int(10) unsigned NULL"
    ),
    'subject' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_settings']['subject'],
        'inputType'         => 'text',
        'eval'              => array
        (
            'tl_class'=>'long',
        ),
        'sql'               => "varchar(255) NOT NULL default '' "
    ),
    'html' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_settings']['html'],
        'inputType'         => 'textarea',
        'eval'              => array
        (
            'tl_class'=>'clr long',
            'style'=>'height:100px',
            'class'=>'noresize',
            'allowHtml' => true,
            'rte' => 'tinyMCE'
        ),
        'sql'               => "text NULL"
    ),
    'invoiceTree' => array
    (
          'label'             => &$GLOBALS['TL_LANG']['tl_invoice_settings']['invoiceTree'],
          'inputType'         => 'fileTree',
          'eval'              => array(
              'filesOnly'=>false,
              'fieldType'=>'radio',
              'mandatory'=>true),
          'sql'               => "binary(16) NULL"
     ),
    'footerComment' => array
    (
        'label'             => &$GLOBALS['TL_LANG']['tl_invoice_settings']['footerComment'],
        'inputType'         => 'textarea',
        'eval'              => array
        (
            'tl_class'=>'clr',
            'style'=>'height:100px',
            'class'=>'noresize',
            'allowHtml' => true
        ),
        'sql'               => "text NULL"
    )
  )
);



class tl_invoice_settings extends Backend
{
    public $translations;

    public function __construct()
    {
        $sql = Database::getInstance()
            ->prepare("SELECT * FROM tl_invoice_docTrans ORDER BY id")
            ->execute();

        while($sql->next())
        {
            $this->translations[$sql->settingId] = $sql->row();
        }
    }

    public function label($label)
    {
        /**
         * No Translation exists
        */
        if(is_null($this->translations))
            return sprintf('%s - %s %s',
                $GLOBALS['TL_LANG']['Invoice']['settings'],
                $this->getCountries()[$label['language']],
                ' [ <strong style="color:#f15163">'.$GLOBALS['TL_LANG']['Invoice']['noTranslationExists'].'</strong> ]');

        return sprintf('%s - %s   %s',
            $GLOBALS['TL_LANG']['Invoice']['settings'],
            $this->getCountries()[$label['language']],
            ((array_key_exists($label['id'],$this->translations)) ? '' : ' [ <strong style="color:#f15163">'.$GLOBALS['TL_LANG']['Invoice']['noTranslationExists'].'</strong> ]' )
        );
    }
}