<?php
defined('TYPO3_MODE') or die();


$boot = function($_EXTKEY)
{

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Yawave.Yawave',
        'Yawave',
        [
            'Publications' => 'list,update,detail,portals',
            'Update' => 'create,edit,update'
        ],
        // non-cacheable actions
        [
            'Publications' => 'listd,update,detail,portals',
            'Update' => 'create,edit,update'
        ]
    );


    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Yawave.Yawave',
        'YawaveHook',
        [
            'Publications' => 'pushNotification',
            'Update' => 'create,edit,update'
        ],
        // non-cacheable actions
        [
            'Publications' => 'pushNotification',
            'Update' => 'create,edit,update'
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false;

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Yawave\Yawave\Task\InportYawaveRecords::class] = [
        'extension' => $_EXTKEY,
        'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.import_publication.import_title',
        'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.import_publication.import_description'
    ];
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Yawave\Yawave\Task\UpdateYawaveRecords::class] = [
        'extension' => $_EXTKEY,
        'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.import_publication.update_title',
        'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:task.import_publication.update_description'
    ];

};


$boot('yawave');
unset($boot);


$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][GeorgRinger\News\Controller\NewsController::class] = [
    'className' => Yawave\Yawave\Controller\PublicationsController::class
];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools::class]['flexParsing'][] = \Yawave\Yawave\Hooks\BackendUtility::class;
