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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

require_once __DIR__ . '/common.php';
$debug   = true;
$helper = Defacer\Helper::getInstance($debug);

if ((null !== $helper) && is_object($helper->getModule()) && $helper->getModule()->getVar('isactive')) {
    $GLOBALS['xoopsLogger']->startTime('Defacer Footer');

    if (!$helper->getConfig('disable_defacer')) {

        //Do metas
        if (!$helper->getConfig('disable_metas')) {
            $objs   = $helper->getHandler('Meta')->getObjects(null, true);
            $pageid = defacer_getPageInfo(array_keys($objs));

            if (isset($objs[$pageid]) && is_object($objs[$pageid])) {
                $obj = $objs[$pageid];

                if ($obj->getVar('meta_sitename')) {
                    $GLOBALS['xoopsTpl']->assign('xoops_sitename', $obj->getVar('meta_sitename'));
                }
                if ($obj->getVar('meta_pagetitle')) {
                    $GLOBALS['xoopsTpl']->assign('xoops_pagetitle', $obj->getVar('meta_pagetitle'));
                }
                if ($obj->getVar('meta_slogan')) {
                    $GLOBALS['xoopsTpl']->assign('xoops_slogan', $obj->getVar('meta_slogan'));
                }
                if ($obj->getVar('meta_keywords')) {
                    $GLOBALS['xoopsTpl']->assign('xoops_meta_keywords', $obj->getVar('meta_keywords'));
                }
                if ($obj->getVar('meta_description')) {
                    $GLOBALS['xoopsTpl']->assign('xoops_meta_description', $obj->getVar('meta_description'));
                }
                if (isset($GLOBALS['xoTheme']) && is_object($GLOBALS['xoTheme'])) {
                    if ($obj->getVar('meta_keywords')) {
                        $GLOBALS['xoTheme']->addMeta('meta', 'keywords', $obj->getVar('meta_keywords'));
                    }
                    if ($obj->getVar('meta_description')) {
                        $GLOBALS['xoTheme']->addMeta('meta', 'description', $obj->getVar('meta_description'));
                    }
                }
                unset($obj);
            }
            unset($objs);
        }
    }

    $GLOBALS['xoopsLogger']->stopTime('Defacer Footer');
}
