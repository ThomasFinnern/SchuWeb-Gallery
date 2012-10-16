<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_schuweb_gallery
 *
 * @copyright   Copyright (C) 2012 Schultschik Websolution, Sven Schultschik. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

/**
 * Build the route for the com_schuweb_gallery component
 *
 * @param    array    An array of URL arguments
 * @return    array    The URL arguments to use to assemble the subsequent URL.
 */
function SchuWeb_GalleryBuildRoute(&$query)
{
    $segments = array();
    if (isset($query['view'])) {
        //$segments[] = $query['view'];
        unset($query['view']);
    }
    if (isset($query['folder'])) {
        $segments[] = preg_replace(array('/\.\./','/\./'), array('-','/'), $query['folder']);
        unset($query['folder']);
    }

    return $segments;
}


/**
 * Parse the segments of a URL.
 *
 * @param    array    The segments of the URL to parse.
 *
 * @return    array    The URL attributes to be used by the application.
 */
function SchuWeb_GalleryParseRoute($segments)
{
    $vars = array();
    $vars['view'] = 'gallery';
    $folders = null;
    foreach ($segments as $segment) {
        if (is_null($folders)) {
            $folders = $segment;
        } else {
            $folders .= '.' . $segment;
        }
    }
    $vars['folder'] = $folders;
    return $vars;
}
