<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Update;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;

class UpdateRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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


    /**
     * action update
     *
     * @param Update $update
     * @return void
     */
    public function removeUpdate($update){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $this->remove($update);
        $persistenceManager->persistAll();
    }
}