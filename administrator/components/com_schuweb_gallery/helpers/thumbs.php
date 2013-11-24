<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;
require_once(JPATH_ADMINISTRATOR . '/components/com_schuweb_gallery/helpers/gallery.php');
jimport('joomla.filesystem.file');

class ThumbsHelper
{
    private $size = '300x200';
    private $resizeMethod;
    private $imageExcludes = array();


    public function __construct()
    {
        $galleryHelper = new GalleryHelper();

        $this->imageExcludes = $galleryHelper->getImage_excludes();

        $params = $galleryHelper->getParams();

        $this->size = $params->get('size', '300x200');
        $this->resizeMethod = $params->get('resize_method', 1);
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
            $files = JFolder::files(JPATH_BASE . '/' . $path, '.', false, false, $this->imageExcludes);
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
            if (is_null($resizeMethod)) $resizeMethod = $this->resizeMethod;
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
                    throw new InvalidArgumentException('Resize Method does not exist: ' . $this->resizeMethod);
            }
        }
    }

    private function twoWayResize($image, $path, $firstResizeMethod = 2)
    {
        $image->createThumbs($this->size, $firstResizeMethod, $path . '/tmp');
        $absolut_path = $path . '/tmp';
        $images = JFolder::files($absolut_path, '.', false, false, $this->imageExcludes);
        foreach ($images as $file) {
            $ext = JFile::getExt($absolut_path . '/' . $file);
            $name = basename($absolut_path . '/' . $file, '.' . $ext);
            self::checkThumbs($path . '/tmp', $file, $ext, $name, true, 4);
        }
        JFolder::delete($path . '/tmp');
    }
}