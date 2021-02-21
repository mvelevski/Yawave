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
 * Tag
 */
class Tag extends \GeorgRinger\News\Domain\Model\Tag
{

    /**
     * yawaveTagId
     * 
     * @var string
     */
    protected $yawaveTagId = '';

    /**
     * Returns the yawaveTagId
     * 
     * @return string $yawaveTagId
     */
    public function getYawaveTagId()
    {
        return $this->yawaveTagId;
    }

    /**
     * Sets the yawaveTagId
     * 
     * @param string $yawaveTagId
     * @return void
     */
    public function setYawaveTagId($yawaveTagId)
    {
        $this->yawaveTagId = $yawaveTagId;
    }
}
