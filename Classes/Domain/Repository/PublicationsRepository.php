<?php
namespace Yawave\Yawave\Domain\Repository;


/***
 *
 * This file is part of the "Yawave Typo3 Extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 JustRaspberry <info@justraspberry.com>, JustRaspberry
 *
 ***/
/**
 * The repository for Publications
 */

use Yawave\Yawave\Domain\Model\Publications as News;
use Yawave\Yawave\Domain\Model\Headers as Header;
use GeorgRinger\News\Domain\Model\DemandInterface;
use GeorgRinger\News\Domain\Model\Dto\NewsDemand;
use GeorgRinger\News\Service\CategoryService;
use GeorgRinger\News\Utility\ConstraintHelper;
use GeorgRinger\News\Utility\Validation;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use GeorgRinger\News\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Annotation\Inject;
use TYPO3\CMS\Core\Http\Uri;


class PublicationsRepository extends \GeorgRinger\News\Domain\Repository\NewsRepository
{

    /**
     * TagRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\TagRepository
     * @Inject
     */
    protected $tagRepository = NULL;

    /**
     * ToolsRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ToolsRepository
     * @Inject
     */
    protected $toolsRepository = NULL;

    /**
     * CoversRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\CoversRepository
     * @Inject
     */
    protected $coversRepository = NULL;

    /**
     * CategoryRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\CategoryRepository
     * @Inject
     */
    protected $categoryRepository = NULL;

    /**
     * MetricsRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\MetricsRepository
     * @Inject
     */
    protected $metricsRepository = NULL;

    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ImagesRepository
     * @Inject
     */
    protected $imagesRepository = NULL;

