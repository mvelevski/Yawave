<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Tools;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;


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
 * The repository for Tools
 */

class ToolsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\IconsRepository
     * @Inject
     */
    protected $iconsRepository = NULL;

    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ReferencesRepository
     * @Inject
     */
    protected $referencesRepository = NULL;


    /**
     * @param array $tools;
     */
    public function create(array $tools){

        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        foreach ($tools as $tool) {

            $newTool = new Tools();
            $newTool->setYawaveToolsId($tool['id']);
            $newTool->setToolType($tool['type']);
            $newTool->setToolLabel($tool['label']);

            if(!empty($tool['icon'])) {
                $newIcons = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $createIcons = $this->iconsRepository->create($tool['icon']);
                $newIcons->attach($createIcons);
                $newTool->setIcon($newIcons);
            }

            if(!empty($tool['reference'])){

                $newReference = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $createReference = $this->referencesRepository->create($tool['reference']);
                $newReference->attach($createReference);
                $newTool->setReference($newReference);
            }

            $this->add($newTool);
            $newTools[] = $newTool;
        }
        $persistenceManager->persistAll();
        return $newTools;

    }

    /**
     * @param \Yawave\Yawave\Domain\Model\Tools $tool
     * @param array $updateTool;
     */
    public function edit(\Yawave\Yawave\Domain\Model\Tools $tool, array $updateTool){

        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        if(!empty($updateTool['id'])) {
            $tool->setYawaveToolsId($updateTool['id']);
        }
        $tool->setToolType($updateTool['type']);
        $tool->setToolLabel($updateTool['label']);
        if(!empty($updateTool['icon'])) {
            $newIcons = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $editIcon = $this->iconsRepository->edit($tool->getIcon()[0],$updateTool['icon']);
            $newIcons->attach($editIcon);
            $tool->setIcon($newIcons);
        }

        if(!empty($updateTool['reference'])){
            $newReference = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $editReference = $this->referencesRepository->edit($tool->getReference()[0],$updateTool['reference']);
            $newReference->attach($editReference);
            $tool->setReference($newReference);
        }
        $this->update($tool);
        $persistenceManager->persistAll();
        return $tool;

    }


    public function findByYawaveToolsIdAndPublicationId($publicationId,$yawaveToolsId=''){
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('publications', $publicationId),
                    $query->equals('yawave_tools_id', $yawaveToolsId),
                ]
            )
        );
        return $query->execute()->getFirst();
    }

    public function findByYawaveToolsIdNullAndPublicationId($publicationId){
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('publications', $publicationId),
                    $query->equals('tool_type', 'LINK'),
                ]
            )
        );
        return $query->execute()->getFirst();
    }
}