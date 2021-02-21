<?php
defined('TYPO3_MODE') || die();


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'sys_category',
    'yawave_category_id, yawave_category_parent_id',
    '',
    'after:title'
);


$tmp_yawave_columns = [

    'yawave_category_id' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_category.yawave_category_id',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'yawave_category_parent_id' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_category.yawave_category_parent_id',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category',$tmp_yawave_columns);

