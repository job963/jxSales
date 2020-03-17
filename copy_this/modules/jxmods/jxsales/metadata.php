<?php

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';
 
/**
 * Module information
  * 
 * @link       https://github.com/job963/jxSales
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 * @copyright  (C) Joachim Barthel 2012-2020
 * @version    0.5.5
 * 
*/
$aModule = array(
    'id'           => 'jxsales',
    'title'        => 'jxSales - Sales Search and Analysis',
    'description'  => array(
                        'de' => 'Analyse-Modul für die Ermittlung von Käufern und Produkten.',
                        'en' => 'Analysis module for finding customers by sold products.'
                        ),
    'thumbnail'    => 'jxsales.png',
    'version'      => '0.5.5',
    'author'       => 'Joachim Barthel',
    'url'          => 'https://github.com/job963/jxSales',
    'email'        => 'jobarthel@gmail.com',
    'extend'       => array(
                            'oxlist'           => 'jxmods/jxsales/models/oxlist_jxsales',
                            'oxorderarticle'   => 'jxmods/jxsales/models/oxorderarticle_jxsales'
                        ),
    'files'        => array(
                            'jxsales'        => 'jxmods/jxsales/application/controllers/admin/jxsales.php',
                            'jxsales_latest' => 'jxmods/jxsales/application/controllers/admin/jxsales_latest.php',
                            'user_jxsales'   => 'jxmods/jxsales/application/controllers/admin/user_jxsales.php'
                        ),
    'templates'    => array(
                            'jxsales.tpl'        => 'jxmods/jxsales/application/views/admin/tpl/jxsales.tpl',
                            'jxsales_latest.tpl' => 'jxmods/jxsales/application/views/admin/tpl/jxsales_latest.tpl',
                            'user_jxsales.tpl'   => 'jxmods/jxsales/application/views/admin/tpl/user_jxsales.tpl'
                        ),
    'settings'     => array(
                            array(
                                    'group' => 'JXSALES_DISPLAY', 
                                    'name'  => 'bJxSalesDisplayEAN', 
                                    'type'  => 'bool', 
                                    'value' => 'true'
                                    ),
                            array(
                                    'group' => 'JXSALES_DISPLAY', 
                                    'name'  => 'bJxSalesDisplayAddress', 
                                    'type'  => 'bool', 
                                    'value' => 'true'
                                    ),
                            array(
                                    'group' => 'JXSALES_DISPLAY', 
                                    'name'  => 'bJxSalesDisplayCountry', 
                                    'type'  => 'bool', 
                                    'value' => 'true'
                                    ),
                            array(
                                    'group' => 'JXSALES_DISPLAY', 
                                    'name'  => 'sJxSalesSelectLimit', 
                                    'type'  => 'str', 
                                    'value' => '1000'
                                    ),
                            array(
                                    'group' => 'JXSALES_REPLACE', 
                                    'name'  => 'sJxSalesReplaceMRS', 
                                    'type'  => 'str', 
                                    'value' => 'Liebe Frau'
                                    ),
                            array(
                                    'group' => 'JXSALES_REPLACE', 
                                    'name'  => 'sJxSalesReplaceMR', 
                                    'type'  => 'str', 
                                    'value' => 'Lieber Herr'
                                    ),
                            array(
                                    'group' => 'JXSALES_DOWNLOAD', 
                                    'name'  => 'bJxSalesHeader', 
                                    'type'  => 'bool', 
                                    'value' => 'true'
                                    ),
                            array(
                                    'group' => 'JXSALES_DOWNLOAD', 
                                    'name'  => 'sJxSalesSeparator', 
                                    'type'  => 'select', 
                                    'value' => 'comma',
                                    'constrains' => 'comma|semicolon|tab|pipe|tilde', 
                                    'position' => 0 
                                    ),
                            array(
                                    'group' => 'JXSALES_DOWNLOAD', 
                                    'name'  => 'bJxSalesQuote', 
                                    'type'  => 'bool', 
                                    'value' => 'true'
                                    ),
                            array(
                                    'group' => 'JXSALES_INCLUDESETTINGS', 
                                    'name'  => 'aJxSalesIncludeFiles', 
                                    'type'  => 'arr', 
                                    'value' => array(), 
                                    'position' => 1
                                    ),
                        )
    );

?>
