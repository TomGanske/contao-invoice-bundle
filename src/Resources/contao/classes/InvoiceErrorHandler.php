<?php

namespace CtEye\Invoice;

use Contao\Message;

class InvoiceErrorHandler
{
    public static function fieldMissing($fieldString)
    {
        Message::add(
            sprintf($GLOBALS['TL_LANG']['InvoiceErrorHandler']['field_error'],$fieldString),
            'TL_ERROR'
        );
    }
}