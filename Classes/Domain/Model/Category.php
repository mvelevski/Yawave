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
 * Category
 */
class Category extends \GeorgRinger\News\Domain\Model\Category
{

    /**
     * yawaveCategoryId
     * 
     * @var string
     */
    protected $yawaveCategoryId = '';

    /**
     * yawaveCategoryParentId
     * 
     * @var string
     */
    protected $yawaveCategoryParentId = '';

    /**
     * Returns the yawaveCategoryId
     * 
     * @return string $yawaveCategoryId
     */
    public function getYawaveCategoryId()
    {
        return $this->yawaveCategoryId;
    }

    /**
     * Sets the yawaveCategoryId
     * 
     * @param string $yawaveCategoryId
     * @return void
     */
    public function setYawaveCategoryId($yawaveCategoryId)
    {
        $this->yawaveCategoryId = $yawaveCategoryId;
    }

    /**
     * Returns the yawaveCategoryParentId
     * 
     * @return string $yawaveCategoryParentId
     */
    public function getYawaveCategoryParentId()
    {
        return $this->yawaveCategoryParentId;
    }

    /**
     * Sets the yawaveCategoryParentId
     * 
     * @param string $yawaveCategoryParentId
     * @return void
     */
    public function setYawaveCategoryParentId($yawaveCategoryParentId)
    {
        $this->yawaveCategoryParentId = $yawaveCategoryParentId;
    }
}
