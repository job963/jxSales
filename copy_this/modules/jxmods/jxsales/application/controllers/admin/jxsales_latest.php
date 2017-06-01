<?php

/*
 *    This file is part of the module jxSales for OXID eShop Community Edition.
 *
 *    The module jxSales for OXID eShop Community Edition is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    The module OxProbs for OXID eShop Community Edition is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      https://github.com/job963/jxSales
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @copyright (C) Joachim Barthel 2012-2017
 *
 */
 
class jxsales_latest extends oxAdminView
{
    /**
     *
     * @var type 
     */
    protected $_sThisTemplate = "jxsales_latest.tpl";

    /**
     * 
     * @return type
     */
    public function render()
    {
        parent::render();

        $this->_aViewData["aOrders"] = $this->_retrieveData();

        $oModule = oxNew('oxModule');
        $oModule->load('jxsales');
        $this->_aViewData["sModuleId"] = $oModule->getId();
        $this->_aViewData["sModuleVersion"] = $oModule->getInfo('version');

        return $this->_sThisTemplate;
    }
    
    
    /**
     * 
     * @return type
     */
    public function downloadResult()
    {
        $myConfig = oxRegistry::get("oxConfig");
        switch ( $myConfig->getConfigParam("sJxSalesSeparator") ) {
            case 'comma':
                $sSep = ',';
                break;
            case 'semicolon':
                $sSep = ';';
                break;
            case 'tab':
                $sSep = chr(9);
                break;
            case 'pipe':
                $sSep = '|';
                break;
            case 'tilde':
                $sSep = '~';
                break;
            default:
                $sSep = ',';
                break;
        }
        if ( $myConfig->getConfigParam( 'bJxSalesQuote' ) ) {
            $sBegin = '"';
            $sSep   = '"' . $sSep . '"';
            $sEnd   = '"';
        }
        
        $sSrcVal = $this->getConfig()->getRequestParameter( 'jxsales_srcval' );
        if (empty($sSrcVal))
            $sSrcVal = "";
        else
            $sSrcVal = strtoupper($sSrcVal);
        
        $aOrders = array();
        $aOrders = $this->_retrieveData($sSrcVal);

        $aOxid = $this->getConfig()->getRequestParameter( 'jxsales_oxid' );
        
        $sContent = '';
        if ( $myConfig->getConfigParam( 'bJxSalesHeader' ) ) {
            $aHeader = array_keys($aOrders[0]);
            $sContent .= $sBegin . implode($sSep, $aHeader) . $sEnd . chr(13);
        }
        foreach ($aOrders as $aOrder) {
            if ( in_array($aOrder['orderartid'], $aOxid) ) {
                $sContent .= $sBegin . implode($sSep, $aOrder) . $sEnd . chr(13);
            }
        }

        header("Content-Type: text/plain");
        header("content-length: ".strlen($sContent));
        header("Content-Disposition: attachment; filename=\"sales-report.csv\"");
        echo $sContent;
        
        exit();

        return;
    }

    
    /**
     * 
     * @return array
     */
    private function _retrieveData()
    {
        $myConfig = oxRegistry::get("oxConfig");
        $replaceMRS = $myConfig->getConfigParam("sJxSalesReplaceMRS");
        $replaceMR = $myConfig->getConfigParam("sJxSalesReplaceMR");

        $sOxvOrderArticles = getViewName( 'oxorderarticles', $this->_iEditLang, $sShopID );
        $sOxvOrder = getViewName( 'oxorder', $this->_iEditLang, $sShopID );
        $sOxvArticles = getViewName( 'oxarticles', $this->_iEditLang, $sShopID );
        $sOxvUser = getViewName( 'oxuser', $this->_iEditLang, $sShopID );
        $sOxvCountry = getViewName( 'oxcountry', $this->_iEditLang, $sShopID );
        $sOxvPayments = getViewName( 'oxpayments', $this->_iEditLang, $sShopID );
        $sOxvOrderFiles = getViewName( 'oxorderfiles', $this->_iEditLang, $sShopID );

        $sWhere = "";
        if ( is_string($this->_aViewData["oViewConf"]->getActiveShopId()) ) { 
            // This is a CE or PE Shop
            $sShopId = "'" . $this->_aViewData["oViewConf"]->getActiveShopId() . "'";
        }
        else {
            // This is a EE Shop
            $sShopId = $this->_aViewData["oViewConf"]->getActiveShopId();
        }
        
        $sSql = "SELECT "
                    . "o.oxid AS oxorderid, o.oxstorno AS oxstorno, o.oxordernr AS oxordernr, u.oxid AS userid, "
                . "DATE(o.oxorderdate) as oxorderdate, o.oxtotalordersum AS oxtotalordersum, o.oxcurrency AS oxcurrency, "
                    . "u.oxusername, u.oxcustnr, o.oxbillsal, REPLACE(REPLACE(o.oxbillsal,'MRS','{$replaceMRS}'),'MR','{$replaceMR}') AS personalsal, o.oxbillfname, o.oxbilllname, "
                    . "o.oxbillstreet, o.oxbillstreetnr, o.oxbillzip, o.oxbillcity, c.oxtitle AS oxcountry, o.oxpaid AS oxpaid, p.oxdesc AS oxpayment "
                . "FROM $sOxvOrder o, $sOxvUser u, $sOxvCountry c, $sOxvPayments p "
                . "WHERE "
                    . "o.oxuserid = u.oxid "
                    . "AND u.oxcountryid = c.oxid "
                    . "AND o.oxpaymenttype = p.oxid "
                    . "AND o.oxshopid = '" . $this->_aViewData["oViewConf"]->getActiveShopId() . "' "
                . "ORDER BY o.oxordernr DESC "
                . "LIMIT 0,50 ";
                    
        $sSql2 = "SELECT "
                    . "oa.oxartid AS oxartid, oa.oxartnum AS oxartnum, oa.oxtitle AS oxtitle, oa.oxselvariant AS oxselvariant, "
                    . "oa.oxamount AS oxamount, oa.oxbprice AS oxbprice, oa.oxbrutprice AS oxbrutprice, "
                    . "f.oxfilename AS oxfilename, f.oxlastdownload AS oxlastdownload, f.oxdownloadcount AS oxdownloadcount, "
                    . "a.oxactive AS oxactive, a.oxean AS oxean "
                . "FROM $sOxvOrderArticles oa "
                . "LEFT JOIN $sOxvOrderFiles f "
                    . "ON (oa.oxid = f.oxorderarticleid) "
                . "LEFT JOIN $sOxvArticles a "
                    . "ON (oa.oxartid = a.oxid) "
                . "WHERE "
                    . "oa.oxorderid = ";
                    
        $aOrders = array();

        $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );
        $rso = $oDb->Execute($sSql);
        $i = 0;
        $aOrder = array();
        while (!$rso->EOF) {
            $aOrder = $rso->fields;
            $sSql = $sSql2 . "'" . $aOrder['oxorderid'] . "'";

            $aDetails = array();
            $rsoa = $oDb->Execute($sSql);
            while (!$rsoa->EOF) {
                array_push($aDetails, $rsoa->fields);
                $rsoa->MoveNext();
            }

            $aOrders[$i] = $aOrder;
            $aOrders[$i]['details'] = $aDetails;
            $rso->MoveNext();
            $i++;
        }
        
        return $aOrders;
    }
 }
?>