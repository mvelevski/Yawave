<?php
namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Portals;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;

/***
 *
 * This file is part of the "New Api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Milos <info@justraspberry.com>, Just Raspberry
 *
 ***/
/**
 * The repository for Portals
 */
class PortalsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings =
        array(
            'uid' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
        );

    /**
     * @var \Yawave\Yawave\Domain\Repository\PublicationsRepository
     * @Inject
     */
    protected $publicationsRepository = NULL;

    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ImagesRepository
     * @Inject
     */
    protected $imagesRepository = NULL;

    /**
     * RelatedcontentRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\RelatedcontentRepository
     * @Inject
     */
    protected $relatedcontentRepository = NULL;

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


    public function checkPortal($portals){

        $newsPortals = $this->findAll();
        if(count($newsPortals) > 0){
            foreach ($portals as $portal){
                // Checks if Publication from Api exist in the database
                $this->findByYawavePortalId($portal['id']);

                // If it finds an id that is not registered in the database,
                // it places the records in the array and writes them to the database
                if(count($this->findByYawavePortalId($portal['id'])) == 0){
                    $newPortal[] = $portal;
                }
            }

            if($newPortal !== NULL){
                $this->create($newPortal);
            }
        }else{
            $this->create($portals);
        }

    }

    // Related publication by publication Id
    public function findReletedpublication($publicationId){
        $query = $this->createQuery();
        $query->matching(
            $query->equals('publications.uid', $publicationId)
        );

        return $query->execute();
    }

    // Create Portals
    public function create($portals){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        foreach($portals as $portal){
            $newImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $newRelatedContent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $newPortal = new Portals();
            $newPortal->setYawavePortalId($portal['id']);
            $newPortal->setTitle($portal['title']);
            $newPortal->setDescription($portal['description']);

            if($portal['background_image']['path'] !== NULL) {
                $image = [
                    'image_url'=>$portal['background_image']['path'],
                    'focus_x'=>$portal['background_image']['focus']['x'],
                    'focus_y'=>$portal['background_image']['focus']['y'],
                ];
                $createImage = $this->imagesRepository->createImage($image);
                $newImage->attach($createImage);
                $newPortal->setImages($newImage);
            }

            foreach ($portal['related_content_block_types'] as $relatedContentTitle) {
                $relatedContent = $this->relatedcontentRepository->findByTitle($relatedContentTitle)->getFirst();
                if (is_null($relatedContent)) {
                    $createRelatedContent = $this->relatedcontentRepository->create(array($relatedContentTitle));
                    $newRelatedContent->attach($createRelatedContent);
                } else {
                    $newRelatedContent->attach($relatedContent);
                }
            }
            $newPortal->setReletedContent($newRelatedContent);

            // This set sorting from Yawave
            $publicationIds = $portal['publication_ids'];
            if(!empty($publicationIds)) {

                $publications = $this->publicationsRepository->findNews($publicationIds)->toArray();

                usort($publications, function ($a, $b) use ($publicationIds) {
                    $pos_a = array_search($a->getYawavePublicationId(), $publicationIds);
                    $pos_b = array_search($b->getYawavePublicationId(), $publicationIds);
                    return $pos_a - $pos_b;
                });

                /** @var \Yawave\Yawave\Domain\Model\Publications $publication */
                foreach ($publications as $publication) {
                    $newPortal->addPublication($publication);
                }
            }

            $this->add($newPortal);
            $persistenceManager->persistAll();
        }
    }

    // Edit Portals
    public function edit($portalYawave){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $portals = $this->findByYawavePortalId($portalYawave['id']);
        foreach($portals as $portal){
            $newImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $newRelatedContent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $newReorderPublication = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
            $portal->setYawavePortalId($portalYawave['id']);
            $portal->setTitle($portalYawave['title']);
            $portal->setDescription($portalYawave['description']);
            if($portalYawave['background_image']['path'] !== NULL) {
                $image = [
                    'image_url'=>$portalYawave['background_image']['path'],
                    'focus_x'=>$portalYawave['background_image']['focus']['x'],
                    'focus_y'=>$portalYawave['background_image']['focus']['y'],
                ];

                $editImage = $this->imagesRepository->edit($portal->getImages()[0],$image);

                $newImage->attach($editImage);
                $portal->setImages($newImage);
            }
            $publicationIds = $portalYawave['publication_ids'];

            // Remove old Sorting
            $publicationsToRemove = $portal->getPublications();
            $portal->removePublications($publicationsToRemove);

            // Add new sorting
            if(!empty($publicationIds)) {
                $publications = $this->publicationsRepository->findNews($publicationIds)->toArray();

                usort($publications, function ($a, $b) use ($publicationIds) {
                    $pos_a = array_search($a->getYawavePublicationId(), $publicationIds);
                    $pos_b = array_search($b->getYawavePublicationId(), $publicationIds);
                    return $pos_a - $pos_b;
                });

                /** @var \Yawave\Yawave\Domain\Model\Publications $publication */
                foreach ($publications as $publication) {
                    $newReorderPublication->attach($publication);
                }
                $portal->setPublications($newReorderPublication);

            }

            // Update related content types
            foreach ($portalYawave['related_content_block_types'] as $relatedContentYawave){
                $existingRelatedContent = $this->relatedcontentRepository->findByTitle($relatedContentYawave)->getFirst();

                if (is_null($existingRelatedContent)) {
                    $createRelatedContent = $this->relatedcontentRepository->create(array($relatedContentYawave));
                    $newRelatedContent->attach($createRelatedContent);
                } else {
                    $newRelatedContent->attach($existingRelatedContent);
                }

            }

            $portal->setReletedContent($newRelatedContent);
            $this->update($portal);
            $persistenceManager->persistAll();

        }


    }

    // Find Portal By Id
    public function findByPortalId($portalsIds){
        $ids = explode(",",$portalsIds);

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->matching(
            $query->in('uid', $ids)
        );
        return $query->execute();
    }

    // Find Portal By YawaveId
    public function findByPortalYawaveId($portalsYawaveIds){
        $ids = explode(",",$portalsYawaveIds);

        $query = $this->createQuery();
        $query->matching(
            $query->in('yawave_portal_id', $ids)
        );
        return $query->execute();
    }


}
