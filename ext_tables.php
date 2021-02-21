<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('yawave', 'Configuration/TypoScript', 'Yawave Typo3 Extension');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_images', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_images.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_images');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_covers', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_covers.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_covers');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_metrics', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_metrics.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_metrics');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_portals', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_portals.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_portals');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_update', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_update.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_update');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_headers', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_headers.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_headers');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_buttons', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_buttons.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_buttons');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_relatedcontent', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_relatedcontent.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_relatedcontent');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_tools', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_tools.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_tools');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_icons', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_icons.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_icons');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_yawave_domain_model_references', 'EXT:yawave/Resources/Private/Language/locallang_csh_tx_yawave_domain_model_references.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_yawave_domain_model_references');

    },
    $_EXTKEY
);
