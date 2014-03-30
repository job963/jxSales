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
 * @copyright (C) Joachim Barthel 2012-2013 
 *
 */
 
class jxsales extends oxAdminView
{
    protected $_sThisTemplate = "jxsales.tpl";

    public function render()
    {
        parent::render();
        $oSmarty = oxUtilsView::getInstance()->getSmarty();
        $oSmarty->assign( "oViewConf", $this->_aViewData["oViewConf"]);
        $oSmarty->assign( "shop", $this->_aViewData["shop"]);

        $sSrcVal = oxConfig::getParameter( "jxsales_srcval" );
        if (empty($sSrcVal))
            $sSrcVal = "";
        else
            $sSrcVal = strtoupper($sSrcVal);
        $oSmarty->assign( "jxsales_srcval", $sSrcVal );

        $aOrders = $this->_retrieveData($sSrcVal);
        $oSmarty->assign("aOrders",$aOrders);

        return $this->_sThisTemplate;
    }
    
    
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
        if ( $myConfig->getConfigParam("bJxSalesQuote") ) {
            $sBegin = '"';
            $sSep   = '"' . $sSep . '"';
            $sEnd   = '"';
        }
        
        $sSrcVal = oxConfig::getParameter( "jxsales_srcval" ); 
        if (empty($sSrcVal))
            $sSrcVal = "";
        else
            $sSrcVal = strtoupper($sSrcVal);
        
        $aOrders = array();
        $aOrders = $this->_retrieveData($sSrcVal);

        $aOxid = oxConfig::getParameter( "jxsales_oxid" ); 
        
        $sContent = '';
        if ( $myConfig->getConfigParam("bJxSalesHeader") ) {
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

    
    private function _retrieveData($sSrcVal)
    {
        $myConfig = oxRegistry::get("oxConfig");
        $replaceMRS = $myConfig->getConfigParam("bJxSalesReplaceMRS");
        $replaceMR = $myConfig->getConfigParam("bJxSalesReplaceMR");
        
        $sSql = "SELECT d.oxid AS orderartid, a.oxid AS artid, o.oxid AS orderid, u.oxid AS userid, a.oxactive, d.oxartnum, d.oxtitle, d.oxselvariant, a.oxean, "
                    . "DATE(o.oxorderdate) as oxorderdate, u.oxusername, u.oxcustnr, o.oxbillsal, REPLACE(REPLACE(o.oxbillsal,'MRS','{$replaceMRS}'),'MR','{$replaceMR}') AS personalsal, o.oxbillfname, o.oxbilllname, "
                    . "o.oxbillstreet, o.oxbillstreetnr, o.oxbillzip, o.oxbillcity, c.oxtitle AS oxcountry "
                . "FROM oxorderarticles d, oxorder o, oxarticles a, oxuser u, oxcountry c "
                . "WHERE (UPPER(d.oxartnum) LIKE '%$sSrcVal%' OR UPPER(d.oxtitle) LIKE '%$sSrcVal%' OR UPPER(d.oxselvariant) LIKE '%$sSrcVal%' OR a.oxean LIKE '%$sSrcVal%') "
                    . "AND d.oxorderid = o.oxid "
                    . "AND d.oxartid = a.oxid "
                    . "AND o.oxuserid = u.oxid "
                    . "AND u.oxcountryid = c.oxid "
                    . "AND o.oxstorno = 0 "
                . "ORDER BY d.oxtitle, o.oxorderdate ";

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