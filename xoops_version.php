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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

/**
 * General Information
 */
$modversion['version']             = 1.20;
$modversion['module_status']       = 'RC1';
$modversion['release_date']        = '2017/07/08';
$modversion['name']                = _MI_DEFACER_MD_NAME;
$modversion['description']         = _MI_DEFACER_MD_DSC;
$modversion['author']              = 'Trabis (www.xuups.com)';
$modversion['credits']             = 'The ImpressCMS Project (http://www.impresscms.org/) & TheRplima (http://community.impresscms.org/userinfo.php?uid=106)';
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['official']            = 0;
$modversion['dirname']             = basename(__DIR__);
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_website_url']  = 'https://xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = array('mysql' => '5.5');

/**
 * Images information
 */
$modversion['image']     = 'assets/images/logoModule.png';
$modversion['iconsmall'] = 'assets/images/logo_small.png';
$modversion['iconbig']   = 'assets/images/logo_big.png';

/**
 * Administrative information
 */
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

/**
 * Database information
 */
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = $modversion['dirname'] . '_page';
$modversion['tables'][1]        = $modversion['dirname'] . '_theme';
$modversion['tables'][2]        = $modversion['dirname'] . '_meta';
$modversion['tables'][3]        = $modversion['dirname'] . '_permission';

// ------------------- Help files ------------------- //
$modversion['helpsection'] = array(
    ['name' => _MI_DEFACER_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_DEFACER_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_DEFACER_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_DEFACER_SUPPORT, 'link' => 'page=support'],
);
/**
 * Templates information
 */
$modversion['templates'][] = array('file' => 'defacer_admin_page.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'defacer_admin_theme.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'defacer_admin_meta.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'defacer_admin_permission.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'defacer_admin_about.tpl', 'description' => '');

/**
 * Config information
 */
$i = 0;
$i++;
$modversion['config'][$i]['name']        = 'disable_defacer';
$modversion['config'][$i]['title']       = '_MI_DEFACER_DISDEFACER';
$modversion['config'][$i]['description'] = '_MI_PUB_DISDEFACER_DSC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;

$i++;
$modversion['config'][$i]['name']        = 'disable_themes';
$modversion['config'][$i]['title']       = '_MI_DEFACER_DISTHEMES';
$modversion['config'][$i]['description'] = '_MI_PUB_DISTHEMES_DSC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;

$i++;
$modversion['config'][$i]['name']        = 'disable_metas';
$modversion['config'][$i]['title']       = '_MI_DEFACER_DISMETAS';
$modversion['config'][$i]['description'] = '_MI_PUB_DISMETAS_DSC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;

$i++;
$modversion['config'][$i]['name']        = 'disable_permissions';
$modversion['config'][$i]['title']       = '_MI_DEFACER_DISPERMISSIONS';
$modversion['config'][$i]['description'] = '_MI_PUB_DISPERMISSIONS_DSC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 0;

$i++;
$modversion['config'][$i]['name']        = 'xoops_url';
$modversion['config'][$i]['title']       = '_MI_DEFACER_XOOPS_URL';
$modversion['config'][$i]['description'] = '_MI_PUB_XOOPS_URL_DSC';
$modversion['config'][$i]['formtype']    = 'textbox';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = XOOPS_URL;

$i++;
$modversion['config'][$i]['name']        = 'enable_redirect';
$modversion['config'][$i]['title']       = '_MI_DEFACER_ENABLE_REDIRECT';
$modversion['config'][$i]['description'] = '_MI_PUB_ENABLE_REDIRECT_DSC';
$modversion['config'][$i]['formtype']    = 'yesno';
$modversion['config'][$i]['valuetype']   = 'int';
$modversion['config'][$i]['default']     = 1;

/**
 * Search information
 */
$modversion['hasSearch'] = 0;

/**
 * Menu information
 */
$modversion['hasMain'] = 0;

/**
 * Comments information
 */
$modversion['hasComments'] = 0;

/**
 * Notification information
 */
$modversion['hasNotification'] = 0;

/**
 * About stuff
 */
$modversion['status_version']         = 'RC';
$modversion['developer_website_url']  = 'http://www.xuups.com';
$modversion['developer_website_name'] = 'Xuups';
$modversion['developer_email']        = 'lusopoemas@gmail.com';
$modversion['status']                 = 'Final';
$modversion['date']                   = '05/09/2009';

$modversion['people']['developers'][] = 'Trabis';
//$modversion['people']['testers'][] = "";
//$modversion['people']['translaters'][] = ")";
//$modversion['people']['documenters'][] = "";
//$modversion['people']['other'][] = "";

$modversion['demo_site_url']     = 'http://www.xuups.com';
$modversion['demo_site_name']    = 'Xuups.com';
$modversion['support_site_url']  = 'http://www.xuups.com/modules/newbb';
$modversion['support_site_name'] = 'Xuups Support Forums';
$modversion['submit_bug']        = 'http://www.xuups.com/modules/newbb/viewforum.php?forum=24';
$modversion['submit_feature']    = 'http://www.xuups.com/modules/newbb/viewforum.php?forum=24';

$modversion['author_word'] = '';
$modversion['warning']     = '';
