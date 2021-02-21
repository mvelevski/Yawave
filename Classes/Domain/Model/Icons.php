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
 * Icons
 */
class Icons extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * source
     * 
     * @var string
     */
    protected $source = '';

    /**
     * name
     * 
     * @var string
     */
    protected $name = '';

    /**
     * type
     * 
     * @var string
     */
    protected $type = '';

    /**
     * Returns the source
     * 
     * @return string $source
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Sets the source
     * 
     * @param string $source
     * @return void
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * Returns the name
     * 
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     * 
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the type
     * 
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     * 
     * @param string $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
