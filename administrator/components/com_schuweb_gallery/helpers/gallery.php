<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/thumbs.php');

class GalleryHelper
{
    private $params;
    private $image_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'index.html', 'joomla_black.gif', 'joomla_green.gif', 'joomla_logo_black.jpg', 'powered_by.png');
    private $folder_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'thumbs', 'tmp');

    public function __construct() {
        $this->params = JComponentHelper::getParams('com_schuweb_gallery');

        $images_exclude_param = $this->params->get('image_exclude');
        if ($images_exclude_param) {
            $images_exclude = explode(',', $images_exclude_param);
            foreach ($images_exclude as $k => $v) {
                $images_exclude[$k] = trim($v);
            }
            $this->image_excludes = array_merge($this->image_excludes, $images_exclude);
        }


        $folders_exclude_param = $this->params->get('folder_exclude');
        if ($folders_exclude_param) {
            $folders_exclude = explode(',', $folders_exclude_param);
            foreach ($folders_exclude as $k => $v) {
                $folders_exclude[$k] = trim($v);
            }
            $this->folder_excludes = array_merge($folders_exclude, $this->folder_excludes);
        }
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getImage_excludes()
    {
        return $this->image_excludes;
    }

    public function getFolder_excludes()
    {
        return $this->folder_excludes;
    }

    public function excludeFolder($folder)
    {
        foreach ($this->folder_excludes as $v) {
            if (strpos($folder, $v)) {
                return true;
            }
        }

        return false;
    }

    public static function getActions()
    {
        $user = JFactory::getUser();
        $result = new JObject;

        $actions = JAccess::getActionsFromFile(
            JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/access.xml', "/access/section[@name='component']/");

        foreach ($actions as $action) {
            $result->set($action->name, $user->authorise($action->name, "com_schuweb_gallery"));
        }

        return $result;
    }

    /**
     * @param $start_folder
     * @return $retFolders an array with the list of folders include name and random image
     */
    public function getFolders($start_folder)
    {
        $folders = JFolder::folders(JPATH_BASE . '/' . $start_folder, '.', false, false, $this->folder_excludes);

        $thumbHelper = new ThumbsHelper();

        $retFolders = array();

        if (!empty($folders)) {
            foreach ($folders as $key => $folder) {
                $path = $start_folder . '/' . $folder;
                $images = JFolder::files(JPATH_BASE . '/' . $path, '.', false, false, $this->image_excludes);
                if (!empty($images)) {
                    $image = $images[array_rand($images)];
                    $image = $thumbHelper->getThumb($path, $image);

                    $retFolders[$key]['folder'] = $path;
                    $retFolders[$key]['name'] = preg_replace('/\_/', ' ', $folder);
                    $retFolders[$key]['image'] = $image;
                } else {
                    $folders2 = $this->getFolders($path);
                    if (!empty($folders2)) {
                        $retFolders[$key]['folder'] = $path;
                        $retFolders[$key]['name'] = preg_replace('/\_/', ' ', $folder);
                        $folder = $folders2[array_rand($folders2)];
                        $retFolders[$key]['image'] = $folder['image'];
                    }
                }
            }
        }
        return $retFolders;
    }

    public static function insertJS()
    {
        $web = JApplicationWeb::getInstance();

        $dispatcher = JDispatcher::getInstance();

        if (!$web->client->mobile) {
            $dispatcher->register('onBeforeCompileHead', 'triggerSchuWebScriptjQuery');
        }

        if (JComponentHelper::getParams('com_schuweb_gallery')->get('bootstrap', 1) == 0) {
            $dispatcher->register('onBeforeCompileHead', 'triggerSchuWebScriptBootstrap');
        }
    }
}

function triggerSchuWebScriptBootstrap()
{
    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::base() . 'media/com_schuweb_gallery/css/bootstrap.min.css')
        ->addStyleSheet(JUri::base() . 'media/com_schuweb_gallery/css/bootstrap-responsive.min.css')
        ->addScript(JUri::base() . 'media/com_schuweb_gallery/js/bootstrap.min.js');
}

function triggerSchuWebScriptjQuery()
{
    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::base() . 'media/com_schuweb_gallery/css/colorbox.css')
        ->addScript(JUri::base() . 'media/com_schuweb_gallery/js/colorbox/jquery.colorbox-min.js')
        ->addScript(JUri::base() . 'media/com_schuweb_gallery/js/schuweb_colorbox.js');
}