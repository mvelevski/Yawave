<?php
namespace Yawave\Yawave\Domain\Repository;

use Yawave\Yawave\Domain\Model\Covers;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;

/***
 *
 * This file is part of the "New Api" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Milos <info@justraspberry.com>, Just Raspberry
 *
 ***/
/**
 * The repository for Covers
 */
class CoversRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * ImagesRepository
     *
     * @var \Yawave\Yawave\Domain\Repository\ImagesRepository
     * @Inject
     */
    protected $imagesRepository = NULL;


    // Create Cover
    public function create($cover)
    {
        $newImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $newTitleImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $newCover = new Covers();
        $newCover->setTitle($cover['title']);
        $newCover->setDescription($cover['description']);

        if($cover['title_image']['path'] !== NULL){
            $titleImage = [
                'image_url'=>$cover['title_image']['path'],
                'focus_x'=>$cover['title_image']['focus']['x'],
                'focus_y'=>$cover['title_image']['focus']['y'],
            ];
            $createTitleImage = $this->imagesRepository->createImage($titleImage);
            $newTitleImage->attach($createTitleImage);
            $newCover->setTitleImage($newTitleImage);
        }

        if($cover['image']['path'] !== NULL) {
            $image = [
                'image_url' => $cover['image']['path'],
                'focus_x' => $cover['image']['focus']['x'],
                'focus_y' => $cover['image']['focus']['y'],
            ];
            $createImage = $this->imagesRepository->createImage($image);
            $newImage->attach($createImage);
            $newCover->setImages($newImage);
        }

        $this->add($newCover);
        return $newCover;
    }

    /**
     * action edit
     *
     * @param \Yawave\Yawave\Domain\Model\Covers $cover
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $cover
     * @return void
     */
    public function edit(\Yawave\Yawave\Domain\Model\Covers $cover,$updateCover)
    {
        $updateImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $updateTitleImage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $cover->setTitle($updateCover['title']);
        $cover->setDescription($updateCover['description']);

        if($updateCover['title_image']['path'] !== NULL){
            $titleImage = [
                'image_url'=>$updateCover['title_image']['path'],
                'focus_x'=>$updateCover['title_image']['focus']['x'],
                'focus_y'=>$updateCover['title_image']['focus']['y'],
            ];
            $editTitleImage = $this->imagesRepository->edit($cover->getTitleImage()[0],$titleImage);
            $updateTitleImage->attach($editTitleImage);
            $cover->setTitleImage($updateTitleImage);
        }

        if($updateCover['image']['path'] !== NULL) {
            $image = [
                'image_url' => $updateCover['image']['path'],
                'focus_x' => $updateCover['image']['focus']['x'],
                'focus_y' => $updateCover['image']['focus']['y'],
            ];
            $editImage = $this->imagesRepository->edit($cover->getImages()[0],$image);
            $updateImage->attach($editImage);
            $cover->setImages($updateImage);
        }
        $this->update($cover);
        return $cover;
    }



}
