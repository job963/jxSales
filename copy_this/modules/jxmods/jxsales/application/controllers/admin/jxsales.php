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
 * @copyright (C) Joachim Barthel 2012-2019
 * @author    Joachim Barthel <jobarthel@gmail.com>
 *
 */
 
class jxsales extends oxAdminView
{
    /**
     *
     * @var string 
     */
    protected $_sThisTemplate = "jxsales.tpl";

    /**
     * 
     * @return string
     */
    public function render()
    {
        parent::render();

        $sSrcVal = $this->getConfig()->getRequestParameter( 'jxsales_srcval' );
        $sSrcBegin = $this->getConfig()->getRequestParameter( 'jxsales_srcbegin' );
        $sSrcEnd = $this->getConfig()->getRequestParameter( 'jxsales_srcend' );
        if (empty($sSrcVal)) {
            $sSrcVal = '';
        }
        else {
            $sSrcVal = strtoupper($sSrcVal);
        }
        if (empty($sSrcBegin)) {
            $sSrcBegin = '0000-00-00';
        }
        if (empty($sSrcEnd)) {
            $sSrcEnd = '2999-12-31';
        }
        $this->_aViewData["jxsales_srcval"] = $sSrcVal;
        if ($sSrcBegin != '0000-00-00') {
            $this->_aViewData["jxsales_srcbegin"] = $sSrcBegin;
        }
        if ($sSrcEnd != '2999-12-31') {
            $this->_aViewData["jxsales_srcend"] = $sSrcEnd;
        }

        $this->_aViewData["aOrders"] = $this->_retrieveData( $sSrcVal, $sSrcBegin, $sSrcEnd );

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

        $sSrcBegin = $this->getConfig()->getRequestParameter( 'jxsales_srcbegin' );
        if (empty($sSrcBegin)) {
            $sSrcBegin = '0000-00-00';
        }
        
        $sSrcEnd = $this->getConfig()->getRequestParameter( 'jxsales_srcend' );
        if (empty($sSrcEnd)) {
            $sSrcEnd = '2999-12-31';
        }
        
        $aOrders = array();
        $aOrders = $this->_retrieveData( $sSrcVal, $sSrcBegin, $sSrcEnd );

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
     * @param type $sSrcVal
     * @param type $sSrcBegin
     * @param type $sSrcEnd
     * 
     * @return array
     */
    private function _retrieveData($sSrcVal, $sSrcBegin, $sSrcEnd)
    {
        $myConfig = oxRegistry::get("oxConfig");
        $replaceMRS = $myConfig->getConfigParam("bJxSalesReplaceMRS");
        $replaceMR = $myConfig->getConfigParam("bJxSalesReplaceMR");

        $sOxvOrderArticles = getViewName( 'oxorderarticles', $this->_iEditLang, $sShopID );
        $sOxvOrder = getViewName( 'oxorder', $this->_iEditLang, $sShopID );
        $sOxvArticles = getViewName( 'oxarticles', $this->_iEditLang, $sShopID );
        $sOxvUser = getViewName( 'oxuser', $this->_iEditLang, $sShopID );
        $sOxvCountry = getViewName( 'oxcountry', $this->_iEditLang, $sShopID );

        $sWhere = "";
        if ( is_string($this->_aViewData["oViewConf"]->getActiveShopId()) ) { 
            // This is a CE or PE Shop
            $sShopId = "'" . $this->_aViewData["oViewConf"]->getActiveShopId() . "'";
        }
        else {
            // This is a EE Shop
            $sShopId = $this->_aViewData["oViewConf"]->getActiveShopId();
        }
        
        $sSql = "SELECT d.oxid AS orderartid, a.oxid AS artid, o.oxid AS orderid, u.oxid AS userid, a.oxactive AS oxactive, d.oxartnum, d.oxtitle, d.oxselvariant, a.oxean, "
                    . "DATE(o.oxorderdate) as oxorderdate, d.oxamount, u.oxusername, u.oxcustnr, o.oxbillsal, REPLACE(REPLACE(o.oxbillsal,'MRS','{$replaceMRS}'),'MR','{$replaceMR}') AS personalsal, o.oxbillfname, o.oxbilllname, "
                    . "o.oxbillstreet, o.oxbillstreetnr, o.oxbillzip, o.oxbillcity, c.oxtitle AS oxcountry "
                . "FROM $sOxvOrderArticles d, $sOxvOrder o, $sOxvArticles a, $sOxvUser u, $sOxvCountry c "
                . "WHERE (UPPER(d.oxartnum) LIKE '%$sSrcVal%' OR UPPER(d.oxtitle) LIKE '%$sSrcVal%' OR UPPER(d.oxselvariant) LIKE '%$sSrcVal%' OR a.oxean LIKE '%$sSrcVal%') "
                    . "AND d.oxorderid = o.oxid "
                    . "AND d.oxartid = a.oxid "
                    . "AND o.oxuserid = u.oxid "
                    . "AND u.oxcountryid = c.oxid "
                    . "AND DATE(o.oxorderdate) >= '$sSrcBegin' AND DATE(o.oxorderdate) <= '$sSrcEnd' "
                    . "AND o.oxstorno = 0 "
                    . "AND a.oxshopid = $sShopId "
                . "ORDER BY d.oxtitle ASC, o.oxorderdate DESC "
                . "LIMIT 0,250";

        $aOrders = array();

        if ($sSrcVal != "") {
            $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );
            $rs = $oDb->Execute($sSql);
            while (!$rs->EOF) {
                array_push($aOrders, $rs->fields);
                $rs->MoveNext();
            }
        }
        
        return $aOrders;
    }
 }
?>