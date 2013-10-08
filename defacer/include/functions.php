<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Defacer
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: functions.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

include_once dirname(__FILE__) . '/common.php';

function defacer_getPageInfo($ids = array())
{
    $defacer =& DefacerDefacer::getInstance();

    $proto    = (@$_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
    $fullurl  = $proto . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    $url = ltrim(str_replace($defacer->getConfig('xoops_url'), '', $fullurl), '/');

    $criteria = new CriteriaCompo(new Criteria('page_status', 1));
    if (count($ids) > 0) {
        $criteria->add(new Criteria('page_id', '(' . implode(',', $ids) . ')', 'IN'));
    }
    $pages = $defacer->getHandler('page')->getObjects($criteria);

    $pid = -1;
    $bigone['url'] = '';
    $bigone['pid'] = -1;
    foreach ($pages as $page) {
        $purl = $page->getVar('page_url');
        if ($page->getVar('page_moduleid') > 1) {
            $purl = 'modules/' . $page->getVar('dirname') . '/' . $purl;
        }
        if (substr($purl,-1) == '*') {
            $purl = substr($purl, 0, -1);
            if(substr($url, 0, strlen($purl)) == $purl || substr($fullurl, 0, strlen($purl)) == $purl) {
                $pid = $page->getVar('page_id');
                if (strlen($purl) >= strlen($bigone['url'])) {
                    $bigone['url'] = $purl;
                    $bigone['pid'] = $pid;
                }
            }
        } else if ($purl == $url || $purl == $fullurl) {
            $pid = $page->getVar('page_id');
            if (strlen($purl) >= strlen($bigone['url'])) {
                $bigone['url'] = $purl;
                $bigone['pid'] = $pid;
            }
        }
    }

    return $bigone['pid'];
}

?>