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
 * @author  Joachim Barthel <jobarthel@gmail.com>
 * 
 */

class oxlist_jxsales extends oxlist_jxsales_parent
{

    /**
     *
     * @var string 
     */
    protected $_sJxSection = 'head';
    
    /**
     *
     * @var string 
     */
    protected $_aJxArticleHead = array();
        
    
    /**
     * 
     * @param type $sKey
     * @return type
     */
    public function jxGetAdditionalArticleHeader($sKey = '')
    {
        $oConfig = oxRegistry::get("oxConfig");
        
        if (count($oConfig->getConfigParam("aJxSalesIncludeFiles")) != 0) {
            $aIncFiles = $oConfig->getConfigParam("aJxSalesIncludeFiles");
            $sIncPath = $this->_jxIncPath('models');
            foreach ($aIncFiles as $sIncFile) { 
                $sIncFile = $sIncPath . $sIncFile . '.inc.php';
                try {
                    require $sIncFile;
                }
                catch (Exception $e) {
                    echo $e->getMessage();
                    die();
                }
            } 
        }
        
        if ($sKey != '') {
            return $this->_aJxArticleHead[$sKey];
        }
        else {
            return $this->_aJxArticleHead;
        }
    }    

    
    /**
     * 
     * @return string
     */
    protected function _jxIncPath($sSubPath)
    {
        $oConfig = oxRegistry::get("oxConfig");
        $sIncPath = $oConfig->getConfigParam("sShopDir") . 'modules/jxmods/jxsales';
        
        if ($sSubPath != '') {
            $sIncPath = $sIncPath . '/' . $sSubPath . '/';
        }
        
        return $sIncPath;
    }
}
