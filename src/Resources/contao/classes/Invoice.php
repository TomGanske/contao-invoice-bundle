<?php
namespace CtEye\Invoice;

use Contao\BackendTemplate;
use Contao\Database;

class Invoice extends InvoiceData
{

    // Load Invoices by Year
    private function InvoiceSelectYears()
    {
        return \Database::getInstance()->execute("SELECT YEAR(FROM_UNIXTIME(payDay)) AS payYear FROM tl_invoice_invoices GROUP BY payYear DESC")->fetchAllAssoc();
    }

    // return total income of the year
    public function getTotalAmountYear($year = null){
        $result = \Contao\Database::getInstance()->prepare("SELECT SUM(price) AS amount FROM tl_invoice_invoices WHERE YEAR(FROM_UNIXTIME(payDay))=?")->execute(date("Y"))->fetchAssoc();
        return $this->priceFormat($result['amount']);
    }

    // return average income by month
    public function getAverageIncomeByMonth()
    {
        $result = \Contao\Database::getInstance()->prepare("SELECT SUM(price) AS amount FROM tl_invoice_invoices WHERE YEAR(FROM_UNIXTIME(payDay))=?")->execute(date("Y"))->fetchAssoc();
        return $this->priceFormat($result['amount'] / 12);
    }


    /**
     * Create automatic Invoices for Web-Hosting Contracts
    */
    public function createHostingInvoices()
    {

        $objTemplate             = new BackendTemplate('be_showListofHostingUpdates');
        $objTemplate->hrefBack   = ampersand(str_replace('&key=createHostingInvoices', '', \Environment::get('request')));
        $objTemplate->goBack     = $GLOBALS['TL_LANG']['MSC']['goBack'];
        $domains                 = '';
        $invoiceExists           = [];
        $timestamp               = mktime(0,0,0,1,1,date('Y'));
        $thisYear                = date("Y",$timestamp);
        $nextYear                = date("Y",$timestamp+1);



        // get Hosted Domains and create an ID string '1,2,...'
        $hostedDomains = Database::getInstance()
            ->execute("SELECT customer.id AS cId,
                              customer.company,
                              customer.period, 
                              sett.*
                              FROM tl_invoice_customers AS customer,tl_invoice_settings AS sett WHERE customer.settingId = sett.id AND customer.host=1 ORDER BY customer.id");

        while($hostedDomains->next()) {
            $domains[]                      = $hostedDomains->cId;
            $customers[$hostedDomains->cId]  = $hostedDomains->row();
        }



        // no Domains found; return
        if(!is_array($domains))
        {
            $objTemplate->headline = $GLOBALS['TL_LANG']['Invoice']['noDomains'];
        }
        else
        {
            // get DataSet of Hosting packages
            $hostingContract = Database::getInstance()
                ->execute("SELECT contract.id AS contractId,
                                  contract.customerId,
                                  contract.invoices,
                                  contract.price,
                                  contract.hostStart,
                                  contract.hostEnd,
                                  url.domainName,
                                  url.tld,
                                  url.price AS urlPrice
                                  FROM
                                  tl_invoice_hosting AS contract,
                                  tl_invoice_hosting_url AS url
                                  WHERE
                                  contract.id = url.pid
                                  AND
                                  contract.customerId IN (".implode(',',$domains).")
                                  ");

            // Fill client(customer) list with contract date details.
            while($hostingContract->next())
            {
                if(array_key_exists($hostingContract->customerId,$customers))
                {
                    $customers[$hostingContract->customerId]        = array_merge($customers[$hostingContract->customerId],$hostingContract->row());
                }
            }


            $hostingUrlContract = Database::getInstance()
                ->execute("SELECT host.customerId,
                                  url.pid,
                                  url.domainName,
                                  url.tld,
                                  url.price
                                  FROM
                                  tl_invoice_hosting as host,
                                  tl_invoice_hosting_url as url
                                  WHERE
                                  host.id = url.pid");

            // Fill URL`s to Contract
            while($hostingUrlContract->next())
            {
                if(array_key_exists($hostingUrlContract->customerId,$customers)){
                    $customers[$hostingUrlContract->customerId]['price'] += $hostingUrlContract->price;
                    $customers[$hostingUrlContract->customerId]['url'][]  =
                        array('url'   => $hostingUrlContract->domainName.$hostingUrlContract->tld,
                             'price' => $hostingUrlContract->price);
                }
            }


            // get all invoices for hosting : tl_invoice_hosting is key (serviceTable)
            $invoiceList = Database::getInstance()
                ->prepare("SELECT * FROM tl_invoice_invoices WHERE serviceTable=? AND customerId IN (".implode(',',$domains).")")
                ->execute("tl_invoice_hosting");

            $invoiceListByCustomer = Database::getInstance()
            ->prepare("SELECT count(id) AS counter,customerId FROM tl_invoice_invoices WHERE customerId IN (".implode(',',$domains).") GROUP BY customerId")
            ->execute();
            while($invoiceListByCustomer->next())
            {
                $iListByCustomer[$invoiceListByCustomer->customerId] = $invoiceListByCustomer->counter;
            }



            // no invoices exists
            if($invoiceList->numRows == 0) {
                $objTemplate->headline = $GLOBALS['TL_LANG']['Invoice']['noInvoicesToCreate'];

                foreach($customers as $v)
                {
                    $v['invoCountByCustomer'] = $iListByCustomer[$v['customerId']]+1;
                    self::createHostingInvoiceDocument($v);
                    $newCustomer[] = $v;
                }

            }
            else {

                /**
                 * Create an Array by Customer_ID -> YEAR and InvoiceID
                 */
                while ($invoiceList->next())
                {
                    if(array_key_exists($invoiceList->customerId,$customers)) {
                        $invoiceExists[$invoiceList->customerId][self::getDate($invoiceList->payDay,'Y') ] = $invoiceList->invoiceId;
                        $customers[$invoiceList->customerId]['invoCountByCustomer'] = $iListByCustomer[$invoiceList->customerId]+1;
                    }
                }

                foreach($invoiceExists as $k => $v)
                {
                    // Customer ID in Array and Year (ie. 2017 = this year) does not exists
                    if((array_key_exists($k,$customers)) && !array_key_exists($thisYear,$v))
                    {
                        self::createHostingInvoiceDocument($customers[$k]);
                        $newCustomer[$k] =  $customers[$k];
                    }
                }
            }



            $objTemplate->headline = $GLOBALS['TL_LANG']['invoice']['createHostingInvoices'];
            $objTemplate->domains  = $newCustomer;
        }
        return $objTemplate->parse();
    }


    /**
     * return Formated Date String
     * @param string $timestamp
     * @param string $format    'dmY','Y'
     * @param string $factor (ie. '+1','-32')
     *
     * @return string
     */
    public static function getDate($timestamp, $format = '', $factor = '')
    {
        $f = (empty($format) ? $GLOBALS['TL_CONFIG']['dateFormat'] : $format );

        if(!empty($factor))
            $timestamp = mktime(0, 0, 0,
                ($f === 'm') ? date('m',$timestamp) . $factor : date('m',$timestamp),
                ($f === 'd') ? date('d',$timestamp) . $factor : date('d',$timestamp),
                ($f === 'Y') ? date('Y',$timestamp) . $factor : date('Y',$timestamp));

        return date($f,$timestamp);
    }


    public static function createHostingInvoiceDocument($aData)
    {
        $dataSet        = [
            'tstamp' => time(),
            'payDay'    => $aData['invoicePayDate'],
            'date'      => $aData['invoiceDate'],
            'price'     => $aData['price'],
            'finished'  => 1,
            'totalPrice'=> $aData['price'],
            'customerId'=> $aData['customerId'],
            'invoiceId' => $aData['customerId'].'.'.$aData['invoCountByCustomer'],
            'serviceTable'=> 'tl_invoice_hosting'
        ];
        $arrProcedures  = array();
        $arrValues      = array();


        // Save parent Data
        $intId = Database::getInstance()
            ->prepare("INSERT INTO tl_invoice_invoices %s")
            ->set($dataSet)
            ->execute()
            ->insertId;


        // master Child record for Contract Service
        $arrProcedures[] = '(?,?,?,?,?,?)';
        $arrValues[] = $intId;
        $arrValues[] = time();
        $arrValues[] = 0;
        $arrValues[] = $GLOBALS['TL_LANG']['Invoice']['headline']['hosting'];
        $arrValues[] = $aData['price'];
        $arrValues[] = '';

        // create child record attr in loop
        foreach( $aData['url'] as $v )
        {
            $arrProcedures[] = '(?,?,?,?,?,?)';
            $arrValues[] = $intId;
            $arrValues[] = time();
            $arrValues[] = 0;
            $arrValues[] = $GLOBALS['TL_LANG']['Invoice']['headline']['hosting'];
            $arrValues[] = $v['price'];
            $arrValues[] = $v['url'] . ' - ' . self::getDate($aData['hostStart']) . ' - ' . self::getDate($aData['hostEnd']);
        }

        // save child record
        Database::getInstance()
            ->prepare("INSERT INTO tl_invoice_invoicesElement (pid,tstamp,sorting,headline,price,description)
                       VALUES " . implode(',', $arrProcedures))->execute($arrValues);
    }

    /**
     * Create a Highlight Chart Diagram
     * to set the Amount of the current year and
     * the year before.
    */
    public function amountOverview()
    {
        // RESET CSS
        $GLOBALS['TL_CSS'][]  = 'bundles/cteyeinvoice/css/resetBackend.css';

        if(\Input::get('do')=='InvoiceInvoice'  && \Input::get('key')=='amountOverview')
        {
            // Properties
            $y = date("Y");
            $invCurYear     = \InvoiceInvoicesModel::currentYear($y);
            $invLasYear     = \InvoiceInvoicesModel::currentYear($y-1);
            $strAmCurYear   = [];
            $strAmLasYear   = [];



            while($invCurYear->next()) {
                $strAmCurYear[] = "[Date.UTC(".date("Y",$invCurYear->payDay).",".date("m",$invCurYear->payDay).",".date("d",$invCurYear->payDay)."),".$invCurYear->totalPrice.']';
            }
            while($invLasYear->next()) {
                $strAmLasYear[] = "[Date.UTC(".date("Y",$invLasYear->payDay).",".date("m",$invLasYear->payDay).",".date("d",$invLasYear->payDay)."),".$invLasYear->totalPrice.']';
            }


            $objTemplate                = new BackendTemplate('be_amountOverview');
            $objTemplate->headline      = $GLOBALS['TL_LANG']['Invoice']['amountOverview'];
            $objTemplate->yAxis         = $GLOBALS['TL_LANG']['Invoice']['yAxis'];
            $objTemplate->currentYear   = $y;
            $objTemplate->lastYear      = $y-1;
            $objTemplate->dataLastYear  = implode(",",$strAmLasYear);
            $objTemplate->dataCurrYear  = implode(",",$strAmCurYear);
            $objTemplate->currency      = '$';

            return ($objTemplate->parse());
        }
    }

    /**
     * Return formated Price String
     */
    public static function getPrice($price,$settings)
    {
        return number_format($price,$settings['centValue'],$settings['dec_point'],$settings['thousands_sep']).' '.$settings['currency'];
    }
}