<?php
namespace Yawave\Yawave\Domain\Model;


use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * Portals
 */
class Portals extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * yawavePortalId
     * 
     * @var string
     */
    protected $yawavePortalId = '';

    /**
     * title
     * 
     * @var string
     */
    protected $title = '';

    /**
     * description
     * 
     * @var string
     */
    protected $description = '';

    /**
     * publications
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Publications>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     *
     */
    protected $publications = null;

    /**
     * images
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images>
     */
    protected $images = null;

    /**
     * reletedContent
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Relatedcontent>
     */
    protected $reletedContent = null;

    /**
     * __construct
     */
    public function __construct()
    {

        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     * 
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->publications = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->reletedContent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the yawavePortalId
     * 
     * @return string $yawavePortalId
     */
    public function getYawavePortalId()
    {
        return $this->yawavePortalId;
    }

    /**
     * Sets the yawavePortalId
     * 
     * @param string $yawavePortalId
     * @return void
     */
    public function setYawavePortalId($yawavePortalId)
    {
        $this->yawavePortalId = $yawavePortalId;
    }

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     * 
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     * 
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Publications
     * 
     * @param \Yawave\Yawave\Domain\Model\Publications $publication
     * @return void
     */
    public function addPublication(\Yawave\Yawave\Domain\Model\Publications $publication)
    {
        $this->publications->attach($publication);
    }

    /**
     * Removes a Publications
     * 
     * @param \Yawave\Yawave\Domain\Model\Publications $publicationToRemove The Publications to be removed
     * @return void
     */
    public function removePublication(\Yawave\Yawave\Domain\Model\Publications $publicationToRemove)
    {
        $this->publications->detach($publicationToRemove);
    }

    /**
     * Removes a Publications
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Publications> $publicationsToRemove The Publications to be removed
     * @return void
     */
    public function removePublications(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $publicationsToRemove)
    {
        $this->publications = new ObjectStorage();

    }

    /**
     * Returns the publications
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Publications> $publications
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * Sets the publications
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Publications> $publications
     * @return void
     */
    public function setPublications(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $publications)
    {
        $this->publications = $publications;
    }

    /**
     * Adds a publications
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Publications> $publications
     * @return void
     */
    public function addPublications(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $publications)
    {
        $this->publications->attach($publications);
    }

    /**
     * Adds a Images
     * 
     * @param \Yawave\Yawave\Domain\Model\Images $image
     * @return void
     */
    public function addImage(\Yawave\Yawave\Domain\Model\Images $image)
    {
        $this->images->attach($image);
    }

    /**
     * Removes a Images
     * 
     * @param \Yawave\Yawave\Domain\Model\Images $imageToRemove The Images to be removed
     * @return void
     */
    public function removeImage(\Yawave\Yawave\Domain\Model\Images $imageToRemove)
    {
        $this->images->detach($imageToRemove);
    }

    /**
     * Returns the images
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images> $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Sets the images
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images> $images
     * @return void
     */
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * Adds a Relatedcontent
     *
     * @param \Yawave\Yawave\Domain\Model\Relatedcontent $reletedContent
     * @return void
     */
    public function addReletedContent(\Yawave\Yawave\Domain\Model\Relatedcontent $reletedContent)
    {
        $this->reletedContent->attach($reletedContent);
    }

    /**
     * Removes a Relatedcontent
     *
     * @param \Yawave\Yawave\Domain\Model\Relatedcontent $reletedContentToRemove The Relatedcontent to be removed
     * @return void
     */
    public function removeReletedContent(\Yawave\Yawave\Domain\Model\Relatedcontent $reletedContentToRemove)
    {
        $this->reletedContent->detach($reletedContentToRemove);
    }

    /**
     * Returns the reletedContent
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Relatedcontent> $reletedContent
     */
    public function getReletedContent()
    {
        return $this->reletedContent;
    }

    /**
     * Sets the reletedContent
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Relatedcontent> $reletedContent
     * @return void
     */
    public function setReletedContent(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $reletedContent)
    {
        $this->reletedContent = $reletedContent;
    }
}
