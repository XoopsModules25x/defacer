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
 * @version         $Id: menu.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

$adminmenu = array();

$i = -1;
$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_HOME;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/home.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_PAGEMANAGER;
$adminmenu[$i]['link'] = "admin/admin_page.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/index.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_THEMEMANAGER;
$adminmenu[$i]['link'] = "admin/admin_theme.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/watermark.png' ;
$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_METAMANAGER;
$adminmenu[$i]['link'] = "admin/admin_meta.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/administration.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_PERMISSIONMANAGER;
$adminmenu[$i]['link'] = "admin/admin_permission.php";
$adminmenu[$i]['icon']  = $pathIcon32.'/permissions.png' ;

$i++;
$adminmenu[$i]['title'] = _MI_DEFACER_ABOUT;
$adminmenu[$i]['link']  = 'admin/about.php';
$adminmenu[$i]['icon']  = $pathIcon32.'/about.png';

//$i++;
//$adminmenu[$i]['title'] = _MI_DEFACER_ABOUT;
//$adminmenu[$i]['link'] = "admin/admin_about.php";
//$adminmenu[$i]['icon']  = $pathIcon32.'/about.png';