<?php


namespace Yawave\Yawave\Task;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class UpdateYawaveRecords extends \TYPO3\CMS\Scheduler\Task\AbstractTask
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
        $updateRepository = $objectManager->get(\Yawave\Yawave\Domain\Repository\UpdateRepository::class);
        $conntrollerPublication = $objectManager->get(\Yawave\Yawave\Controller\PublicationsController::class);
        $updates = $updateRepository->findAll();

        if(count($updates) > 0){
            $conntrollerPublication->schedulerUpdatePublication($updates);
        }

        return true;

    }
}