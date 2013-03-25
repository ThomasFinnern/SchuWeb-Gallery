<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution / Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

class plgContentSchuWeb_Gallery extends JPlugin
{
    public function onContentPrepare($context, &$row, &$params, $page = 0)
    {
        jimport('joomla.filesystem.folder');
        require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/thumbs.php');
        $helper = new ThumbsHelper();

        $regex = '/\{SchuWebGallery: [a-zA-Z0-9_\-\/]*\}/';

        preg_match($regex, $row->text, $paths);

        foreach ($paths as $path) {
            $regex = array('/\{SchuWebGallery: /', '/\}/', '/\<[a-z]*\>/', '/\<\/[a-z]*\>/');
            $folder = preg_replace($regex, '', $path);
            if (!$helper->excludeFolder($folder)) {

                $images = $helper->getThumbs($folder);
                if ($images){
                    $html = '<ul class="thumbnails">';
                    foreach ($images as $file) {
                        $html .= '<li class="span3"><a href="'.$file['image'].'" class="thumbnail group_images"><img src="'.$file['thumb'].'" alt=""></a></li>';
                    }
                    $html .= '</ul>';
                } else {
                    $html = '<p><strong style="color:red;">No valid image path please contact administrator</strong></p>';
                }
                $folder = preg_replace('/\//', '\/', $folder);
                $regex = '/\{SchuWebGallery: ' . $folder . '\}/';

                $row->text = preg_replace($regex, $html, $row->text);

            }

        }

        $helper->insertJS();

        return true;
    }
}