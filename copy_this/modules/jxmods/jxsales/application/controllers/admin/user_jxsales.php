<?php
/*
 *    This file is part of the module jxSales for OXID eShop Community Edition.
 *
 *    The module jxSales for OXID eShop Community Edition is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    The module jxSales for OXID eShop Community Edition is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      https://github.com/job963/jxSales
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @copyright (C) 2012-2017 Joachim Barthel
 * @author    Joachim Barthel <jobarthel@gmail.com>
 * 
 */

class User_jxSales extends oxAdminView
{
    /**
     * 
     * @var string
     */
    protected $_sThisTemplate = "user_jxsales.tpl";
    
    /**
     *
     * @var array 
     */
    protected $_aIncFields = array();

    /**
     * 
     *
     * @return string
     */
    public function render()
    {
        $soxId = $this->getEditObjectId();

        if ( $soxId != "-1" && isset( $soxId)) {
            // load object
            $oUser = oxNew("oxuser");
            $oUser->load($soxId);
            $this->_aViewData["edit"] = $oUser;
            
            $oOrdersList = $oUser->getOrders( 50 );
            
        }
        
        $this->_aViewData["sIsoLang"] = oxRegistry::getLang()->getLanguageAbbr($iLang);
        $this->_aViewData["oOrdersList"] = $oOrdersList;
        
        return $this->_sThisTemplate;
    }

}