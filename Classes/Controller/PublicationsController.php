<?php
namespace Yawave\Yawave\Controller;


/***
 *
 * This file is part of the "Yawave Typo3 Extension" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 JustRaspberry <info@justraspberry.com>, Just Raspberry
 *
 ***/

use GeorgRinger\News\Domain\Model\News;
use GeorgRinger\News\Seo\NewsTitleProvider;
use Yawave\Yawave\Domain\Model\Update;
use Yawave\Yawave\Domain\Model\Metrics;
use GeorgRinger\News\Utility\Cache;
use GeorgRinger\News\Utility\Page;
use GeorgRinger\News\Utility\TypoScript;
use GeorgRinger\News\Controller\TagController;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Yawave\Yawave\Domain\Repository\PortalRepository;
use Yawave\Yawave\Service\YawaveClient;
use Yawave\Yawave\Service\ErrorMessage;
use Yawave\Yawave\Service\Connection;
use Yawave\Yawave\Service\YawaveApi;
use Yawave\Yawave\Service\YawaveRemapLagnuage;
use TYPO3\CMS\Extbase\Annotation\Inject;

class PublicationsController extends \GeorgRinger\News\Controller\NewsController
{



    /**
     * TagRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\TagRepository
     * @Inject
     */
    protected $tagRepository = NULL;


    /**
     * CategoryRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\CategoryRepository
     * @Inject
     */
    protected $categoryRepository = NULL;

    /**
     * PortalsRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\PortalsRepository
     * @Inject
     */
    protected $portalsRepository = NULL;

    /**
     * MetricsRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\MetricsRepository
     * @Inject
     */
    protected $metricsRepository = NULL;


    /**
     * @var \Yawave\Yawave\Controller\UpdateController
     * @Inject
     */
    protected $updateController;

    /**
     * updateRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\UpdateRepository
     * @Inject
     */
    protected $updateRepository = NULL;


    /**
     * @var \Yawave\Yawave\Domain\Repository\PublicationsRepository
     * @Inject
     */
    protected $newsRepository;


    /**
     * Yawave configuration get from extension configuration in InstallTool
     */
    public function yawaveConfiguration(){

        $settings = [
            'client_id' => $clientId = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['yawave']['yawave']['clientId'],
            'secret' => $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['yawave']['yawave']['secret'],
            'token' => $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['yawave']['yawave']['hooktoken'],
            'domain' => $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['yawave']['yawave']['apiDomain']
        ];
        return $settings;

    }

