<?php

namespace Yawave\Yawave\Hooks;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BackendUtility
{


    /**
     * @param array $dataStructure
     * @param array $identifier
     * @return array
     */
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier): array
    {
        if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content' && $identifier['dataStructureKey'] === 'news_pi1,list') {
            $file = Environment::getPublicPath() . '/typo3conf/ext/yawave/Configuration/FlexForms/flexform_news.xml';
            $content = file_get_contents($file);
            if ($content) {
                $dataStructure['sheets']['sDEF'] = \TYPO3\CMS\Core\Utility\GeneralUtility::xml2array($content);
            }
        }
        return $dataStructure;
    }
}
