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
 */

use XoopsModules\Defacer;
use XoopsModules\Defacer\Helper;

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

require_once __DIR__ . '/common.php';

/**
 * @param array $ids
 * @return int
 */
function defacer_getPageInfo($ids = [])
{
    /** @var \XoopsModules\Defacer\Helper $helper */
    $helper = Helper::getInstance();

    $proto   = ('on' === @$_SERVER['HTTPS']) ? 'https' : 'http';
    $fullurl = $proto . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url     = ltrim(str_replace($helper->getConfig('xoops_url'), '', $fullurl), '/');

    $criteria = new \CriteriaCompo(new \Criteria('page_status', 1));
    if (count($ids) > 0) {
        $criteria->add(new \Criteria('page_id', '(' . implode(',', $ids) . ')', 'IN'));
    }
    $pages = $helper->getHandler('Page')->getObjects($criteria);

    $pid           = -1;
    $bigone['url'] = '';
    $bigone['pid'] = -1;
    foreach ($pages as $page) {
        $purl = $page->getVar('page_url');
        if ($page->getVar('page_moduleid') > 1) {
            $purl = 'modules/' . $page->getVar('dirname') . '/' . $purl;
        }
        if ('*' === mb_substr($purl, -1)) {
            $purl = mb_substr($purl, 0, -1);
            if (0 === mb_strpos($url, $purl) || 0 === mb_strpos($fullurl, $purl)) {
                $pid = $page->getVar('page_id');
                if (mb_strlen($purl) >= mb_strlen($bigone['url'])) {
                    $bigone['url'] = $purl;
                    $bigone['pid'] = $pid;
                }
            }
        } elseif ($purl == $url || $purl == $fullurl) {
            $pid = $page->getVar('page_id');
            if (mb_strlen($purl) >= mb_strlen($bigone['url'])) {
                $bigone['url'] = $purl;
                $bigone['pid'] = $pid;
            }
        }
    }

    return $bigone['pid'];
}
