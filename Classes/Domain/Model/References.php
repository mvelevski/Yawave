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
 * References
 */
class References extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * linkUrl
     * 
     * @var string
     */
    protected $linkUrl = '';

    /**
     * Returns the linkUrl
     * 
     * @return string $linkUrl
     */
    public function getLinkUrl()
    {
        return $this->linkUrl;
    }

    /**
     * Sets the linkUrl
     * 
     * @param string $linkUrl
     * @return void
     */
    public function setLinkUrl($linkUrl)
    {
        $this->linkUrl = $linkUrl;
    }
}
