<?php

namespace XoopsModules\Defacer;

use XoopsModules\Defacer;
use XoopsModules\Defacer\{
    Common,
    Helper
};
/** @var Helper $helper */
/** @var Utility $utility */

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------

    /**
     * @param array $ids
     * @return int
     */
    public static function getPageInfo($ids = [])
    {
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
}
