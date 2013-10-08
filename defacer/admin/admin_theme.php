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
 * @version         $Id: admin_theme.php 0 2009-06-11 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/admin_header.php';

$actions = array('list', 'add', 'edit', 'editok', 'del', 'delok');
$op = isset($_REQUEST['op']) && in_array($_REQUEST['op'], $actions) ?  $_REQUEST['op'] : 'list';

$itemid = isset($_REQUEST['itemid']) ? intval($_REQUEST['itemid']) : 0;
$limit  = isset($_REQUEST['limit'])  ? intval($_REQUEST['limit'])  : 15;
$start  = isset($_REQUEST['start'])  ? intval($_REQUEST['start'])  : 0;

$itemid = isset($_REQUEST['theme_id']) ? intval($_REQUEST['theme_id']) : $itemid;

$indexAdmin = new ModuleAdmin();

switch ($op) {
    case 'list':
        xoops_cp_header();
        echo $indexAdmin->addNavigation('admin_theme.php');
        //defacer_adminMenu(1);
        echo defacer_index($start, $limit);
        include_once 'admin_footer.php';
        break;
    case 'add':
        defacer_add();
        break;
    case 'edit':
        xoops_cp_header();
        echo $indexAdmin->addNavigation('admin_theme.php');
        //defacer_adminMenu(1);
        echo defacer_form($itemid);
        include_once 'admin_footer.php';
        break;
    case 'editok':
        defacer_edit($itemid);
        break;
    case 'del':
        defacer_confirmdel($itemid);
        break;
    case 'delok':
        defacer_del($itemid);
        break;
}

function defacer_index($start = 0, $limit = 0)
{
    global $xoopsTpl;

    $defacer =& DefacerDefacer::getInstance();

    $count = $defacer->getHandler('theme')->getCount();
    $xoopsTpl->assign('count', $count);

    $criteria = new CriteriaCompo();
    $criteria->setStart($start);
    $criteria->setLimit($limit);
    $objs = $defacer->getHandler('theme')->getObjects($criteria);

    if ($count > $limit) {
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $nav = new XoopsPageNav($count, $limit, $start, 'start', 'op=list');
        $xoopsTpl->assign('pagenav', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
    }

    foreach ($objs as $obj) {
        $item = $obj->getValues();

        $page = $defacer->getHandler('page')->get($obj->getVar('theme_id'));
        $item['module']     = $page->getVar('name');
        $item['theme_title'] = $page->getVar('page_title');
        $item['theme_url']   = $page->getVar('page_url');
        $item['theme_status'] = $page->getVar('page_status');

        if (substr($page->getVar('page_url'), -1) == '*') {
            $item['theme_vurl'] = 0;
        } else {
            if ($page->getVar('page_moduleid') == 1){
                $item['theme_vurl'] = XOOPS_URL . '/' . $page->getVar('page_url');
            } else {
                $item['theme_vurl'] = XOOPS_URL . '/modules/' . $page->getVar('dirname') . '/' . $page->getVar('page_url');
            }
        }

        $xoopsTpl->append('items', $item);
    }

    $xoopsTpl->assign('form', defacer_form());

    return $xoopsTpl->fetch('db:defacer_admin_theme.html');
}

function defacer_add()
{
    $defacer =& DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    $obj = $defacer->getHandler('theme')->create();
    $obj->setVars($_POST);

    if (!$defacer->getHandler('theme')->insert($obj)) {
        $msg = _AM_DEFACER_ERROR;
    } else {
        $msg = _AM_DEFACER_DBUPDATED;
    }

    redirect_header(basename(__FILE__) , 2, $msg);
}

function defacer_edit($itemid)
{
    $defacer =& DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    $obj = $defacer->getHandler('theme')->get($itemid);
    $obj->setVars($_POST);

    if (!$defacer->getHandler('theme')->insert($obj)) {
        $msg = _AM_DEFACER_ERROR;
    } else {
        $msg = _AM_DEFACER_DBUPDATED;
    }

    redirect_header(basename(__FILE__), 2, $msg);
}

function defacer_del($itemid)
{
    $defacer =& DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__),1 , implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($itemid <= 0) {
        redirect_header(basename(__FILE__), 1);
    }

    $obj = $defacer->getHandler('theme')->get($itemid);
    if (!is_object($obj)) {
        redirect_header(basename(__FILE__), 1);
    }

    if (!$defacer->getHandler('theme')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('theme_id')));
        include_once 'admin_footer.php';
        exit();
    }

    redirect_header(basename(__FILE__), 2, _AM_DEFACER_DBUPDATED);
}

function defacer_confirmdel($itemid)
{
    xoops_cp_header();
    xoops_confirm(array('op' => 'delok', 'itemid' => $itemid), basename(__FILE__), _AM_DEFACER_RUDEL);
    include_once 'admin_footer.php';
}

function defacer_form($itemid = 0)
{
    $defacer =& DefacerDefacer::getInstance();
    $obj = $defacer->getHandler('theme')->get($itemid);

    if ($obj->isNew()) {
        $ftitle = _EDIT;
    } else {
        $ftitle = _ADD;
    }

    $form = new XoopsThemeForm($ftitle, 'theme_form', basename(__FILE__), 'post', true);

    $page_select = new XoopsFormSelect(_AM_DEFACER_PAGE, 'theme_id', $obj->getVar('theme_id', 'e'));
    $page_select->customValidationCode[] = 'var value = document.getElementById(\'theme_id\').value; if (value == 0){alert("' . _AM_DEFACER_SELECTPAGE_ERR . '"); return false;}';

    $criteria = new CriteriaCompo(new Criteria('page_status', 1));
    $criteria->setSort('name');
    $criteria->setOrder('ASC');
    $pageslist = $defacer->getHandler('page')->getList($criteria);
    $list = array('0' => '--------------------------');
    $pageslist = $list + $pageslist;
    $page_select->addOptionArray($pageslist);
    $form->addElement($page_select, true);

    $dirname = XOOPS_THEME_PATH . '/';
    $dirlist = array();
    if (is_dir($dirname) && $handle = opendir($dirname)) {
        while (false !== ($file = readdir($handle))) {
            if (!preg_match("/^[\.]{1,2}$/", $file)) {
                if (strtolower($file) != 'cvs' && is_dir($dirname . $file) && $file != 'z_changeable_theme') {
                    $dirlist[$file] = $file;
                }
            }
        }
        closedir($handle);
        asort($dirlist);
        reset($dirlist);
    }

    $theme_select = new XoopsFormSelect(_AM_DEFACER_THEME, 'theme_name' , $obj->getVar('theme_name', 'e'));
    $theme_select->addOptionArray($dirlist);
    $form->addElement($theme_select);

    $tray = new XoopsFormElementTray('' ,'');
    $tray->addElement(new XoopsFormButton('', 'defacer_button', _SUBMIT, 'submit'));

    $btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
    if (!$obj->isNew()) {
        $btn->setExtra('onclick="document.location.href=\'' . basename(__FILE__) . '\'"');
    } else {
        $btn->setExtra('onclick="document.getElementById(\'form\').style.display = \'none\'; return false;"');
    }
    $tray->addElement($btn);
    $form->addElement($tray);

    if (!$obj->isNew()) {
        $form->addElement(new XoopsFormHidden('op', 'editok'));
        $form->addElement(new XoopsFormHidden('itemid', $itemid));
    } else {
        $form->addElement(new XoopsFormHidden('op', 'add'));
    }

    return $form->render();
}
?>