<?php

namespace Yawave\Yawave\Task;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class InportYawaveRecords extends \TYPO3\CMS\Scheduler\Task\AbstractTask
{
    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function execute() {
        $objectManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $conntrollerPublication = $objectManager->get(\Yawave\Yawave\Controller\PublicationsController::class);
        $updateRepository = $objectManager->get(\Yawave\Yawave\Domain\Repository\UpdateRepository::class);
        $publicationsRepository = $objectManager->get(\Yawave\Yawave\Domain\Repository\PublicationsRepository::class);
        $metricsRepository = $objectManager->get(\Yawave\Yawave\Domain\Repository\MetricsRepository::class);
        $metrics = $metricsRepository->findAll();
        $updates = $updateRepository->findAll();
        $publications = $publicationsRepository->findAll();
        $yawave = $conntrollerPublication->connectToYawave();
        $applicationId = $yawave['applicationId'];
        $yawaveClient = $yawave['client'];


        if(count($publications) == 0) {
            $conntrollerPublication->yawaveSynch($conntrollerPublication->connectToYawave());
        }

        if(count($metrics) > 0) {
            $conntrollerPublication->yawaveSynchMetrics($yawaveClient,$applicationId);
        }

        if(count($updates) > 0){
            $conntrollerPublication->schedulerUpdatePublication($updates);
        }

        return true;

    }

}
