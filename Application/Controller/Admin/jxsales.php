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
 * @copyright (C) Joachim Barthel 2012-2018
 * @author    Joachim Barthel <jobarthel@gmail.com>
 *
 */

namespace JxMods\JxConfig\Application\Controller\Admin;

use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\Eshop\Core\TableViewNameGenerator;


class JxSales extends AdminDetailsController
{
    /**
     *
     * @var string 
     */
    //-protected $_sThisTemplate = "jxsales.tpl";

    /**
     * 
     * @return string
     */
    public function render()
    {
        //-parent::render();

        /**
         * @var Request $request 
         */
        $request = Registry::getRequest();

        /**
         * @var Module $module
         */
        $module = oxNew(Module::class);

        //-$sSrcVal = $this->getConfig()->getRequestParameter( 'jxsales_srcval' );
        //-$sSrcBegin = $this->getConfig()->getRequestParameter( 'jxsales_srcbegin' );
        //-$sSrcEnd = $this->getConfig()->getRequestParameter( 'jxsales_srcend' );
        $jxSearchValue = $request->getParameter( 'jxsales_srcval' );
        $jxSearchBegin = $request->getParameter( 'jxsales_srcbegin' );
        $jxSearchEnd = $request->getParameter( 'jxsales_srcend' );
        if (empty($jxSearchValue)) {
            $jxSearchValue = '';
        }
        else {
            $jxSearchValue = strtoupper($jxSearchValue);
        }
        if (empty($jxSearchBegin)) {
            $jxSearchBegin = '0000-00-00';
        }
        if (empty($jxSearchEnd)) {
            $jxSearchEnd = '2999-12-31';
        }
        $this->_aViewData["jxsales_srcval"] = $jxSearchValue;
        if ($jxSearchBegin != '0000-00-00') {
            $this->_aViewData["jxsales_srcbegin"] = $jxSearchBegin;
        }
        if ($jxSearchEnd != '2999-12-31') {
            $this->_aViewData["jxsales_srcend"] = $jxSearchEnd;
        }

        $this->_aViewData["aOrders"] = $this->_getSalesData( $jxSearchValue, $jxSearchBegin, $jxSearchEnd );

        //-$oModule = oxNew('oxModule');
        //-$oModule->load('jxsales');
        //-$this->_aViewData["sModuleId"] = $oModule->getId();
        //-$this->_aViewData["sModuleVersion"] = $oModule->getInfo('version');
        $module->load( 'jxsales' );
        $this->_aViewData['sModuleId'] = $module->getId();
        $this->_aViewData['sModuleVersion'] = $module->getInfo('version');
        
        parent::render();

        //-return $this->_sThisTemplate;
        return "jxsales.tpl";
    }
    
    
    /**
     * 
     * @return type
     */
    public function downloadResult()
    {
        /**
         * @var Request $request 
         */
        $request = Registry::getRequest();
        
        //-$myConfig = oxRegistry::get("oxConfig");
        //-switch ( $myConfig->getConfigParam("sJxSalesSeparator") ) {
        switch ( $this->getConfig()->getConfigParam( 'sJxSalesSeparator' ) ) {
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
        if ( $this->getConfig()->getConfigParam( 'bJxSalesQuote' ) ) {
            $sBegin = '"';
            $sSep   = '"' . $sSep . '"';
            $sEnd   = '"';
        }
        
        $sSrcVal = $request->getRequestParameter( 'jxsales_srcval' );
        if (empty($sSrcVal))
            $sSrcVal = "";
        else
            $sSrcVal = strtoupper($sSrcVal);
        
        $aOrders = array();
        $aOrders = $this->_getSalesData($sSrcVal);

        $aOxid = $request->getRequestParameter( 'jxsales_oxid' );
        
        $sContent = '';
        if ( $this->getConfig()->getConfigParam( 'bJxSalesHeader' ) ) {
            $aHeader = array_keys($aOrders[0]);
            $sContent .= $sBegin . implode($sSep, $aHeader) . $sEnd . chr(13);
        }
        foreach ($aOrders as $aOrder) {
            if ( in_array($aOrder['orderartid'], $aOxid) ) {
                $sContent .= $sBegin . implode($sSep, $aOrder) . $sEnd . chr(13);
            }
        }

        header('Content-Type: text/plain');
        header('content-length: '.strlen($sContent));
        header('Content-Disposition: attachment; filename="sales-report.csv"');
        echo $sContent;
        
        exit();

        return;
    }

    
    /**
     * 
     * @param string $sSrcVal
     * @param date $sSrcBegin
     * @param date $sSrcEnd
     * 
     * @return array
     */
    private function _getSalesData($sSrcVal, $sSrcBegin, $sSrcEnd)
    {
        //-$myConfig = oxRegistry::get("oxConfig");
        $config = Registry::getConfig();
        $replaceMRS = $config->getConfigParam("bJxSalesReplaceMRS");
        $replaceMR = $config->getConfigParam("bJxSalesReplaceMR");

        //-$sOxvOrderArticles = getViewName( 'oxorderarticles', $this->_iEditLang, $sShopID );
        //-$sOxvOrder = getViewName( 'oxorder', $this->_iEditLang, $sShopID );
        //-$sOxvArticles = getViewName( 'oxarticles', $this->_iEditLang, $sShopID );
        //-$sOxvUser = getViewName( 'oxuser', $this->_iEditLang, $sShopID );
        //-$sOxvCountry = getViewName( 'oxcountry', $this->_iEditLang, $sShopID );
        $oxvOrderArticles = TableViewNameGenerator::getViewName( 'oxorderarticles', $this->_iEditLang, $sShopID );
        $sOxvOrder = TableViewNameGenerator::getViewName( 'oxorder', $this->_iEditLang, $sShopID );
        $sOxvArticles = TableViewNameGenerator::getViewName( 'oxarticles', $this->_iEditLang, $sShopID );
        $sOxvUser = TableViewNameGenerator::getViewName( 'oxuser', $this->_iEditLang, $sShopID );
        $sOxvCountry = TableViewNameGenerator::getViewName( 'oxcountry', $this->_iEditLang, $sShopID );

        //$sWhere = "";
        /*if ( is_string($this->_aViewData["oViewConf"]->getActiveShopId()) ) { 
            // This is a CE or PE Shop
            $sShopId = "'" . $this->_aViewData["oViewConf"]->getActiveShopId() . "'";
        }
        else {
            // This is a EE Shop
            $sShopId = $this->_aViewData["oViewConf"]->getActiveShopId();
        }*/
        
        $sSql = "SELECT d.oxid AS orderartid, a.oxid AS artid, o.oxid AS orderid, u.oxid AS userid, a.oxactive AS oxactive, d.oxartnum, d.oxtitle, d.oxselvariant, a.oxean, "
                    . "DATE(o.oxorderdate) as oxorderdate, u.oxusername, u.oxcustnr, o.oxbillsal, REPLACE(REPLACE(o.oxbillsal,'MRS','{$replaceMRS}'),'MR','{$replaceMR}') AS personalsal, o.oxbillfname, o.oxbilllname, "
                    . "o.oxbillstreet, o.oxbillstreetnr, o.oxbillzip, o.oxbillcity, c.oxtitle AS oxcountry "
                . "FROM $sOxvOrderArticles d, $sOxvOrder o, $sOxvArticles a, $sOxvUser u, $sOxvCountry c "
                . "WHERE (UPPER(d.oxartnum) LIKE '%$sSrcVal%' OR UPPER(d.oxtitle) LIKE '%$sSrcVal%' OR UPPER(d.oxselvariant) LIKE '%$sSrcVal%' OR a.oxean LIKE '%$sSrcVal%') "
                    . "AND d.oxorderid = o.oxid "
                    . "AND d.oxartid = a.oxid "
                    . "AND o.oxuserid = u.oxid "
                    . "AND u.oxcountryid = c.oxid "
                    . "AND DATE(o.oxorderdate) >= '$sSrcBegin' AND DATE(o.oxorderdate) <= '$sSrcEnd' "
                    . "AND o.oxstorno = 0 "
                    . "AND a.oxshopid = " . $this->getConfig()->getBaseShopId() . " "
                . "ORDER BY d.oxtitle ASC, o.oxorderdate DESC "
                . "LIMIT 0,100";

        /*$aOrders = array();

        if ($sSrcVal != "") {
            $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );
            $rs = $oDb->Execute($sSql);
            while (!$rs->EOF) {
                array_push($aOrders, $rs->fields);
                $rs->MoveNext();
            }
        }*/
        
        //return $aOrders;
        return $this->_fetchAllRecords($sSql);
    }
     
    
    /**
     * Fetches all records of the given select statement
     * 
     * @param string $query
     * 
     * @return array
     */
    private function _fetchAllRecords(string $query)
    {
        $oDb = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC);
        
        try {
            $resultSet = $oDb->select( $query );
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

        return $resultSet->fetchAll();
    }

    
    
}
