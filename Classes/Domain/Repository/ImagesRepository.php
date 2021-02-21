<?php


namespace Yawave\Yawave\Domain\Repository;


use GeorgRinger\News\Domain\Model\FileReference;
use Yawave\Yawave\Domain\Model\Images;
use TYPO3\CMS\Core\Resource\DuplicationBehavior;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***
 *
 * This file is part of the "Yawave" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 JustRaspberry <info@justraspberry.com>, Just Raspberry
 *
 ***/
/**
 * The repository for Image
 */

class ImagesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    // Create Image
    public function createImage($image)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);
        $newImage = new Images();
        $newImage->setUrl($image['image_url']);
            $uploadedImage = $this->uploadImageInFile($image['image_url']);
            if($uploadedImage !== NULL){
                $newImage->addImage($uploadedImage);
            }
        $newImage->setHeight($image['image_height']);
        $newImage->setWidth($image['image_width']);
        $newImage->setFocusX($image['focus_x']);
        $newImage->setFocusY($image['focus_y']);
        $this->add($newImage);
        $persistenceManager->persistAll();
        return $newImage;
    }


    /**
     * action edit
     *
     * @param \Yawave\Yawave\Domain\Model\Images $images
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $images
     * @return void
     */
    public function edit(\Yawave\Yawave\Domain\Model\Images $images,$updateImage){

        $images->setUrl($updateImage['image_url']);
        $uploadedImage = $this->uploadImageInFile($updateImage['image_url']);
        if($uploadedImage !== NULL){
            if(count($images->getImage())>0){
                $images->removeImage($images->getImage()[0]);
            }
            $images->addImage($uploadedImage);
        }

        $images->setHeight($updateImage['image_height']);
        $images->setWidth($updateImage['image_width']);
        $images->setFocusX($updateImage['focus_x']);
        $images->setFocusY($updateImage['focus_y']);
        $this->update($images);
        return $images;
    }

    // Upload image in Typo3 system from URL
    public function uploadImageInFile($imageUrl)
    {
        $mediaFolder = 'yawave_images';

        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        $storage = $resourceFactory->getDefaultStorage();

        if($storage->hasFolder($mediaFolder)){
            $targetFolder = $storage->getFolder($mediaFolder);
        }else{
            $targetFolder = $storage->createFolder($mediaFolder);
        }
        $imageInfo = pathinfo($imageUrl);
        $imageName = $imageInfo['basename'];
        $externalFile = GeneralUtility::getUrl($imageUrl);

        if($imageInfo['extension'] !== NULL){
            $tempFileName = tempnam(sys_get_temp_dir(), $imageInfo['extension']);

            $handle       = fopen($tempFileName, "w");
            fwrite($handle, $externalFile);
            fclose($handle);

            if($targetFolder->hasFile($imageName)){

                $getImages = $storage->getFilesInFolder($targetFolder);

                foreach ($getImages as $key => $getImage){
                    if($key == $imageName){
                        $fileResourceReference = new \TYPO3\CMS\Core\Resource\FileReference(array('uid_local' => $getImage->getUid()));

                        $fileSysReference = $this->objectManager->get(FileReference::class);
                        $fileSysReference->setOriginalResource($fileResourceReference);
                        return $fileSysReference;
                    }
                }
            }else{
                try {
                    $imageFile = $targetFolder->addFile($tempFileName, $imageName, DuplicationBehavior::RENAME);
                    $fileResourceReference = new \TYPO3\CMS\Core\Resource\FileReference(array('uid_local' => $imageFile->getUid()));
                    $fileSysReference = $this->objectManager->get(FileReference::class);
                    $fileSysReference->setOriginalResource($fileResourceReference);

                    return $fileSysReference;
                } catch (\Exception $e) {
                    $getImages = $storage->getFilesInFolder($targetFolder);

                    foreach ($getImages as $key => $getImage){
                        if($key == $imageName){
                            $fileResourceReference = new \TYPO3\CMS\Core\Resource\FileReference(array('uid_local' => $getImage->getUid()));

                            $fileSysReference = $this->objectManager->get(FileReference::class);
                            $fileSysReference->setOriginalResource($fileResourceReference);
                            return $fileSysReference;
                        }
                    }
                }


            }

        }








    }



}