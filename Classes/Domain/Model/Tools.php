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
 * Tools
 */
class Tools extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * yawaveToolsId
     * 
     * @var string
     */
    protected $yawaveToolsId = '';

    /**
     * toolType
     * 
     * @var string
     */
    protected $toolType = '';

    /**
     * toolLabel
     * 
     * @var string
     */
    protected $toolLabel = '';

    /**
     * icon
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Icons>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $icon = null;

    /**
     * reference
     * 
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\References>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $reference = null;

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
        $this->icon = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->reference = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the yawaveToolsId
     * 
     * @return string $yawaveToolsId
     */
    public function getYawaveToolsId()
    {
        return $this->yawaveToolsId;
    }

    /**
     * Sets the yawaveToolsId
     * 
     * @param string $yawaveToolsId
     * @return void
     */
    public function setYawaveToolsId($yawaveToolsId)
    {
        $this->yawaveToolsId = $yawaveToolsId;
    }

    /**
     * Returns the toolType
     * 
     * @return string $toolType
     */
    public function getToolType()
    {
        return $this->toolType;
    }

    /**
     * Sets the ToolType
     * 
     * @param string $toolType
     * @return void
     */
    public function setToolType($toolType)
    {
        $this->toolType = $toolType;
    }

    /**
     * Returns the toolLabel
     * 
     * @return string $toolLabel
     */
    public function getToolLabel()
    {
        return $this->toolLabel;
    }

    /**
     * Sets the toolLabel
     * 
     * @param string $toolLabel
     * @return void
     */
    public function setToolLabel($toolLabel)
    {
        $this->toolLabel = $toolLabel;
    }

    /**
     * Adds a Icons
     * 
     * @param \Yawave\Yawave\Domain\Model\Icons $icon
     * @return void
     */
    public function addIcon(\Yawave\Yawave\Domain\Model\Icons $icon)
    {
        $this->icon->attach($icon);
    }

    /**
     * Removes a Icons
     * 
     * @param \Yawave\Yawave\Domain\Model\Icons $iconToRemove The Icons to be removed
     * @return void
     */
    public function removeIcon(\Yawave\Yawave\Domain\Model\Icons $iconToRemove)
    {
        $this->icon->detach($iconToRemove);
    }

    /**
     * Returns the icon
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Icons> $icon
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\Icons> $icon
     * @return void
     */
    public function setIcon(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $icon)
    {
        $this->icon = $icon;
    }

    /**
     * Adds a References
     * 
     * @param \Yawave\Yawave\Domain\Model\References $reference
     * @return void
     */
    public function addReference(\Yawave\Yawave\Domain\Model\References $reference)
    {
        $this->reference->attach($reference);
    }

    /**
     * Removes a References
     * 
     * @param \Yawave\Yawave\Domain\Model\References $referenceToRemove The References to be removed
     * @return void
     */
    public function removeReference(\Yawave\Yawave\Domain\Model\References $referenceToRemove)
    {
        $this->reference->detach($referenceToRemove);
    }

    /**
     * Returns the reference
     * 
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\References> $reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets the reference
     * 
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Yawave\Yawave\Domain\Model\References> $reference
     * @return void
     */
    public function setReference(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $reference)
    {
        $this->reference = $reference;
    }
}
