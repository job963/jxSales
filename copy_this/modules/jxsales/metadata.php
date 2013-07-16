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
    'version'      => '0.2',
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
    'settings' => array(
                        )
    );

?>
