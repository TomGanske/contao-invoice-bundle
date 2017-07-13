<?php

$GLOBALS['TL_DCA']['tl_invoice_services'] = array
(
  'config' => array
  (
    'dataContainer'	  => 'Table',
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
        'fields'          => array('id'),
        'flag'            => 1,
	),
    'label' => array
    (
      'fields'          => array('service'),
      'label'           => '%s'
    ),
  
    'global_operations' => array
    (
      'all' => array
      (
          'label'         => &$GLOBALS['TL_LANG']['MSC']['all'],
          'href'          => 'act=select',
          'class'         => 'header_edit_all',
          'attributes'    => 'onclick="Backend.getScrollOffset()" accesskey="e"'
      ),
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
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_services']['edit'],
          'href'	  => 'act=edit',
          'icon'      => 'edit.gif'
      ),
      'delete'  => array
      (
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_services']['show'],
          'href'        => 'act=delete',
          'icon'        => 'delete.gif'
      )
  ),
  ),
  'palettes' => array
  (
    'default'	      =>'service,serviceTable;'
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
    'service' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_services']['service'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'text',
      'eval'            => array('tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'serviceTable' => array
    (
        'label'           => &$GLOBALS['TL_LANG']['tl_invoice_services']['serviceTable'],
        'exclude'         => true,
        'inputType'       => 'text',
        'default'         => 'tl_invoice_',
        'eval'            => array('tl_class'=>'w50'),
        'sql'             => "varchar(255) NOT NULL default ''"
    )
   )
);