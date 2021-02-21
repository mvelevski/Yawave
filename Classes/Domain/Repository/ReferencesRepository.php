<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\References;
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
 * The repository for References
 */

class ReferencesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param array $reference;
     */
    public function create(array $reference){
        $newReference = new References();

        if(!empty($reference['link_url'])) {
            $newReference->setLinkUrl($reference['link_url']);
        }

        $this->add($newReference);
        return $newReference;

    }

    /**
     * action edit
     *
     * @param \Yawave\Yawave\Domain\Model\References $reference
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $reference
     * @return void
     */
    public function edit(\Yawave\Yawave\Domain\Model\References $reference, $updatereRerence){
        if(!empty($updatereRerence['link_url'])) {
            $reference->setLinkUrl($updatereRerence['link_url']);
        }
        $this->update($reference);
        return $reference;

    }
}