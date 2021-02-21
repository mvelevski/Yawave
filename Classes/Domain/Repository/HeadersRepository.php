<?php


namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Headers;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;

/***
 *
 * This file is part of the "Yawave" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Just Raspberry <info@justraspberry.com>, Just Raspberry
 *
 ***/
/**
 * The repository for Headers
 */

class HeadersRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ImagesRepository
     * @Inject
     */
    protected $imagesRepository = NULL;


    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    // Create Header
    public function createHeader($header){
        $newImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $newHeader = new Headers();

        $newHeader->setTitle($header['title']);
        $newHeader->setDescription($header['description']);
        if(!empty($header['image'])){

            $image = [
                'image_url'=>$header['image']['path'],
                'focus_x'=>$header['image']['focus']['x'],
                'focus_y'=>$header['image']['focus']['y']
            ];
            $createImage = $this->imagesRepository->createImage($image);
            $newImage->attach($createImage);
            $newHeader->setImage($newImage);
        }
        $this->add($newHeader);
        return $newHeader;
    }

    /**
     * @param \Yawave\Yawave\Domain\Model\Headers $header
     * @param array $updateHeader
     */
    public function editHeader(\Yawave\Yawave\Domain\Model\Headers $header,$updateHeader){
        $newImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $header->setTitle($updateHeader['title']);
        $header->setDescription($updateHeader['description']);

        if(!empty($updateHeader['image'])){
            $image = [
                'image_url'=>$updateHeader['image']['path'],
                'focus_x'=>$updateHeader['image']['focus']['x'],
                'focus_y'=>$updateHeader['image']['focus']['y']
            ];
            $editImage = $this->imagesRepository->edit($header->getImage()[0],$image);
            $newImage->attach($editImage);
            $header->setImage($newImage);
        }

        $this->update($header);
        return $header;
    }
}