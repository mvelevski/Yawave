<?php


namespace Yawave\Yawave\Controller;


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
 * UpdateController
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Annotation\Inject;


class UpdateController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \Yawave\Yawave\Domain\Repository\UpdateRepository
     * @Inject
     */
    protected $updateRepository = NULL;

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


    /**
     * action create
     *
     * @param \Yawave\Yawave\Domain\Model\Update $newUpdate
     * @return void
     */
    public function createAction(\Yawave\Yawave\Domain\Model\Update $newUpdate)
    {
        $persistenceManager = $this->objectManager->get(\TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager::class);

        $this->updateRepository->add($newUpdate);
        $persistenceManager->persistAll();

        return $newUpdate;
    }

    /**
     * action edit
     *
     * @param \Yawave\Yawave\Domain\Model\Update $update
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $update
     * @return void
     */
    public function editAction(\Yawave\Yawave\Domain\Model\Update $update)
    {
        $this->view->assign('update', $update);
    }

    /**
     * action update
     *
     * @param \Yawave\Yawave\Domain\Model\Update $update
     * @return void
     */
    public function updateAction(\Yawave\Yawave\Domain\Model\Update $update)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See https://docs.typo3.org/typo3cms/extensions/extension_builder/User/Index.html', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING);
        $this->updateRepository->update($update);
        $this->redirect('list');
    }

}