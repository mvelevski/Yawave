<?php

namespace Yawave\Yawave\Service;

use Yawave\Yawave\Service\YawaveClient;

class YawaveApi
{

    /**
     * @var YawaveClient
     */
    private $api;

    /**
     * Booking constructor.
     * @param YawaveClient $api
     */
    public function __construct(YawaveClient $api)
    {
        $this->api = $api;
    }

    /**
     * @return array|null
     */
    public function applicationId()
    {
        return $this->api->get('public/applications/id');
    }

    /**
     * @return array|null
     */
    public function tags($applicationId,$page = 0)
    {
        $queryParams = [
            'page'=> $page,
            'updated_since'=> ''
        ];
        return $this->api->get('public/applications/'.$applicationId.'/tags',$queryParams) ?? [];
    }

    /**
     * @return array|null
     */
    public function categories($applicationId,$page = 0)
    {
        $queryParams = [
            'page'=> $page,
            'lang'=> 'de'
        ];
        return $this->api->get('public/applications/'.$applicationId.'/categories',$queryParams) ?? [];
    }

    /**
     * @return array|null
     */
    public function publications($applicationId,$page = 0, $updatedSince = '')
    {
        $queryParams = [
            'page'=> $page,
            'lang'=> 'de',
            'updated_since'=>$updatedSince
        ];

        return $this->api->get('public/applications/'.$applicationId.'/publications',$queryParams) ?? [];
    }


    /**
     * @return array|null
     */
    public function publicationsMultilang($applicationId,$page = 0, $updatedSince = '')
    {
        $queryParams = [
            'page'=> $page,
            'updated_since'=>$updatedSince
        ];
        return $this->api->get('public/multilang/applications/'.$applicationId.'/publications',$queryParams) ?? [];
    }


    /**
     * @return array|null
     */
    public function publicationsById($applicationId,$publicationId)
    {
        $queryParams = [
            'publication_id'=> $publicationId,
            'lang'=> 'de'
        ];
        return $this->api->get('public/applications/'.$applicationId.'/publications/'.$publicationId,$queryParams) ?? [];
    }

    /**
     * @return array|null
     */
    public function publicationsMultilangById($applicationId,$publicationId,$updatedSince = '')
    {
        $queryParams = [
            'publication_id'=> $publicationId,
            'updated_since'=>$updatedSince
        ];
        return $this->api->get('public/multilang/applications/'.$applicationId.'/publications/'.$publicationId,$queryParams) ?? [];
    }

    /**
     * @return array|null
     */
    public function metrics($applicationId,$page = 0)
    {
        $queryParams = [
            'application_id'=> $applicationId,
            'page'=> $page
        ];
        return $this->api->get('public/applications/'.$applicationId.'/publications/metrics/',$queryParams) ?? [];
    }

    /**
     * @return array|null
     */
    public function metricsByPublicationId($applicationId,$publicationId)
    {
        $queryParams = [
            'application_id'=> $applicationId
        ];
        return $this->api->get('public/applications/'.$applicationId.'/publications/'.$publicationId.'/metrics/',$queryParams) ?? [];
    }


    /**
     * @return array|null
     */
    public function portals($applicationId,$page = 0)
    {
        $queryParams = [
            'page'=> $page,
            'lang'=> 'de'
        ];
        return $this->api->get('public/applications/'.$applicationId.'/portals',$queryParams) ?? [];
    }


}