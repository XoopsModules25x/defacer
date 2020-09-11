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

use XoopsModules\Defacer\{
    Helper,
    Utility
};
/** @var Helper $helper */
/** @var Utility $utility */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

require_once __DIR__ . '/common.php';

$helper = Helper::getInstance();
$utility = new Utility();
if (is_object($helper->getModule()) && $helper->getModule()->getVar('isactive')) {
    $GLOBALS['xoopsLogger']->startTime('Defacer Header');

    if (!$helper->getConfig('disable_defacer')) {
        //Do permissions
        if (!$helper->getConfig('disable_permissions')) {
            $objs   = $helper->getHandler('Permission')->getObjects(null, true);
            $pageid = $utility::getPageInfo(array_keys($objs));
            if (isset($objs[$pageid]) && is_object($objs[$pageid])) {
                $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
                if (!array_intersect($objs[$pageid]->getVar('permission_groups'), $groups)) {
                    redirect_header(XOOPS_URL, 3, _NOPERM);
                }
            }
            unset($objs);
        }

        //Do themes
        if (!$helper->getConfig('disable_themes')) {
            $objs   = $helper->getHandler('Theme')->getObjects(null, true);
            $pageid = $utility::getPageInfo(array_keys($objs));
            if (isset($objs[$pageid]) && is_object($objs[$pageid])) {
                $theme = $objs[$pageid]->getVar('theme_name');
                if (empty($theme) || (!file_exists(XOOPS_ROOT_PATH . "/themes/{$theme}/theme.html") && !file_exists(XOOPS_ROOT_PATH . "/themes/{$theme}/theme.tpl"))) {
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
