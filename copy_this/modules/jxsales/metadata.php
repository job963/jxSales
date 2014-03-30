<?php

/**
 * Metadata version
 */
$sMetadataVersion = '1.0';
 
/**
 * Module information
 */
$aModule = array(
    'id'           => 'jxsales',
    'title'        => 'jxSales - Sales Search and Analysis',
    'description'  => array(
                        'de' => 'Analyse-Modul für die Ermittlung von Produkten und Käufern.',
                        'en' => 'Analysis module for finding customers by sold products.'
                        ),
    'thumbnail'    => 'jxsales.png',
    'version'      => '0.2.2',
    'author'       => 'Joachim Barthel',
    'url'          => 'https://github.com/job963/jxSales',
    'email'        => 'jobarthel@gmail.com',
    'extend'       => array(
                        ),
    'files'        => array(
        'jxsales' => 'jxsales/application/controllers/admin/jxsales.php'
                        ),
    'templates'    => array(
        'jxsales.tpl' => 'jxsales/views/admin/tpl/jxsales.tpl'
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
                        )
    );

?>
