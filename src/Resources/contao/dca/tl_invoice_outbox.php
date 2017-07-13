<?php

$GLOBALS['TL_DCA']['tl_invoice_outbox'] = array
(
  'config' => array
  (
    'dataContainer'	   => 'Table',
    'switchToEdit'     => true,
    'enableVersioning' => true,
    'closed'           => true,
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
        'fields'          => array('tstamp'),
        'panelLayout'     => 'filter;search,limit,sort'
	),

    'label' => array
    (
      'fields'          => array('id'),
      'label_callback'  => array('tl_invoice_outbox','label')
    ),
  
    'global_operations' => array
    (
    ),
    
    'operations' => array
    (
      'edit' => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['edit'],
          'href'	  => 'act=edit',
          'icon'      => 'edit.gif'
      ),
      'show' => array
      (
          'label'   => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['show'],
          'href'    => 'act=show',
          'icon'    => 'show.gif'
      ),
      'delete'  => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['delete'],
          'href'      => 'act=delete',
          'icon'      => 'delete.gif',
          'attributes'=> 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['tl_invoice_outbox']['delete'] . '\'))return false;Backend.getScrollOffset()"',
      )
  )
  ),

  'palettes' => array
  (
    'default'	      =>'
                       {outbox_legend},invoiceId,tstamp,customerId,customEmail,hash;'
  ),

  'fields' => array
  (
    'id' => array
    (
        'sql'           => "int(10) unsigned NOT NULL auto_increment"
    ),
    'tstamp' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['tstamp'],
        'exclude'         => true,
        'inputType'       => 'text',
        'eval'            => array('rgxp'=>'datim','includeBlankOption'=>true,'tl_class'=>'w50','readonly'=>true),
        'sql'             => "int(10) unsigned NOT NULL default '0'"
    ),
    'customerId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['customerId'],
      'exclude'         => true,
      'filter'          => true,
      'foreignKey'      => 'tl_invoice_customers.CONCAT(company)',
      'inputType'       => 'select',
      'eval'            => array('includeBlankOption'=>true,'tl_class'=>'clr','readonly'=>true),
      'sql'             => "smallint(4) unsigned DEFAULT '0' NOT NULL"
    ),
    'invoiceId' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['invoiceId'],
      'inputType'       => 'text',
      'exclude'         => true,
      'search'          => true,
      'eval'            => array('readonly'=>true,'tl_class'=>'w50','readonly'=>true),
      'sql'             => "varchar(10) NOT NULL DEFAULT ''"
    ),
    'customEmail' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['customEmail'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50','readonly'=>true),
        'sql'           => "varchar(255) NOT NULL DEFAULT ''"
    ),
    'hash' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_outbox']['hash'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50','readonly'=>true),
        'sql'           => "varchar(255) NOT NULL DEFAULT ''"
    )
   )
);

class tl_invoice_outbox extends \CtEye\Invoice\Invoice
{
  /**
   * return Custom Label
   */
  public function label($label)
  {
      return sprintf('<span style="display:inline-block;width:50px">%s</span>
                      <span style="display:inline-block;width:180px;">%s</span>
                      <span style="display:inline-block;width:auto;">%s</span>',
            (($label['invoiceId'] == 0) ? '': $label['invoiceId'] ),
            $label['customEmail'],
            date($GLOBALS['TL_CONFIG']['datimFormat'],$label['tstamp'])
        );
  }
}