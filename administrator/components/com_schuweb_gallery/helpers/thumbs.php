<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

class ThumbsHelper
{
    private $params;
    private $size = '300x200';
    private $resize_method;
    private $image_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'index.html', 'joomla_black.gif', 'joomla_green.gif', 'joomla_logo_black.jpg', 'powered_by.png');
    private $folder_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'thumbs', 'tmp');

    public function __construct()
    {
        $this->params = JComponentHelper::getParams('com_schuweb_gallery');
        $images_exclude = explode(',', $this->params->get('image_exclude'));
        foreach ($images_exclude as $k => $v) {
            $images_exclude[$k] = trim($v);
        }
        $this->image_excludes = array_merge($this->image_excludes, $images_exclude);
        $folders_exclude = explode(',', $this->params->get('folder_exclude'));
        foreach ($folders_exclude as $k => $v) {
            $folders_exclude[$k] = trim($v);
        }
        $this->folder_excludes = array_merge($folders_exclude, $this->folder_excludes);
        $this->size = $this->params->get('size', '300x200');
        $this->resize_method = $this->params->get('resize_method', 1);
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

    public function getThumb($path, $file)
    {
        $res = false;
        $absolut_path = JPATH_BASE . '/' . $path;
        if (JFolder::exists($absolut_path)) {
            if (JFile::exists($absolut_path . '/' . $file)) {
                $ext = JFile::getExt($absolut_path . '/' . $file);
                $name = basename($absolut_path . '/' . $file, '.' . $ext);
                self::checkThumbs($absolut_path, $file, $ext, $name);
                $res['thumb'] = JURI::base() . $path . '/thumbs/' . $name . '_' . $this->size . '.' . $ext;
                $res['image'] = JURI::base() . $path . '/' . $name . '.' . $ext;
            }
        }
        return $res;
    }

    public function getThumbs($path)
    {
        $res = false;
        if (JFolder::exists(JPATH_BASE . '/' . $path)) {
            $files = JFolder::files(JPATH_BASE . '/' . $path, '.', false, false, $this->image_excludes);
            foreach ($files as $file) {
                $res[] = $this->getThumb($path, $file);
            }
        }
        return $res;
    }

    private function checkThumbs($path, $file, $ext, $name, $tmp = false, $resizeMethod = null)
    {
        if ((!JFolder::exists($path . '/thumbs')) || (!JFile::exists($path . '/thumbs/' . $name . '_' . $this->size . '.' . $ext))) {
            $image = new JImage($path . '/' . $file);
            if (is_null($resizeMethod)) $resizeMethod = $this->resize_method;
            switch ($resizeMethod) {
                case 1:
                case 2:
                case 3:
                case 4:
                    $thumbsFolder = null;
                    if ($tmp == true) {
                        $thumbsFolder = $path . '/../thumbs';
                        $name = substr($name, 0, strrpos($name, '_'));
                        JFile::move($image->getPath(), $path . '/' . $name . '.' . $ext);
                        $image = new JImage($path . '/' . $name . '.' . $ext);
                    }
                    $image->createThumbs($this->size, $resizeMethod, $thumbsFolder);
                    break;
                case 5:
                    self::twoWayResize($image, $path);
                    break;
                case 6:
                    self::twoWayResize($image, $path, 3);
                    break;
                default:
                    throw new InvalidArgumentException('Resize Method does not exist: ' . $this->resize_method);
            }
        }
    }

    private function twoWayResize($image, $path, $first_resize_method = 2)
    {
        $image->createThumbs($this->size, $first_resize_method, $path . '/tmp');
        $absolut_path = $path . '/tmp';
        $images = JFolder::files($absolut_path, '.', false, false, $this->image_excludes);
        foreach ($images as $file) {
            $ext = JFile::getExt($absolut_path . '/' . $file);
            $name = basename($absolut_path . '/' . $file, '.' . $ext);
            self::checkThumbs($path . '/tmp', $file, $ext, $name, true, 4);
        }
        JFolder::delete($path . '/tmp');
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

    public static function insertJS()
    {
        $web = JApplicationWeb::getInstance();
        if (!$web->client->mobile) {
            $dispatcher = JDispatcher::getInstance();
            $dispatcher->register('onBeforeCompileHead', 'triggerSchuWebScriptjQuery');
        }
    }
}

function triggerSchuWebScriptjQuery()
{
    $document = JFactory::getDocument();
    $document->addStyleSheet(JUri::base() . 'media/com_schuweb_gallery/css/colorbox.css')
        ->addScript(JUri::base() . 'media/com_schuweb_gallery/js/colorbox/jquery.colorbox-min.js')
        ->addScript(JUri::base() . 'media/com_schuweb_gallery/js/schuweb_colorbox.js');
}