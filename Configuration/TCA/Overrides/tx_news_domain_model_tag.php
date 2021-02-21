<?php
defined('TYPO3_MODE') || die();


$tmp_yawave_columns = [

    'yawave_tag_id' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_tag.yawave_tag_id',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_tag',
    'yawave_tag_id',
    '',
    'after:title'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_tag',$tmp_yawave_columns);