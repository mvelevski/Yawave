<?php


namespace Yawave\Yawave\ViewHelpers;



use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use GeorgRinger\News\Domain\Model\News;

class VideoViewHelper extends AbstractViewHelper
{

    protected $context;

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('videoLink', 'string', 'Url of the link', true);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return int
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {

        $videBaseUrl = parse_url($arguments['videoLink'],PHP_URL_HOST);
        if($videBaseUrl == 'www.youtube.com' || $videBaseUrl == 'youtube.com'){
            $linkVideo = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","//www.youtube.com/embed/$1" ,$arguments['videoLink']);
        }else{
            $linkVideo = parse_url($arguments['videoLink'],PHP_URL_PATH);
        }


        $link['linkInfo'] = [
            'baseUrl'=>$videBaseUrl,
            'link'=>$linkVideo
            ];


        return $link;
    }


}