<?php

$GLOBALS['TL_DCA']['tl_invoice_invoicesElement'] = array
(
  'config' => array
  (
    'dataContainer'	  => 'Table',
    'ptable'          => 'tl_invoice_invoices',
    'switchToEdit'    => true,
    'sql'             => array
    (
       'keys' => array
        (
           'id' => 'primary',
           'pid'=> 'index'
        )
    )
  ),

  'list' => array
  (
    'sorting' => array
    (
      'mode'                  => 4,
      'fields'                => array('sorting'),
      'headerFields'          => array('customerId'),
      'child_record_callback' => array('tl_invoice_invoicesElement','childRecord')
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
          'label'     => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['edit'],
          'href'		  => 'act=edit',
          'icon'      => 'edit.gif'
      ),
      'show' => array
      (
          'label'       => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['show'],
          'href'        => 'act=show',
          'icon'        => 'show.gif'
      ),
      'delete'  => array(
          'label'             => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['show'],
          'href'              => 'act=delete',
          'icon'        => 'delete.gif'
      )
  ),
  ),
  'palettes' => array
  (
    'default'	=>'{info_legend},headline,price,description'

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
    'sorting' => array
    (
      'sql'             => "int(10) unsigned NOT NULL default '0'"
    ),
    'pid' => array
    (
        'foreignKey'     => 'tl_invoices_invoices.id',
        'sql'            => "int(10) unsigned NOT NULL default '0'"
    ),
    'headline' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['headline'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'text',
      'eval'            => array('mandatory'=>true,'tl_class'=>'w50'),
      'sql'             => "varchar(255) NOT NULL default ''"
    ),
    'price' => array
    (
        'label'         => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['price'],
        'exclude'       => true,
        'inputType'     => 'text',
        'eval'          => array('tl_class'=>'w50'),
        'sql'           => "varchar(255) NOT NULL default ''"
    ),
    'description' => array
    (
      'label'           => &$GLOBALS['TL_LANG']['tl_invoice_invoicesElement']['description'],
      'exclude'         => true,
      'filter'          => true,
      'inputType'       => 'textarea',
      'eval'            => array('mandatory'=>true,'tl_class'=>'clr','rte'=>'tinyMCE'),
      'sql'             => "text NOT NULL"
    )
   )
);

class tl_invoice_invoicesElement extends \Backend
{
    public function childRecord($arrRow)
    {
      $sql = Database::getInstance()->prepare("SELECT id,pid,headline FROM tl_invoice_invoicesElement WHERE id=?")->execute($arrRow['id'])->fetchAssoc();
      $out = '
             <div class="objectDiv  h113">'
                .'<span style="display:inline-block;width:300px;">'.$sql['headline'].'</span>
                </div>';
    return $out;
  }
}