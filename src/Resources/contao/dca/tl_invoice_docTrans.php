<?php

$GLOBALS['TL_DCA']['tl_invoice_docTrans'] = array
(

  'config' => array
  (
      'dataContainer'	  => 'Table',
      'switchToEdit'	  => true,
      'enableVersioning'  => true,
      'onload_callback'   => array(array('tl_invoice_docTrans','onloadCallback')),
      'sql'               => array
      (
          'keys' => array
          (
            'id'          => 'primary',
            'settingId'  => 'unique'
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
        'label_callback'    => array('tl_invoice_docTrans','label')
	),

    'global_operations' => array
    (
        'back' => array
        (
            'label'             => &$GLOBALS['TL_LANG']['MSC']['backBT'],
            'href'              => 'mod=&table=',
            'class'             => 'header_back',
            'attributes'        => 'onclick="Backend.getScrollOffset();"',
        )
    ),

    'operations' => array
    (
      'edit' => array
      (
        'label'               	=> &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['edit'],
        'href'				  	=> 'act=edit',
        'icon'                	=> 'edit.gif',
      ),
      'delete'  => array(
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['delete'],
          'href'        => 'act=delete',
          'icon'        => 'delete.gif'
      ),
      'show' => array
      (
          'label'               => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['show'],
          'href'                => 'act=show',
          'icon'                => 'show.gif'
      )
    )
	
  ),

  'palettes' => array
  (
    'default'	        =>'	{language_legend:hide},settingId;
                            {fldTranslate_legend:hide},_from,_to,invoiceTitle,invoiceNo,invoiceDate,invoiceDue,invoiceAmount,price,subtotal,totalprice,service,
                                                       pos,description,vatnr,taxtitle,regards,bankHeadline,bankRecipient,bankIBAN,
                                                       bankBIC,bankName;'
  ),

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
    'settingId' => array
    (
          'label'           => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['settingId'],
          'inputType'       => 'select',
          'options_callback'=> array('tl_invoice_docTrans','languageOptionCallback'),
          'eval'            => array('tl_class'=>'w50','unique'=>true,'mandatory'=>true,'includeBlankOption'=>true,'chosen'=>true),
          'sql'             => "varchar(3) NOT NULL default ''"
    ),
    '_from' => array
    (
      'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['from'],
      'inputType'            	=> 'text',
      'eval'                    => array('tl_class'=>'w50'),
      'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    '_to' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['to'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'invoiceTitle' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['invoiceTitle'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'invoiceNo' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['invoiceNo'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'invoiceDate' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['invoiceDate'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'invoiceDue' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['invoiceDue'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'invoiceAmount' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['invoiceAmount'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'price' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['price'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'subtotal' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['subtotal'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'totalprice' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['totalprice'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'service' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['service'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'pos' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['pos'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'vatnr' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['vatnr'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'taxtitle' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['taxtitle'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'description' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['description'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'regards' => array
    (
        'label'                 => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['regards'],
        'inputType'            	=> 'textarea',
        'style'                 =>'height:80px',
        'eval'                  => array('class'=>'noresize','tl_class'=>'clr'),
        'sql'                   => "text NULL"
    ),
    'bankHeadline' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['bankHeadline'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'bankRecipient' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['bankRecipient'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'bankIBAN' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['bankIBAN'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'bankBIC' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['bankBIC'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    ),
    'bankName' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_invoice_docTrans']['bankName'],
        'inputType'            	=> 'text',
        'eval'                    => array('tl_class'=>'w50'),
        'sql'                     => "varchar(20) NOT NULL default ''"
    )
  )
);


class tl_invoice_docTrans extends Backend
{
    // settings Property for Label
    public $allSettings;

    // All Settings which has no children and they are selectable for translation
    // (minimize the select options, if translations are exists). see: languageOptionsCallback()
    public $settings;

    public function __construct()
    {
        $sql = Database::getInstance()
            ->prepare("SELECT * FROM tl_invoice_settings ORDER BY id")
            ->execute();
        while($sql->next())
        {
            $this->allSettings[$sql->id] = $sql->row();
        }

        $sql = Database::getInstance()
            ->prepare("SELECT parent.* FROM tl_invoice_settings as parent
                       WHERE
                       NOT EXISTS (SELECT * FROM `tl_invoice_doctrans`as child WHERE child.settingId = parent.id)")
            ->execute();
        while($sql->next())
        {
            $this->settings[$sql->id] = $sql->row();
        }
    }

    public function label($label)
    {
        return sprintf('%s - %s',
            $GLOBALS['TL_LANG']['Invoice']['translation'],$this->getCountries()[$this->allSettings[$label['settingId']]['language']]);
    }

    public function languageOptionCallback($oDca)
    {
        $aData = [];
        if(!empty($oDca->activeRecord->settingId)) {
            foreach ($this->allSettings as $k => $v) {
                $aData[$k] = 'ID: ' . $v['id'] . ' - ' . $this->getCountries()[$v['language']];
            }
        }
        else {
            foreach ($this->settings as $k => $v) {
                $aData[$k] = 'ID: ' . $v['id'] . ' - ' . $this->getCountries()[$v['language']];
            }
        }
        return $aData;
    }


    public function onloadCallback()
    {
        if(is_null($this->settings))
            $GLOBALS['TL_DCA']['tl_invoice_docTrans']['config']['closed'] = true;
    }
}