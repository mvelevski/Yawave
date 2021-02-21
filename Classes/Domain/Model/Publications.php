<?php
namespace Yawave\Yawave\Domain\Model;

use GeorgRinger\News\Domain\Model\Dto\NewsDemand;

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
 * Publications
 */
class Publications extends \GeorgRinger\News\Domain\Model\News
{

    /**
     * yawavePublicationId
     * 
     * @var string
     */
    protected $yawavePublicationId = '';

    /**
     * newsType
     * 
     * @var string
     */
    protected $newsType = '';

    /**
     * url
     *
     * @var string
     */
    protected $url = '';

    /**
     * pageHeight
     *
     * @var string
     */
    protected $pageHeight = '';

    /**
     * header
     *
     * @var \Yawave\Yawave\Domain\Model\Headers
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $header = null;



    /**
     * cover
     * 
     * @var \Yawave\Yawave\Domain\Model\Covers
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $cover = null;

    /**
     * metric
     * 
     * @var \Yawave\Yawave\Domain\Model\Metrics
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $metric = null;

    /**
     * image
     * 
     * @var \Yawave\Yawave\Domain\Model\Images
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Category>
     *
     */
    protected $mainCategory = null;

    /**
     * tool
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Tools>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $tool = null;


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
        $this->mainCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->tool = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

    }



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
     * Returns the url
     * 
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     * 
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the pageHeight
     *
     * @return string $pageHeight
     */
    public function getPageHeight()
    {
        return $this->pageHeight;
    }

    /**
     * Sets the pageHeight
     *
     * @param string $pageHeight
     * @return void
     */
    public function setPageHeight($pageHeight)
    {
        $this->pageHeight = $pageHeight;
    }

    /**
     * Returns the newsType
     *
     * @return string $newsType
     */
    public function getNewsType()
    {
        return $this->newsType;
    }

    /**
     * Sets the newsType
     *
     * @param string $newsType
     * @return void
     */
    public function setNewsType($newsType)
    {
        $this->newsType = $newsType;
    }

    /**
     * Returns the cover
     * 
     * @return \Yawave\Yawave\Domain\Model\Covers $cover
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Sets the cover
     * 
     * @param \Yawave\Yawave\Domain\Model\Covers $cover
     * @return void
     */
    public function setCover(\Yawave\Yawave\Domain\Model\Covers $cover)
    {
        $this->cover = $cover;
    }

    /**
     * Returns the metric
     * 
     * @return \Yawave\Yawave\Domain\Model\Metrics $metric
     */
    public function getMetric()
    {
        return $this->metric;
    }

    /**
     * Sets the metric
     * 
     * @param \Yawave\Yawave\Domain\Model\Metrics $metric
     * @return void
     */
    public function setMetric(\Yawave\Yawave\Domain\Model\Metrics $metric)
    {
        $this->metric = $metric;
    }


    /**
     * Get mainCategory
     *
     * @return \Yawave\Yawave\Domain\Model\Category[]
     */
    public function getMainCategory()
    {
        return $this->mainCategory;
    }


    /**
     * Set mainCategory
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage $mainCategory
     */
    public function setMainCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $mainCategory)
    {
        $this->mainCategory = $mainCategory;
    }

    /**
     * Adds a category to this mainCategory.
     *
     * @param Category $mainCategory
     */
    public function addMainCategories(Category $mainCategory)
    {
        $this->getMainCategory()->attach($mainCategory);
    }


    /**
     * Returns the image
     * 
     * @return \Yawave\Yawave\Domain\Model\Images $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     * 
     * @param \Yawave\Yawave\Domain\Model\Images $image
     * @return void
     */
    public function setImage(\Yawave\Yawave\Domain\Model\Images $image)
    {
        $this->image = $image;
    }

    /**
     * List of allowed categories
     *
     * @param array $categories
     * @return void
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * Returns the header
     *
     * @return \Yawave\Yawave\Domain\Model\Headers $header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Sets the header
     *
     * @param \Yawave\Yawave\Domain\Model\Headers $header
     * @return void
     */
    public function setHeader(\Yawave\Yawave\Domain\Model\Headers $header)
    {
        $this->header = $header;
    }

    /**
     * Adds a Tools
     *
     * @param \Yawave\Yawave\Domain\Model\Tools $tool
     * @return void
     */
    public function addTool(\Yawave\Yawave\Domain\Model\Tools $tool)
    {
        $this->tool->attach($tool);
    }

    /**
     * Removes a Tools
     *
     * @param \Yawave\Yawave\Domain\Model\Tools $toolToRemove The Tools to be removed
     * @return void
     */
    public function removeTool(\Yawave\Yawave\Domain\Model\Tools $toolToRemove)
    {
        $this->tool->detach($toolToRemove);
    }

    /**
     * Returns the tool
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Tools> $tool
     */
    public function getTool()
    {
        return $this->tool;
    }

    /**
     * Sets the tool
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Tools> $tool
     * @return void
     */
    public function setTool(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tool)
    {
        $this->tool = $tool;
    }

}
