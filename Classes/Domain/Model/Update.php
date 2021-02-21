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
 * Update
 */
class Update extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * publicationUuid
     * 
     * @var string
     */
    protected $publicationUuid = '';

    /**
     * status
     * 
     * @var string
     */
    protected $status = '';

    /**
     * Returns the publicationUuid
     * 
     * @return string $publicationUuid
     */
    public function getPublicationUuid()
    {
        return $this->publicationUuid;
    }

    /**
     * Sets the publicationUuid
     * 
     * @param string $publicationUuid
     * @return void
     */
    public function setPublicationUuid($publicationUuid)
    {
        $this->publicationUuid = $publicationUuid;
    }

    /**
     * Returns the status
     * 
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     * 
     * @param string $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
