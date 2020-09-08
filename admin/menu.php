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

//require_once  dirname(__DIR__) . '/include/common.php';
/** @var \XoopsModules\Defacer\Helper $helper */
$helper = \XoopsModules\Defacer\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
}

$adminmenu[] = [
    'title' => _MI_DEFACER_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_DEFACER_PAGEMANAGER,
    'link'  => 'admin/admin_page.php',
    'icon'  => $pathIcon32 . '/index.png',
];

$adminmenu[] = [
    'title' => _MI_DEFACER_THEMEMANAGER,
    'link'  => 'admin/admin_theme.php',
    'icon'  => $pathIcon32 . '/watermark.png',
];

$adminmenu[] = [
    'title' => _MI_DEFACER_METAMANAGER,
    'link'  => 'admin/admin_meta.php',
    'icon'  => $pathIcon32 . '/administration.png',
];

$adminmenu[] = [
    'title' => _MI_DEFACER_PERMISSIONMANAGER,
    'link'  => 'admin/admin_permission.php',
    'icon'  => $pathIcon32 . '/permissions.png',
];

$adminmenu[] = [
    'title' => _MI_DEFACER_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];

//$adminmenu[] = [
//'title' =>  _MI_DEFACER_ABOUT,
//'link' =>  "admin/admin_about.php",
//'icon' =>  $pathIcon32.'/about.png',
//];
