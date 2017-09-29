<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

switch ($this->_sJxSection) {
    case 'head':
        $this->_aJxArticleHead['persparam'] = array('de' => 'Parameter',
                                                    'en' => 'Parameters');
        break;
    
    case 'body':
        $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );

        $sSelect = "SELECT oa.oxpersparam FROM oxorderarticles oa "
                 . "WHERE oa.oxid = " . $oDb->quote($this->oxorderarticles__oxid->value);
        $this->_aJxArticleData['persparam'] = $oDb->getOne($sSelect);
        break;
}

