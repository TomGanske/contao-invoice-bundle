<?php

namespace CtEye\Invoice;

use Contao\Backend;

class InvoiceData extends Backend
{
    // Properties
    public static $settings;
    public static $translation;
    public static $business;


    public function __construct()
    {
        $settings = \InvoiceSettingsModel::findAll()->fetchAll();
        foreach($settings as $value) {
            self::$settings[$value['id']] =  $value;
        }

        $translation = \InvoiceDocTransModel::findAll()->fetchAll();
        foreach($translation as $value) {
            self::$translation[$value['settingId']] =  $value;
        }

        self::$business = \InvoiceBusinessModel::findAll()->last()->row();
    }
}