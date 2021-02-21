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
 * Covers
 */
class Covers extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

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
     * titleImage
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $titleImage = null;

    /**
     * images
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $images = null;

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
        $this->images = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->titleImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
     * Returns the titleImage
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images> $titleImage
     */
    public function getTitleImage()
    {
        return $this->titleImage;
    }


    /**
     *  Adds a titleImage
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Images> $titleImage
     * @return void
     */
    public function setTitleImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $titleImage)
    {
        $this->titleImage = $titleImage;
    }



    /**
     * Removes a titleImage
     *
     * @param \Yawave\Yawave\Domain\Model\Images $titleImageToRemove The Images to be removed
     * @return void
     */
    public function removeTitleImage(\Yawave\Yawave\Domain\Model\Images $titleImageToRemove)
    {
        $this->titleImage->detach($titleImageToRemove);
    }


    /**
     * Adds a titleImage
     *
     * @param \Yawave\Yawave\Domain\Model\Images $titleImage
     * @return void
     */
    public function addTitleImage(\Yawave\Yawave\Domain\Model\Images $titleImage)
    {
        $this->titleImage->attach($titleImage);
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


}
