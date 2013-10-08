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
 * @version         $Id: beforeheader.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

require dirname(__FILE__) . '/common.php';

if (is_object($defacer->getModule()) && $defacer->getModule()->getVar('isactive')) {
    $GLOBALS['xoopsLogger']->startTime('Defacer Header');

    if (!$defacer->getConfig('disable_defacer')) {

        //Do permissions
        if (!$defacer->getConfig('disable_permissions')) {
            $objs = $defacer->getHandler('permission')->getObjects(null, true);
            $pageid = defacer_getPageInfo(array_keys($objs));
            if (isset($objs[$pageid]) && is_object($objs[$pageid])) {
                $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
                if (!array_intersect($objs[$pageid]->getVar('permission_groups'), $groups)) {
                    redirect_header(XOOPS_URL ,3,_NOPERM);
                    exit();
                }
            }
            unset($objs);
        }

        //Do themes
        if (!$defacer->getConfig('disable_themes')) {
            $objs = $defacer->getHandler('theme')->getObjects(null, true);
            $pageid = defacer_getPageInfo(array_keys($objs));
            if (isset($objs[$pageid]) && is_object($objs[$pageid])) {
                $theme = $objs[$pageid]->getVar('theme_name');
                if (empty($theme) || !file_exists(XOOPS_ROOT_PATH . "/themes/{$theme}/theme.html")) {
                    $theme = $GLOBALS['xoopsConfig']['theme_set'];
                }
                $GLOBALS['xoopsConfig']['theme_set'] = $theme;
                if (!in_array($theme, $GLOBALS['xoopsConfig']['theme_set_allowed'])) {
                    $GLOBALS['xoopsConfig']['theme_set_allowed'][] = $theme;
                }
                //$_POST['xoops_theme_select'] = $_SESSION['xoopsUserTheme'];
                $_REQUEST['xoops_theme_select'] = $theme; //disallow the theme block
            } else {
                $_REQUEST['xoops_theme_select'] = $GLOBALS['xoopsConfig']['theme_set'];
            }
            unset($objs);
        }
    }

    $GLOBALS['xoopsLogger']->stopTime('Defacer Header');
}
?>