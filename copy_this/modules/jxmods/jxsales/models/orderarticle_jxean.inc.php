<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->aJxArticleHead['hello'] = 'Welcome';

//$this->oxorderarticles__oxartid->value
//$this->oxorderarticles__smx_aboid->value
$oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );

$sSelect = "SELECT oa.jxean FROM oxorderarticles oa "
         . "WHERE oa.oxid = " . $oDb->quote($this->oxorderarticles__oxid->value);
$this->aJxArticleData['jxean'] = $oDb->getOne($sSelect);

//$this->aJxArticleData['hello'] = 'Hello World!';
