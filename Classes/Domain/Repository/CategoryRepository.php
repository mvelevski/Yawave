<?php

namespace Yawave\Yawave\Domain\Repository;


use Doctrine\DBAL\Connection;
use GeorgRinger\News\Domain\Model\DemandInterface;
use GeorgRinger\News\Service\CategoryService;
use Yawave\Yawave\Domain\Model\Category;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;


class CategoryRepository extends \GeorgRinger\News\Domain\Repository\CategoryRepository
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
     * @param array $categories
     */
    public function checkCategories($categories){
        // Get all categories from database
        $newsCategories = $this->findAll();

        if(count($newsCategories) > 0){
            foreach ($categories as $category){

                // Checks if categories from Api exist in the database
                $this->findByYawaveCategoryId($category['id']);

                // If it finds an id that is not registered in the database,
                // it places the records in the array and writes them to the database
                if(count($this->findByYawaveCategoryId($category['id'])) == 0){
                    $newCategories[] = $category;
                }

            }

            // Write records in to the database
            if($newCategories !== NULL){
                $this->create($newCategories);
                $this->setCategories();
            }
        }else{
            $this->create($categories);

            $this->setCategories();
        }

    }


    // Create Categories
    public function create($categories)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        foreach($categories as $category){
            $newCategory = new Category();
            $newCategory->setTitle($category['name']);
            $newCategory->setSlug($category['slug']);
            $newCategory->setYawaveCategoryId($category['id']);
            $newCategory->setYawaveCategoryParentId($category['parent_id']);
            $this->add($newCategory);
            $persistenceManager->persistAll();
        }

    }

    //Set categories to parent category
    public  function setCategories(){
        $categories = $this->subCategory();
        if($categories !== NULL) {
            $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
            foreach ($categories as $key => $category) {
                foreach ($category as $cat) {
                    $cat->setParentcategory($this->findByUid($key));
                    $this->update($cat);
                    $persistenceManager->persistAll();
                }
            }
        }
    }

    // Create sub Category
    public function subCategory(){
        $allCategories = $this->findAll();
        foreach ($allCategories as $category){
            $categoryId = $category->getUid();
            $yawaveCategoryId = $category->getYawaveCategoryId();

            $query = $this->createQuery();
            $query->matching(
                $query->equals('yawave_category_parent_id', $yawaveCategoryId)
            );
            $allResults = $query->execute();

            if(count($allResults) > 0){
                $result[$categoryId] = $allResults;
            }
        }
        return $result;
    }


    // Find Category by Id
    public function findCategories($ids){
        $query = $this->createQuery();
        $query->matching(
            $query->in('yawave_category_id', $ids)
        );
        return $query->execute();
    }
}
