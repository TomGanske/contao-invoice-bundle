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
        /**
         * Fill Variable $settings if result exists
        */
        $settings = \InvoiceSettingsModel::findAll();
        if($settings !== NULL) {
            $settings = $settings->fetchAll();
            foreach ($settings as $value) {
                self::$settings[$value['id']] = $value;
            }
        }

        /**
         * Fill Variable $translation if result exists
         */
        $translation = \InvoiceDocTransModel::findAll();
        if($translation !== NULL){
            $translation = $translation->fetchAll();
            foreach($translation as $value) {
                self::$translation[$value['settingId']] =  $value;
            }
        }

        /**
         * Fill Variable $business if result exists
         */
        $business = \InvoiceBusinessModel::findAll();
        if($business !== NULL)
            self::$business = $business->last()->row();
    }
}