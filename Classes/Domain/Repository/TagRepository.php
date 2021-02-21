<?php


namespace Yawave\Yawave\Domain\Repository;

use GeorgRinger\News\Domain\Model\DemandInterface;
use Yawave\Yawave\Domain\Model\Tag;
use GeorgRinger\News\Utility\Validation;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;


class TagRepository extends \GeorgRinger\News\Domain\Repository\TagRepository
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
     * check tags
     *
     * @param array $tags
     */
    public function checkTags($tags){

        // Get all tags from database
        $newsTags = $this->findAll();

        if(count($newsTags) > 0){
            foreach ($tags as $tag){

                // Checks if tags from Api exist in the database
                $this->findByYawaveTagId($tag['id']);

                // If it finds an id that is not registered in the database,
                // it places the records in the array and writes them to the database
                if(count($this->findByYawaveTagId($tag['id'])) == 0){
                    $newTags[] = $tag;
                }
            }

            // Write records in to the database
            if($newTags !== NULL){
                $this->create($newTags);
            }

        }else{
            // If there is no Tag entered in the database
            $this->create($tags);
        }
    }

    // Create Tag by Id
    public function create($tags)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        foreach($tags as $tag){
            $newTag = new Tag();
            $newTag->setTitle($tag['name']);
            $newTag->setSlug($tag['slug']);
            $newTag->setYawaveTagId($tag['id']);
            $this->add($newTag);
            $persistenceManager->persistAll();
        }

    }

    // Find Tag by Id
    public function findTags($ids)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->in('yawave_tag_id', $ids)
        );
        $result = $query->execute();

        return $result;
    }
}