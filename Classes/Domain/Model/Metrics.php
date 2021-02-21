<?php
namespace Yawave\Yawave\Domain\Model;


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
 * Metrics
 */
class Metrics extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * yawavePublicationId
     * 
     * @var string
     */
    protected $yawavePublicationId = '';

    /**
     * views
     * 
     * @var string
     */
    protected $views = '';

    /**
     * recipients
     * 
     * @var string
     */
    protected $recipients = '';

    /**
     * engagements
     * 
     * @var string
     */
    protected $engagements = '';

    /**
     * Returns the yawavePublicationId
     * 
     * @return string $yawavePublicationId
     */
    public function getYawavePublicationId()
    {
        return $this->yawavePublicationId;
    }

    /**
     * Sets the yawavePublicationId
     * 
     * @param string $yawavePublicationId
     * @return void
     */
    public function setYawavePublicationId($yawavePublicationId)
    {
        $this->yawavePublicationId = $yawavePublicationId;
    }

    /**
     * Returns the views
     * 
     * @return string $views
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Sets the views
     * 
     * @param string $views
     * @return void
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * Returns the recipients
     * 
     * @return string $recipients
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Sets the recipients
     * 
     * @param string $recipients
     * @return void
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    /**
     * Returns the engagements
     * 
     * @return string $engagements
     */
    public function getEngagements()
    {
        return $this->engagements;
    }

    /**
     * Sets the engagements
     * 
     * @param string $engagements
     * @return void
     */
    public function setEngagements($engagements)
    {
        $this->engagements = $engagements;
    }
}
