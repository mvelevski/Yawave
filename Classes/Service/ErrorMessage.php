<?php


namespace Yawave\Yawave\Service;



class ErrorMessage
{
    public function showError($header,$body){
        $message = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessage::class,
            $body,
            $header,
            \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING,
            true
        );
        $flashMessageService = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

        return $messageQueue;

    }
}