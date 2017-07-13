<?php

use Contao\Model;

class InvoiceInvoicesModel extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_invoice_invoices';

    private static $oModel;
    private static $annualAmount;

    /**
     * Return Model with data for the input YEAR
     */
    public static function currentYear($strYear)
    {
        $t = static::$strTable;
        $arrColumns = array("(YEAR(FROM_UNIXTIME(payDay)))=?","isPaid=?");
        $arrValues  = array($strYear,'1');
        $arrOptions = array('order'  => "$t.payDay DESC");

        self::$oModel = static::findBy($arrColumns, $arrValues, $arrOptions);

        return self::$oModel;
    }

    /**
     * Return Collection fo all years where Invoices exists
    */
    public static function getAllYears()
    {
        $t          = static::$strTable;
        $value      = [];
        $oResult    = \Contao\Database::getInstance()->execute("SELECT YEAR(FROM_UNIXTIME(payDay)) as year FROM $t GROUP BY YEAR(FROM_UNIXTIME($t.payDay)) ORDER BY YEAR(FROM_UNIXTIME($t.payDay)) DESC");

        while($oResult->next())
        {
            $value[$oResult->year] = $oResult->year;
        }

        return $value;
    }

    /**
     * Return SUM of incoming of the current year
     */
    public static function amountSum()
    {
        $oModelClone = clone self::$oModel;
        while ($oModelClone->next())
        {
            self::$annualAmount += $oModelClone->totalPrice;
        }

        return self::$annualAmount;
    }

    /**
     * Count Invoice by ID
     * @param int $customerId
     * @param array $arrOptions
     * @return collection/model
    */
    public static function countById($customerId,$arrOptions)
    {
        $t = static::$strTable;
        $arrColumns = array("$t.customerId=?");
        $arrValues  = array($customerId);
        return static::findBy($arrColumns, $arrValues, $arrOptions);
    }
}