    /**
     * HeadersRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\HeadersRepository
     * @Inject
     */
    protected $headersRepository = NULL;


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
     * @var array
     */
    protected $defaultOrderings = ['sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING];



    public function checkPublications($publicationsPerLanguage,$currentPublicationPage=0,$status=''){

        foreach ($publicationsPerLanguage as $key => $publications){
            $this->checkLanguge($key,$publications,$status);
        }

    }


    public function checkLanguge($publicationsLanguage,$yawavePublications,$status=''){
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $extbaseFrameworkConfiguration = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $configuratedlanguages = $extbaseFrameworkConfiguration['plugin.']['tx_news.']['settings.']['language.'];
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        foreach ($configuratedlanguages as $key => $languageId) {

            if($key == $publicationsLanguage) {

                $existedPublication = $this->findPublicationByLanguage($yawavePublications[0]['id'],$languageId);
                if(!empty($existedPublication)){
                    if($status == 'PUBLISHED') {
                        $this->editPublication($existedPublication, $yawavePublications, $status);
                    }
                    if($status == 'DELETED') {
                        $this->removePublication($existedPublication);
                    }
                    if($status == 'PAUSED') {
                        $this->hidePublication($existedPublication);
                    }
                }else{
                    $this->createPublications($yawavePublications,$languageId);
                }
                $persistenceManager->persistAll();
            }
        }
    }

    public function editPublication($editedPublication,$yawaveUpdatedPublications,$status){

        foreach($yawaveUpdatedPublications as $yawaveUpdatedPublication){

            $editedPublication->setNewsType($yawaveUpdatedPublication['type']);

            // Edit Cover
            $coverId = $this->coversRepository->edit($editedPublication->getCover(),$yawaveUpdatedPublication['cover']);

            // Set Cover
            $editedPublication->setCover($coverId);
            if($status == 'PUBLISHED') {
                $editedPublication->setHidden(0);
            }

            if(!empty($yawaveUpdatedPublication['tools'])) {
                $setTools = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

                foreach ($yawaveUpdatedPublication['tools'] as $updateTool){
                    $editTool = $this->toolsRepository->findByYawaveToolsIdAndPublicationId($editedPublication->getUid(),$updateTool['id']);
                    if(!is_null($editTool)){
                        $editedTools = $this->toolsRepository->edit($editTool,$updateTool);
                    }else{
                        $editTool = $this->toolsRepository->findByYawaveToolsIdNullAndPublicationId($editedPublication->getUid());
                        $editedTools = $this->toolsRepository->edit($editTool,$updateTool);
                    }

                    $setTools->attach($editedTools);
                }
                $editedPublication->setTool($setTools);

            }

            if(!empty($yawaveUpdatedPublication['content']['title'])) {
                $pathSegment =  str_replace(" ","-",$yawaveUpdatedPublication['content']['title']);
                $editedPublication->setPathSegment($pathSegment);
            }


            // Set Content in HTML format
            if($yawaveUpdatedPublication['type'] == 'EMBED_PAGE'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['html']);
                $editedPublication->setTitle($yawaveUpdatedPublication['content']['title']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
                $editedPublication->setUrl($yawaveUpdatedPublication['content']['url']);
                $editedPublication->setPageHeight($yawaveUpdatedPublication['content']['page_height']);
            }
            if($yawaveUpdatedPublication['type'] == 'EMBED_CODE'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['embed_code']);
                $editedPublication->setTitle($yawaveUpdatedPublication['content']['title']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
            }
            if($yawaveUpdatedPublication['type'] == 'NEWSLETTER'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['html_tailored']);
            }

            if($yawaveUpdatedPublication['type'] == 'VIDEO'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['embed_code']);
                $editedPublication->setTitle($yawaveUpdatedPublication['content']['title']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
                $editedPublication->setUrl($yawaveUpdatedPublication['content']['url']);
            }

            if($yawaveUpdatedPublication['type'] == 'LINK'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['embed_code']);
                $editedPublication->setTitle($yawaveUpdatedPublication['content']['title']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
                $editedPublication->setUrl($yawaveUpdatedPublication['content']['url']);
            }
            if($yawaveUpdatedPublication['type'] == 'LANDING_PAGE'){
                $editedPublication->setBodytext($yawaveUpdatedPublication['content']['html_tailored']);
            }
            if($yawaveUpdatedPublication['type'] == 'PHOTO'){
                $editedPublication->setTitle($yawaveUpdatedPublication['content']['title']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
            }
            if($yawaveUpdatedPublication['type'] == 'PDF'){
                $editedPublication->setUrl($yawaveUpdatedPublication['content']['url']);
                $editedPublication->setTeaser($yawaveUpdatedPublication['content']['description']);
            }

            if(!empty($yawaveUpdatedPublication['category_ids'])){

                // Add All categories for news
                $newCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $categories = $this->categoryRepository->findCategories($yawaveUpdatedPublication['category_ids']);
                foreach ($categories as $category){
                    $newCategories->attach($category);
                }
                $editedPublication->setCategories($newCategories);

            }

            if(!empty($yawaveUpdatedPublication['main_category_id'])){
                // Add Main category for news
                $newMainCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $mainCategories = $this->categoryRepository->findByYawaveCategoryId($yawaveUpdatedPublication['main_category_id']);

                foreach ($mainCategories as $mainCategory){
                    $newMainCategories->attach($mainCategory);
                }

                $editedPublication->setMainCategory($newMainCategories);

            }

            if(!empty($yawaveUpdatedPublication['tag_ids'])) {
                // Find Tags and set it to Publication
                $newTags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $tags = $this->tagRepository->findTags($yawaveUpdatedPublication['tag_ids']);
                foreach ($tags as $tag) {
                    $newTags->attach($tag);
                }
                $editedPublication->setTags($newTags);
            }

            // Find Metrics and set it to Publication
            $metrics = $this->metricsRepository->findByYawavePublicationId($yawaveUpdatedPublication['id']);
            if(count($metrics)>0){
                foreach ($metrics as $metric) {
                    $editedPublication->setMetric($metric);
                }
            }

            //Set Header

            if(!empty($yawaveUpdatedPublication['header'])) {
                $newHeader = $this->headersRepository->editHeader($editedPublication->getHeader(),$yawaveUpdatedPublication['header']);
                $editedPublication->setHeader($newHeader);
            }

            //Set Content image
            if($yawaveUpdatedPublication['content']['image'] !== NULL) {

                $image = [
                    'image_url'=>$yawaveUpdatedPublication['content']['image']['path'],
                    'focus_x'=>$yawaveUpdatedPublication['content']['image']['focus']['x'],
                    'focus_y'=>$yawaveUpdatedPublication['content']['image']['focus']['y']
                ];

                $editImage = $this->imagesRepository->edit($editedPublication->getImage(),$image);
                $editedPublication->setImage($editImage);

            }
            $this->update($editedPublication);
        }

    }


    public function createPublications($publications,$languageId)
    {
        foreach($publications as $publication){
            $newPublication = new News();

            // Set Language ID
            $newPublication->setSysLanguageUid($languageId);

            if(intval($languageId) !== 0){
                $parentPublication = $this->findParentNews($publication['id']);
                if($parentPublication->count() > 0) {
                    $newPublication->setL10nParent($parentPublication[0]->getUid());
                }
            }

            $newPublication->setYawavePublicationId($publication['id']);
            $newPublication->setNewsType($publication['type']);

            // Set Create Date
            $createDate = new \DateTime($publication['creation_date']);
            $newPublication->setCrdate($createDate->getTimestamp());

            // Create Cover
            $coverId = $this->coversRepository->create($publication['cover']);

            // Set Cover
            $newPublication->setCover($coverId);

            // Set Create Date
            $crdate = new \DateTime($publication['creation_date']);
            $newPublication->setDatetime($crdate);

            //Set start time
            $starttime = new \DateTime($publication['begin_date']);
            $newPublication->setStarttime($starttime);

            if(!empty($publication['tools'])) {
                $setTools = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $newTools = $this->toolsRepository->create($publication['tools']);

                foreach($newTools as $newTool){
                    $setTools->attach($newTool);
                }
                $newPublication->setTool($setTools);
            }

            if(!empty($publication['content']['title'])) {
                $pathSegment =  str_replace(" ","-",$publication['content']['title']);
                $newPublication->setPathSegment($pathSegment);
            }

            // Set Content in HTML format
            if($publication['type'] == 'ARTICLE'){
                $newPublication->setBodytext($publication['content']['html_tailored']);
                $newPublication->setTitle($publication['header']['title']);
                $newPublication->setTeaser($publication['header']['description']);
            }
            // Set Content in HTML format
            if($publication['type'] == 'EMBED_PAGE'){
                $newPublication->setBodytext($publication['content']['html']);
                $newPublication->setTitle($publication['content']['title']);
                $newPublication->setTeaser($publication['content']['description']);
                $newPublication->setUrl($publication['content']['url']);
                $newPublication->setPageHeight($publication['content']['page_height']);
            }
            if($publication['type'] == 'EMBED_CODE'){
                $newPublication->setBodytext($publication['content']['embed_code']);
                $newPublication->setTitle($publication['content']['title']);
                $newPublication->setTeaser($publication['content']['description']);
            }
            if($publication['type'] == 'NEWSLETTER'){
                $newPublication->setBodytext($publication['content']['html_tailored']);
            }
            if($publication['type'] == 'VIDEO'){
                $newPublication->setBodytext($publication['content']['embed_code']);
                $newPublication->setTitle($publication['content']['title']);
                $newPublication->setTeaser($publication['content']['description']);
                $newPublication->setUrl($publication['content']['url']);
            }
            if($publication['type'] == 'LINK'){
                $newPublication->setBodytext($publication['content']['embed_code']);
                $newPublication->setTitle($publication['content']['title']);
                $newPublication->setTeaser($publication['content']['description']);
                $newPublication->setUrl($publication['content']['url']);
            }
            if($publication['type'] == 'LANDING_PAGE'){
                $newPublication->setBodytext($publication['content']['html_tailored']);
            }
            if($publication['type'] == 'PHOTO'){
                $newPublication->setTitle($publication['content']['title']);
                $newPublication->setTeaser($publication['content']['description']);
            }
            if($publication['type'] == 'PDF'){
                $newPublication->setUrl($publication['content']['url']);
                $newPublication->setTeaser($publication['content']['description']);
            }

            if(!empty($publication['category_ids'])){

                // Add All categories for news
                $newCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $categories = $this->categoryRepository->findCategories($publication['category_ids']);
                foreach ($categories as $category){
                    $newCategories->attach($category);
                }
                $newPublication->setCategories($newCategories);

            }

            if(!empty($publication['main_category_id'])){

                // Add Main category for news
                $newMainCategories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $mainCategories = $this->categoryRepository->findByYawaveCategoryId($publication['main_category_id']);

                foreach ($mainCategories as $mainCategory){
                    $newMainCategories->attach($mainCategory);
                }

                $newPublication->setMainCategory($newMainCategories);
            }

            if(!empty($publication['tag_ids'])) {
                // Find Tags and set it to Publication
                $newTags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
                $tags = $this->tagRepository->findTags($publication['tag_ids']);
                foreach ($tags as $tag) {
                    $newTags->attach($tag);
                }
                $newPublication->setTags($newTags);
            }

            // Find Metrics and set it to Publication
            $metrics = $this->metricsRepository->findByYawavePublicationId($publication['id']);
            if(count($metrics)>0){
                foreach ($metrics as $metric) {
                    $newPublication->setMetric($metric);
                }
            }

            //Set Header
            if(!empty($publication['header'])) {
                $newHeader = $this->headersRepository->createHeader($publication['header']);
                $newPublication->setHeader($newHeader);
            }


            //Set Content image
            if($publication['content']['image'] !== NULL) {

                $image = [
                    'image_url'=>$publication['content']['image']['path'],
                    'focus_x'=>$publication['content']['image']['focus']['x'],
                    'focus_y'=>$publication['content']['image']['focus']['y']
                ];
                $newImage = $this->imagesRepository->createImage($image);
                $newPublication->setImage($newImage);
            }

            $this->add($newPublication);

        }


    }

    //Find Default Language Publication
    public function findParentNews($publicationId){

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('yawave_publication_id', $publicationId),
                    $query->equals('sys_language_uid', 0),
                ]
            )
        );

        return $query->execute();

    }



    /**
     * action update
     *
     * @param News $Publication
     * @return void
     */
    public function updatePublication(News $Publication)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $this->update($Publication);
        $persistenceManager->persistAll();
    }

    /**
     * action update
     *
     * @param News $news
     * @return void
     */
    public function removePublication(News $news){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $this->remove($news);
        $persistenceManager->persistAll();
    }

    /**
     * action hide
     *
     * @param News $news
     * @return void
     */
    public function hidePublication(News $news){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $news->setHidden(1);
        $this->update($news);
        $persistenceManager->persistAll();
    }

    //Find Publication bi Id-s
    public function findNews($ids){

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching(
            $query->in('yawave_publication_id', $ids)
        );
        return $query->execute();
    }

    //Find publication by language
    public function findPublicationByLanguage($yawaveId,$languageId){

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);
        $query->getQuerySettings()->setIgnoreEnableFields(true);
        $query->matching(
            $query->logicalAnd(
                [
                    $query->equals('yawave_publication_id', $yawaveId),
                    $query->equals('sys_language_uid', $languageId),
                    $query->equals('deleted', 0),
                ]
            )
        );

        return $query->execute()->getFirst();
    }



}
