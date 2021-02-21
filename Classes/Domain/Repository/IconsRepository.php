<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Icons;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;


/***
 *
 * This file is part of the "Yawave" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Just Raspberry <info@justraspberry.com>, Just Raspberry
 *
 ***/
/**
 * The repository for Icons
 */

class IconsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param array $icon;
     */
    public function create(array $icon){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $newIcon = new Icons();
        if(!empty($icon['source'])){
            $newIcon->setSource($icon['source']);
        }
        if(!empty($icon['name'])){
            $newIcon->setName($icon['name']);
        }
        if(!empty($icon['type'])){
            $newIcon->setType($icon['type']);
        }
        $this->add($newIcon);
        $persistenceManager->persistAll();

        return $newIcon;

    }

    /**
     * action edit
     *
     * @param \Yawave\Yawave\Domain\Model\Icons $icon
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $icon
     * @return void
     */
    public function edit(\Yawave\Yawave\Domain\Model\Icons $icon,$updateIcon){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        if(!empty($updateIcon['source'])){
            $icon->setSource($updateIcon['source']);
        }
        if(!empty($updateIcon['name'])){
            $icon->setName($updateIcon['name']);
        }
        if(!empty($updateIcon['type'])){
            $icon->setType($updateIcon['type']);
        }
        $this->update($icon);
        $persistenceManager->persistAll();

        return $icon;

    }

}