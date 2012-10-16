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
    private $image_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'index.html');
    private $folder_excludes = array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'thumbs');

    public function __construct()
    {
        $this->params = JComponentHelper::getParams('com_schuweb_gallery');
        $images_exclude = explode(',', $this->params->get('image_exclude'));
        foreach ($images_exclude as $k => $v){
            $images_exclude[$k] = trim($v);
        }
        $this->image_excludes = array_merge($this->image_excludes, $images_exclude);
        $folders_exclude = explode(',', $this->params->get('folder_exclude'));
        foreach ($folders_exclude as $k => $v){
            $folders_exclude[$k] = trim($v);
        }
        $this->folder_excludes = array_merge($folders_exclude, $this->folder_excludes);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getImage_excludes()
    {
        return $this->image_excludes;
    }

    public function getFolder_excludes(){
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
                $res = JURI::base() . $path . '/thumbs/' . $name . '_' . $this->params->get('size') . '.' . $ext;
            }
        }
        return $res;
    }

    public function getThumbs($path)
    {
        $res = false;
        if (JFolder::exists($path)) {
            $files = JFolder::files($path, '.', false, false, $this->image_excludes);
            foreach ($files as $file) {
                $res[] = $this->getThumb($path, $file);
            }
        }
        return $res;
    }

    private function checkThumbs($path, $file, $ext, $name)
    {
        if (!JFolder::exists($path . '/thumbs')) {
            $image = new JImage($path . '/' . $file);
            $image->createThumbs($this->size, 1);
        }
        if (!JFile::exists($path . '/thumbs/' . $name . '_' . $this->size . '.' . $ext)) {
            $image = new JImage($path . '/' . $file);
            $image->createThumbs($this->size, 1);
        }
    }
}