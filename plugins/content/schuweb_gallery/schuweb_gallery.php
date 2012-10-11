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
        $regex = '/\{SchuWebGallery: [a-zA-Z0-9_\-\/]*\}/';

        preg_match($regex, $row->text, $paths);

        foreach ($paths as $path) {
            $regex = array('/\{SchuWebGallery: /', '/\}/', '/\<[a-z]*\>/', '/\<\/[a-z]*\>/');
            $folder = preg_replace($regex, '', $path);
            $path = JPath::clean( JPATH_BASE . '/images/' . trim($folder));

            if (JFolder::exists($path)) {
                $files = JFolder::files($path, '.', false, false, array('.svn', 'CVS', '.DS_Store', '__MACOSX', 'index.html'));
                $html = '<ul class="thumbnails">';
                foreach ($files as $file) {
                    if(!JFolder::exists($path.'/thumbs')) {
                        $image = new JImage($path . '/' . $file);
                        $image->createThumbs('300x200', 1);
                    }
                    if (JFile::exists($path . '/' . $file)) {
                        $ext = JFile::getExt($path . '/' . $file);
                        $name = basename($path . '/' . $file, '.'.$ext);
                        if (!JFile::exists($path . '/thumbs/' . $name.'_300x200.'.$ext)) {
                            $image = new JImage($path . '/' . $file);
                            $image->createThumbs('300x200', 1);
                        }
                        $html .= '<li class="span3"><a href="#" class="thumbnail"><img src="'.JUri::base().'/images/'.trim($folder).'/thumbs/' . $name.'_300x200.'.$ext.'" alt=""></a></li>';
                    }
                }
                $html .= '</ul>';
                $folder =preg_replace('/\//', '\/', $folder);
                $regex = '/\{SchuWebGallery: '.$folder.'\}/';

                $row->text = preg_replace($regex, $html, $row->text);

            }

            return true;

        }
    }
}