<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Relatedcontent;


class RelatedcontentRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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

    public function create($relatedcontents)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        foreach($relatedcontents as $relatedcontent){
            $newRelatedcontent = new Relatedcontent();
            $newRelatedcontent->setTitle($relatedcontent);
            $this->add($newRelatedcontent);
            $persistenceManager->persistAll();
            return $newRelatedcontent;
        }

    }
}