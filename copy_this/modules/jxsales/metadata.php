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
                        'de'=>'Analyse-Modul für die Ermittlung .',
                        'en'=>'Analysis module for finding problematical shop data.'
                        ),
    'thumbnail'    => 'jxsales.png',
    'version'      => '0.2',
    'author'       => 'Joachim Barthel',
    'url'          => 'https://github.com/job963/jxSales',
    'email'        => 'jbarthel@qualifire.de',
    'extend'       => array(
                        ),
    'files'        => array(
        'jxsales' => 'jxsales/application/controllers/admin/jxsales.php'
                        ),
    'templates'    => array(
        'jxsales.tpl' => 'jxsales/views/admin/tpl/jxsales.tpl'
                        ),
    'settings' => array(/*
                        array(
                            'group' => 'OXPROBS_ARTICLESETTINGS', 
                            'name'  => 'sOxProbsEANField', 
                            'type'  => 'select', 
                            'value' => 'oxean',
                            'constrains' => 'oxean|oxdistean', 
                            'position' => 0 
                            ),
                        array(
                            'group' => 'OXPROBS_ARTICLESETTINGS', 
                            'name'  => 'sOxProbsMinDescLen', 
                            'type'  => 'str', 
                            'value' => '15'
                            ),
                        array(
                            'group' => 'OXPROBS_ARTICLESETTINGS', 
                            'name'  => 'sOxProbsBPriceMin',  
                            'type'  => 'str', 
                            'value' => '0.5'
                            ),
                        array(
                            'group' => 'OXPROBS_ARTICLESETTINGS', 
                            'name'  => 'sOxProbsMaxActionTime',  
                            'type'  => 'str', 
                            'value' => '14'
                            ),
                        array(
                            'group' => 'OXPROBS_PICTURESETTINGS', 
                            'name'  => 'sOxProbsPictureDirs',  
                            'type'  => 'select', 
                            'value' => 'master',
                            'constrains' => 'master|generated', 
                            'position' => 0 
                            ),*/
                        )
    );

?>
