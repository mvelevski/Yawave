<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Metrics;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

class MetricsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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
     * check metrics
     *
     * @param array $metrics
     */
    public function checkMetrics($metrics){

        // Get all Metrics from database
        $newsMetrics = $this->findAll();

        if(count($newsMetrics) > 0){
            foreach ($metrics as $metric){

                // If it finds an id that is not registered in the database,
                // it places the records in the array and writes them to the database
                if(count($this->findByYawavePublicationId($metric['id'])) == 0){
                    $newMetrics[] = $metric;
                }

                if(count($this->findByYawavePublicationId($metric['id'])) > 0){
                    $updateMetrics = $metric;
                    $currentMetrics = $this->findByYawavePublicationId($metric['id']);

                    $this->updateMetrics($updateMetrics,$currentMetrics[0]);
                }

            }

            // Write records in to the database
            if($newMetrics !== NULL){
                $this->create($newMetrics);
            }

        }else{
            // If there is no Tag entered in the database
            $this->create($metrics);
        }
    }



    /**
     * @param array $metrics;
     */
    public function create(array $metrics)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        foreach ($metrics as $metric) {

            $newMetric = new Metrics();
            $newMetric->setYawavePublicationId($metric['id']);
            $newMetric->setEngagements($metric['engagements']);
            $newMetric->setRecipients($metric['recipients']);
            $newMetric->setViews($metric['views']);
            $this->add($newMetric);
            $persistenceManager->persistAll();
        }


    }

    /**
     * @param array $newsMetrics;
     * @param \Yawave\Yawave\Domain\Model\Metrics $metrics;
     */
    public function updateMetrics(array $newsMetrics, \Yawave\Yawave\Domain\Model\Metrics $metrics){
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        if($newsMetrics['views'] !== $metrics->getViews()){
            $metrics->setViews($newsMetrics['views']);
        }

        if($newsMetrics['recipients'] !== $metrics->getRecipients()){
            $metrics->setRecipients($newsMetrics['recipients']);
        }

        if($newsMetrics['engagements'] !== $metrics->getEngagements()){
            $metrics->setEngagements($newsMetrics['engagements']);
        }

        $this->update($metrics);
        $persistenceManager->persistAll();

    }

}