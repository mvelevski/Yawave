<?php
defined('TYPO3_MODE') || die();
$ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';


$tmp_yawave_columns = [

    'type' => [
        'exclude' => false,
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype_formlabel',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                [$ll . 'tx_news_domain_model_news.type.I.0', 0, 'ext-news-type-default'],
                [$ll . 'tx_news_domain_model_news.type.I.1', 1, 'ext-news-type-internal'],
                [$ll . 'tx_news_domain_model_news.type.I.2', 2, 'ext-news-type-external'],
                ['LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.yawave_type', 'Tx_Yawave_Publications', 'ext-news-type-default'],
            ],
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
    'yawave_publication_id' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.yawave_publication_id',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'news_type' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.news_type',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'url' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.url',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'page_height' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.page_height',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],
    'image' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.image',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_yawave_domain_model_images',
            'minitems' => 0,
            'maxitems' => 1,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],

];


$tmp_yawave_cover = [
    'cover' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.cover',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_yawave_domain_model_covers',
            'minitems' => 0,
            'maxitems' => 1,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],
];


$tmp_yawave_metric = [
    'metric' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.metric',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_yawave_domain_model_metrics',
            'minitems' => 0,
            'maxitems' => 1,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],
];


$tmp_yawave_category = [
    'main_category' => [
        'exclude' => true,
        'label' => $ll . 'tx_news_domain_model_news.categories',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectTree',
            'treeConfig' => [
//                    'dataProvider' => \GeorgRinger\News\TreeProvider\DatabaseTreeDataProvider::class,
                'parentField' => 'parent',
                'appearance' => [
                    'showHeader' => true,
                    'expandAll' => true,
                    'maxLevels' => 99,
                ],
            ],
            'MM' => 'sys_category_record_mm',
            'MM_match_fields' => [
                'fieldname' => 'main_category',
                'tablenames' => 'tx_news_domain_model_news',
            ],
            'MM_opposite_field' => 'items',
            'foreign_table' => 'sys_category',
            'foreign_table_where' => ' AND (sys_category.sys_language_uid = 0 OR sys_category.l10n_parent = 0) ORDER BY sys_category.sorting',
            'size' => 10,
            'minitems' => 0,
            'maxitems' => 1,
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
            'readOnly' =>1,
        ]
    ],
];

$tmp_yawave_header = [
    'header' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.header',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_yawave_domain_model_headers',
            'minitems' => 0,
            'maxitems' => 1,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],
];
$tmp_yawave_tool = [
    'tool' => [
        'exclude' => false,
        'label' => 'LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.tool',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_yawave_domain_model_tools',
            'foreign_field' => 'publications',
            'foreign_sortby' => 'sorting',
            'maxitems' => 9999,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'useSortable' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],

    ],
];




\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'yawave_publication_id,news_type,url,page_height,image',
    '',
    'after:title'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'main_category',
    '',
    'after:categories'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    '--div--;LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_cover.tab,cover'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    '--div--;LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_headers.header,header'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    '--div--;LLL:EXT:yawave/Resources/Private/Language/locallang_db.xlf:tx_yawave_domain_model_publications.tool,tool'
);






\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_columns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_category);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_cover);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_metric);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_header);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_yawave_tool);

