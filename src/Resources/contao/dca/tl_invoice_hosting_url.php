<?php

$GLOBALS['TL_DCA']['tl_invoice_hosting_url'] = array
(
  'config' => array
  (
    'dataContainer'	  => 'Table',
    'ptable'          => 'tl_invoice_hosting',
    'switchToEdit'    => true,
    'enableVersioning'=> true,
    'sql'             => array
    (
       'keys' => array
        (
           'id'         => 'primary',
           'pid'        => 'index'
        )
    )
  ),

  'list' => array
  (
    'sorting' => array
    (
        'mode'			         => 4,
        'fields'                 => array('pid'), # group by
        'headerFields'           => array('id'),
        'panelLayout'            => 'filter;search',
        'disableGrouping'        => true,
        'child_record_callback'	 => array('tl_invoice_hosting_url','label')
	),
    'operations' => array
    (
      'edit' => array
      (
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_hosting_url']['edit'],
          'href'	  => 'act=edit',
          'icon'      => 'edit.gif'
      ),
      'delete'  => array
      (
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_hosting_url']['show'],
          'href'        => 'act=delete',
          'icon'        => 'delete.gif'
      )
  )
  ),
  'palettes' => array
  (
    'default'	      =>'domainName,tld,price;'
  ),
  'fields' => array
  (
    'id' => array
    (
        'sql'           => "int(10) unsigned NOT NULL auto_increment"
    ),
    'pid' => array
    (
        'foreignKey'     => 'tl_invoice_hosting.id',
        'sql'            => "int(10) unsigned NOT NULL default '0'",
        'relation'       => array('type'=>'belongsTo', 'load'=>'lazy')
    ),
    'tstamp' => array
    (
        'sql'           => "int(10) unsigned NOT NULL default '0'"
    ),
    'domainName' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_hosting_url']['domainName'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'tld' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_hosting_url']['tld'],
        'exclude'         => true,
        'inputType'       => 'select',
        'options'         => $GLOBALS['Invoice']['tld'],
        'eval'            => array('chosen'=>true,'tl_class'=>'w50'),
        'sql'             => "varchar(4) NOT NULL default ''"
    ),
    'price' => array
    (
    'label'         => &$GLOBALS['TL_LANG']['tl_invoice_hosting_url']['price'],
    'exclude'       => true,
    'inputType'     => 'text',
    'eval'          => array('tl_class'=>'w50'),
    'sql'           => "double precision default '0.00' NOT NULL"
)
   )
);


class tl_invoice_hosting_url extends Backend
{
    public function label($label)
    {
        return '<ul style="width:100%;height:auto;display:-webkit-flex;display:flex;margin:0;padding:0;justify-content:center;float:left;">
    			    <li style="list-style:none;-webkit-flex: 1;flex: 1;">'.$label['domainName'].$label['tld'].'</li>
                </ul>';
    }
}