    /**
     * Yawave connection and get applicationId and client
     */
    public function connectToYawave(){
        $settings = $this->yawaveConfiguration();
        if(!empty($settings['client_id']) and !empty($settings['secret']) and !empty($settings['token']) and !empty($settings['domain'])) {

            $yawave = (new Connection())->apiConnection($settings['client_id'],$settings['secret'],$settings['domain']);
            return $yawave;
        }

        $body = 'The configuration is not set properly. Ceck Client Id and Secret';
        $header = 'Configuration';
        return (new ErrorMessage())->showError($header,$body);



    }


    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchTags(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Tags
        $currentTagsPage = $yawave->tags($applicationId)['page'];
        $tagsPages = $yawave->tags($applicationId)['number_of_all_pages'];
        for ($currentTagsPage; $currentTagsPage <= $tagsPages; $currentTagsPage++){
            $tags = $yawave->tags($applicationId,$currentTagsPage)['content'];
            $this->tagRepository->checkTags($tags);
        }
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchCategories(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Categories
        $currentCategoriesPage = $yawave->categories($applicationId)['page'];
        $categoriesPages = $yawave->categories($applicationId)['number_of_all_pages'];
        for ($currentCategoriesPage; $currentCategoriesPage <= $categoriesPages; $currentCategoriesPage++){
            $categories = $yawave->categories($applicationId,$currentCategoriesPage)['content'];
            $this->categoryRepository->checkCategories($categories);
        }
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchMetrics(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Metrics
        $currentMatricsPage = $yawave->metrics($applicationId)['page'];
        $matricsPages = $yawave->metrics($applicationId)['number_of_all_pages'];
        for ($currentMatricsPage; $currentMatricsPage <= $matricsPages; $currentMatricsPage++){
            $metrics = $yawave->metrics($applicationId,$currentMatricsPage)['content'];
            $this->metricsRepository->checkMetrics($metrics,$currentMatricsPage);
        }
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchPublications(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Publication
        $currentPublicationPage = $yawave->publications($applicationId)['page'];

        $publicationPages = $yawave->publications($applicationId)['number_of_all_pages'];
        for ($currentPublicationPage; $currentPublicationPage <= $publicationPages; $currentPublicationPage++){
            $publications = $yawave->publications($applicationId,$currentPublicationPage)['content'];
            $this->newsRepository->checkPublications($publications,$currentPublicationPage);
        }
    }


    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchPublicationsMultilang(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Publication
        $currentPublicationPage = $yawave->publicationsMultilang($applicationId)['page'];
        $publicationPages = $yawave->publicationsMultilang($applicationId)['number_of_all_pages'];
        for ($currentPublicationPage; $currentPublicationPage <= $publicationPages; $currentPublicationPage++){
            $publications = $yawave->publicationsMultilang($applicationId,$currentPublicationPage)['content'];
            $remapPublication = (new YawaveRemapLagnuage())->sortByLanguage($publications);
            $this->newsRepository->checkPublications($remapPublication,$currentPublicationPage);
        }
    }


    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $publicationId
     * @param string $applicationId
     */
    public function yawaveSynchPublicationsById(\Yawave\Yawave\Service\YawaveApi $yawave, string $publicationId, string $applicationId){
        // Publication by Id
        $publication = $yawave->publicationsById($applicationId,$publicationId);
        return $publication;
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $publicationId
     * @param string $applicationId
     */
    public function yawaveSynchPublicationsMultilangById(\Yawave\Yawave\Service\YawaveApi $yawave, string $publicationId, string $applicationId){
        // Publication by Id
        $publication = $yawave->publicationsMultilangById($applicationId,$publicationId);
        return $publication;
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $publicationId
     * @param string $applicationId
     */
    public function yawaveSynchMetricByPublicationId(\Yawave\Yawave\Service\YawaveApi $yawave, string $publicationId, string $applicationId){
        // Metric By Publication Id
        $metric = $yawave->metricsByPublicationId($applicationId,$publicationId);
        return $metric;
    }


    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawaveSynchPortals(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Portals
        $currentPortalsPage = $yawave->portals($applicationId)['page'];
        $portalsPages = $yawave->portals($applicationId)['page'];
        for ($currentPortalsPage; $currentPortalsPage <= $portalsPages; $currentPortalsPage++){
            $portals = $yawave->portals($applicationId,$currentPortalsPage)['content'];
            $this->portalsRepository->checkPortal($portals);
        }
    }

    /**
     * @param \Yawave\Yawave\Service\YawaveApi $yawave
     * @param string $applicationId
     */
    public function yawavePortals(\Yawave\Yawave\Service\YawaveApi $yawave, string $applicationId){
        // Portals
        $currentPortalsPage = $yawave->portals($applicationId)['page'];
        $portalsPages = $yawave->portals($applicationId)['page'];
        for ($currentPortalsPage; $currentPortalsPage <= $portalsPages; $currentPortalsPage++){
            $portals = $yawave->portals($applicationId,$currentPortalsPage)['content'];
            return $portals;
        }
    }


    /**
     * @param array $yawave
     */
    public function yawaveSynch(array $yawave){


        // Application ID get from Arguments
        $applicationId = $yawave['applicationId'];
        $yawaveClient = $yawave['client'];


        // Synch Tags from Yawave to the Tags model
        $this->yawaveSynchTags($yawaveClient, $applicationId);


        // Synch Categories and set thear parents from Yawave to the sys_category
        $this->yawaveSynchCategories($yawaveClient, $applicationId);

        // Synch Metrics
        $this->yawaveSynchMetrics($yawaveClient,$applicationId);

        // Synch Publications and set thear Categories, nad Tags from Yawave to the News
        $this->yawaveSynchPublicationsMultilang($yawaveClient, $applicationId);

        //$this->yawaveSynchPublications($yawaveClient, $applicationId);

        // Synch Portals and set News to the Portals Model
        $this->yawaveSynchPortals($yawaveClient, $applicationId);

    }




    /**
     * Output a list view of news
     *
     * @param array $overwriteDemand
     */
    public function listAction(array $overwriteDemand = null)
    {
        $this->forwardToDetailActionWhenRequested();
        $domain = $this->yawaveConfiguration();
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);

        if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== null) {
            $demand = $this->overwriteDemandObject($demand, $overwriteDemand);
        }
        $newsRecords = $this->newsRepository->findDemanded($demand);

        $assignedValues = [
            'news' => $newsRecords,
            'overwriteDemand' => $overwriteDemand,
            'demand' => $demand,
            'categories' => null,
            'tags' => null,
            'settings' => $this->settings,
            'apiDomain' => $domain['domain'],
            'siteDomain' => $this->request->getBaseUri(),
            'appId'=> $domain['client_id']
        ];

        if ($demand->getCategories() !== '') {
            $categoriesList = $demand->getCategories();
            if (!is_array($categoriesList)) {
                $categoriesList = GeneralUtility::trimExplode(',', $categoriesList);
            }
            if (!empty($categoriesList)) {
                $assignedValues['categories'] = $this->categoryRepository->findByIdList($categoriesList);
            }
        }

        if ($demand->getTags() !== '') {
            $tagList = $demand->getTags();
            if (!is_array($tagList)) {
                $tagList = GeneralUtility::trimExplode(',', $tagList);
            }
            if (!empty($tagList)) {
                $assignedValues['tags'] = $this->tagRepository->findByIdList($tagList);
            }
        }
        $assignedValues['currentlanguage'] = $GLOBALS['TSFE']->language->getTwoLetterIsoCode();
        $assignedValues = $this->emitActionSignal('NewsController', self::SIGNAL_NEWS_LIST_ACTION, $assignedValues);
        $this->view->assignMultiple($assignedValues);

        Cache::addPageCacheTagsByDemandObject($demand);

    }


    /**
     * Single view of a news record
     *
     * @param \GeorgRinger\News\Domain\Model\News $news news item
     * @param int $currentPage current page for optional pagination
     */
    public function detailAction(\GeorgRinger\News\Domain\Model\News $news = null, $currentPage = 1)
    {
        if ($news === null || $this->settings['isShortcut']) {
            $previewNewsId = ((int)$this->settings['singleNews'] > 0) ? $this->settings['singleNews'] : 0;
            if ($this->request->hasArgument('news_preview')) {
                $previewNewsId = (int)$this->request->getArgument('news_preview');
            }

            if ($previewNewsId > 0) {
                if ($this->isPreviewOfHiddenRecordsEnabled()) {
                    $news = $this->newsRepository->findByUid($previewNewsId, false);
                } else {
                    $news = $this->newsRepository->findByUid($previewNewsId);
                }
            }
        }

        if (is_a($news, News::class) && $this->settings['detail']['checkPidOfNewsRecord']
        ) {
            $news = $this->checkPidOfNewsRecord($news);
        }
        $domain = $this->yawaveConfiguration();
        $demand = $this->createDemandObjectFromSettings($this->settings);
        $demand->setActionAndClass(__METHOD__, __CLASS__);
        $portalsRepository = $this->objectManager->get(\Yawave\Yawave\Domain\Repository\PortalsRepository::class);

        $assignedValues['currentlanguage'] = $GLOBALS['TSFE']->language->getTwoLetterIsoCode();
        $assignedValues = $this->emitActionSignal('NewsController', self::SIGNAL_NEWS_LIST_ACTION, $assignedValues);
        $this->view->assignMultiple($assignedValues);
        $portals = $portalsRepository->findReletedpublication($news->getUid());
        $assignedValues = [
            'newsItem' => $news,
            'currentPage' => (int)$currentPage,
            'demand' => $demand,
            'settings' => $this->settings,
            'portals' => $portals,
            'apiDomain' => $domain['domain'],
            'siteDomain' => $this->request->getBaseUri(),
            'appId'=> $domain['client_id']
        ];

        $assignedValues = $this->emitActionSignal('NewsController', self::SIGNAL_NEWS_DETAIL_ACTION, $assignedValues);
        $news = $assignedValues['newsItem'];
        $this->view->assignMultiple($assignedValues);

        // reset news if type is internal or external
        if ($news && !$this->settings['isShortcut'] && ($news->getType() === '1' || $news->getType() === '2')) {
            $news = null;
        }

        if ($news !== null) {
            Page::setRegisterProperties($this->settings['detail']['registerProperties'], $news);
            Cache::addCacheTagsByNewsRecords([$news]);

            if ($this->settings['detail']['pageTitle']['_typoScriptNodeValue']) {
                $providerConfiguration = $this->settings['detail']['pageTitle'] ?? [];
                $providerClass = $providerConfiguration['provider'] ?? NewsTitleProvider::class;

                /** @var NewsTitleProvider $provider */
                $provider = GeneralUtility::makeInstance($providerClass);
                $provider->setTitleByNews($news, $providerConfiguration);
            }
        } elseif (isset($this->settings['detail']['errorHandling'])) {
            $errorContent = $this->handleNoNewsFoundError($this->settings['detail']['errorHandling']);
            if ($errorContent) {
                return $errorContent;
            }
        }
    }




    public function portalsAction(){
        $portalsIds = $this->settings['portals'];
        $domain = $this->yawaveConfiguration();
        $portalsRepository = $this->objectManager->get(\Yawave\Yawave\Domain\Repository\PortalsRepository::class);
        if($portalsIds !== NULL){
            $publicationsByPortals = $portalsRepository->findByPortalId($portalsIds);
        }
        $settings = $this->yawaveConfiguration();
        $url = parse_url($this->request->getBaseUri());
        $publicUrl = $url['scheme'].'://'.$url['host'];
        $this->view->assign('portals', $publicationsByPortals);
        $this->view->assign('currentlanguage', $GLOBALS['TSFE']->language->getTwoLetterIsoCode());
        $this->view->assign('apiDomain', $domain['domain']);
        $this->view->assign('siteDomain', $publicUrl);
        $this->view->assign('appId', $domain['client_id']);

    }


    public function pushNotificationAction()
    {

        $bodyData = json_decode(file_get_contents('php://input'), true);
        $allheadersData = getallheaders();
        $data = [
            'key'=> $allheadersData['Authorization'],
            'publication_uuid'=>$bodyData['publication_uuid'],
            'status'=>$bodyData['status']
        ];
        $update = New Update();
        $update->setPublicationUuid($data['publication_uuid']);
        $update->setStatus($data['status']);
        $this->updateController->createAction($update);
        $message = [
            "message" => "Successfully add new publication Update "
        ];

        return json_encode($message);

    }

    /**
     *
     *
     * @param object $updates
     *
     */
    public function schedulerUpdatePublication(object $updates){

        foreach($updates as $update){
            $this->yawaveUpdatePublication($this->connectToYawave(),$update->getPublicationUuid(),$update->getStatus());
            $this->updateRepository->removeUpdate($update);
        }


    }

    /**
     * @param string $yawave
     * @param string $status
     * @param array $updatePublicationsIds
     */
    public function yawaveUpdatePublication(array $yawave, string $updatePublicationsId, string $status){


        $yawavePublication = $this->yawaveSynchPublicationsMultilangById($yawave['client'], $updatePublicationsId, $yawave['applicationId']);
        $currentPublicationPage = 0;
        $metric = $this->yawaveSynchMetricByPublicationId($yawave['client'],$updatePublicationsId,$yawave['applicationId']);
        $portalsYawave = $this->yawavePortals($yawave['client'],$yawave['applicationId']);
            $this->metricsRepository->create(array($metric));
            $remapPublication = (new YawaveRemapLagnuage())->sortByLanguage(array($yawavePublication));
            $this->newsRepository->checkPublications($remapPublication,$currentPublicationPage,$status);


        foreach ($portalsYawave as $yawavePortal){
            $portals = $this->portalsRepository->findByPortalYawaveId($yawavePortal['id']);
            if(count($portals)>0){
                $this->portalsRepository->edit($yawavePortal);
            }else{
                $this->portalsRepository->create(array($yawavePortal));
            }
        }





    }

}