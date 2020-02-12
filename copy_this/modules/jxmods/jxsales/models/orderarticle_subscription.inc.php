<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

switch ($this->_sJxSection) {
    case 'head':
        $this->_aJxArticleHead['type'] = array('de' => 'Typ',
                                               'en' => 'Type');
        $this->_aJxArticleHead['until'] = array('de' => 'Bis',
                                                'en' => 'Until');
        $this->_aJxArticleHead['users'] = array('de' => 'Benutzer',
                                                'en' => 'Users');
        break;
    
    case 'body':
        $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );
        $oDb->execute('SET SESSION group_concat_max_len = 100000;');

        // get SMX_SERVICETYPEID and SMX_SERVICETYPEDATA
        $sSelect = "SELECT CONCAT('<a href=\"#\" title=\"', REPLACE(REPLACE(REPLACE(REPLACE(s.smx_servicetypedata,'\"',''),'{','{\n'),',',',\n'),'}','\n}') ,'\">',s.smx_servicetypeid, '</a>') AS smx_servicetypeid "
                    . "FROM smx_abo s, oxorderarticles oa "
                    . "WHERE oa.smx_aboid = s.oxid AND s.oxid = " . $oDb->quote($this->oxorderarticles__smx_aboid->value);
        $this->_aJxArticleData['type'] = $oDb->getOne($sSelect);

        // get AP_SUBSCRIPTION_UNTIL
        $sSelect = "SELECT s.ap_subscription_until "
                    . "FROM smx_abo s, oxorderarticles oa "
                    . "WHERE oa.smx_aboid = s.oxid AND s.oxid = " . $oDb->quote($this->oxorderarticles__smx_aboid->value);
        $this->_aJxArticleData['until'] = $oDb->getOne($sSelect);

        // get OXUSERNAME, OXFNAME, OXLNAME and OXCOMPANY
        $sSelect = "SELECT GROUP_CONCAT(CONCAT('<a href=\"#\" title=\"', u.oxfname, ' ',u.oxlname, IF(u.oxcompany != '', CONCAT(', ', u.oxcompany),''), '\">', u.oxusername, '</a>') SEPARATOR '<br>') "
                    . "FROM ap_apps2users au, oxuser u "
                    . "WHERE au.ap_uid = u.oxid AND au.smx_aboid = " . $oDb->quote($this->oxorderarticles__smx_aboid->value) . " "
                    . "GROUP BY au.smx_aboid ";
        $this->_aJxArticleData['users'] = $oDb->getOne($sSelect);

        break;
}
