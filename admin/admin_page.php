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

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Defacer\{Helper
};

/** @var Admin $adminObject */
/** @var Helper $helper */

require_once __DIR__ . '/admin_header.php';

$actions = ['list', 'add', 'edit', 'editok', 'del', 'delok', 'changestatus'];
$op      = isset($_REQUEST['op']) && in_array($_REQUEST['op'], $actions) ? $_REQUEST['op'] : 'list';

$itemid = Request::getInt('itemid', 0, 'REQUEST');
$limit  = Request::getInt('limit', 15, 'REQUEST');
$start  = Request::getInt('start', 0, 'REQUEST');
$query  = isset($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

$adminObject = Admin::getInstance();

switch ($op) {
    case 'list':
        xoops_cp_header();
        $adminObject->displayNavigation(basename(__FILE__));
        //defacer_adminMenu(0);
        echo defacer_index($start, $limit, $query);
        xoops_cp_footer();
        break;
    case 'add':
        defacer_add();
        break;
    case 'edit':
        xoops_cp_header();
        $adminObject->displayNavigation(basename(__FILE__));
        //defacer_adminMenu(0);
        echo defacer_form($itemid);
        xoops_cp_footer();
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
    case 'changestatus':
        defacer_changestatus($itemid);
        break;
}

/**
 * @param int    $start
 * @param int    $limit
 * @param string $query
 *
 * @return mixed|string
 */
function defacer_index($start = 0, $limit = 0, $query = '')
{
    global $xoopsTpl;

    $helper = Helper::getInstance();

    $xoopsTpl->assign('query', $query);

    $criteria = new \CriteriaCompo();
    if (!empty($query)) {
        $myts = \MyTextSanitizer::getInstance();
        $criteria->add(new \Criteria('page_title', $myts->addSlashes($query) . '%', 'LIKE'));
    }

    $count = $helper->getHandler('Page')->getCount($criteria);
    $xoopsTpl->assign('count', $count);

    $criteria->setStart($start);
    $criteria->setLimit($limit);
    $criteria->setSort('name');
    $criteria->setOrder('ASC');
    $objs = $helper->getHandler('Page')->getObjects($criteria);

    if ($count > $limit) {
        require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $nav = new \XoopsPageNav($count, $limit, $start, 'start', 'op=list');
        $xoopsTpl->assign('pagenav', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
    }

    foreach ($objs as $obj) {
        $item = $obj->getValues();

        if ('*' === mb_substr($obj->getVar('page_url'), -1)) {
            $item['page_vurl'] = 0;
        } elseif (1 == $obj->getVar('page_moduleid')) {
            $item['page_vurl'] = XOOPS_URL . '/' . $obj->getVar('page_url');
        } else {
            $item['page_vurl'] = XOOPS_URL . '/modules/' . $obj->getVar('dirname') . '/' . $obj->getVar('page_url');
        }

        $xoopsTpl->append('items', $item);
    }

    $xoopsTpl->assign('form', defacer_form());

    return $xoopsTpl->fetch('db:defacer_admin_page.tpl');
}

function defacer_add()
{
    $helper = Helper::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!isset($_POST['page_moduleid']) || 0 == $_POST['page_moduleid']) {
        $_POST['page_moduleid'] = 1;
    }

    $obj = $helper->getHandler('Page')->create();
    $obj->setVars($_POST);

    if (!$helper->getHandler('Page')->insert($obj)) {
        $msg = _AM_DEFACER_ERROR;
    } else {
        $msg = _AM_DEFACER_DBUPDATED;
    }

    redirect_header(basename(__FILE__), 2, $msg);
}

/**
 * @param $itemid
 */
function defacer_edit($itemid)
{
    $helper = Helper::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!isset($_POST['page_moduleid']) || 0 == $_POST['page_moduleid']) {
        $_POST['page_moduleid'] = 1;
    }

    $obj = $helper->getHandler('Page')->get($itemid);
    $obj->setVars($_POST);

    if (!$helper->getHandler('Page')->insert($obj)) {
        $msg = _AM_DEFACER_ERROR;
    } else {
        $msg = _AM_DEFACER_DBUPDATED;
    }

    redirect_header(basename(__FILE__), 2, $msg);
}

/**
 * @param $itemid
 */
function defacer_del($itemid)
{
    $helper = Helper::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 1, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($itemid <= 0) {
        redirect_header(basename(__FILE__), 1);
    }

    $obj = $helper->getHandler('Page')->get($itemid);
    if (!is_object($obj)) {
        redirect_header(basename(__FILE__), 1);
    }

    if (!$helper->getHandler('Page')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('page_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $helper->getHandler('Theme')->get($itemid);
    if (is_object($obj) && !$helper->getHandler('Theme')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('theme_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $helper->getHandler('Meta')->get($itemid);
    if (is_object($obj) && !$helper->getHandler('Meta')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('meta_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $helper->getHandler('Permission')->get($itemid);
    if (is_object($obj) && !$helper->getHandler('Permission')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('permission_id')));
        xoops_cp_footer();
        exit();
    }

    redirect_header(basename(__FILE__), 2, _AM_DEFACER_DBUPDATED);
}

/**
 * @param $itemid
 */
function defacer_confirmdel($itemid)
{
    xoops_cp_header();
    xoops_confirm(['op' => 'delok', 'itemid' => $itemid], basename(__FILE__), _AM_DEFACER_RUDEL);
    xoops_cp_footer();
}

/**
 * @param $itemid
 */
function defacer_changestatus($itemid)
{
    $helper = Helper::getInstance();

    $obj = $helper->getHandler('Page')->get($itemid);
    $obj->setVar('page_status', !$obj->getVar('page_status'));

    if (!$helper->getHandler('Page')->insert($obj)) {
        $msg = _AM_DEFACER_ERROR;
    } else {
        $msg = _AM_DEFACER_DBUPDATED;
    }

    redirect_header(basename(__FILE__), 2, $msg);
}

/**
 * @param int $itemid
 *
 * @return string
 */
function defacer_form($itemid = 0)
{
    $helper = Helper::getInstance();
    $obj    = $helper->getHandler('Page')->get($itemid);

    if ($obj->isNew()) {
        $ftitle = _EDIT;
    } else {
        $ftitle = _ADD;
    }

    $form = new \XoopsThemeForm($ftitle, 'page_form', basename(__FILE__), 'post', true);

    $mid                         = new \XoopsFormSelect(_AM_DEFACER_PAGE_MODULE, 'page_moduleid', $obj->getVar('page_moduleid', 'e'));
    $mid->customValidationCode[] = 'var value = document.getElementById(\'page_moduleid\').value; if (value == 0){alert("' . _AM_DEFACER_SELECTMODULE_ERR . '"); return false;}';

    /** @var \XoopsModuleHandler $moduleHandler */
    $moduleHandler = xoops_getHandler('module');
    $criteria      = new \CriteriaCompo(new \Criteria('hasmain', 1));
    $criteria->add(new \Criteria('isactive', 1));
    //$criteria->setSort('name');
    //$criteria->setOrder('ASC'); xoopsModule does not accpet this :(
    $moduleslist = $moduleHandler->getList($criteria);
    $module      = $moduleHandler->get(1);
    $list        = [$module->getVar('mid') => $module->getVar('name')];
    $moduleslist = $list + $moduleslist;
    $mid->addOptionArray($moduleslist);
    $form->addElement($mid, true);

    $form->addElement(new \XoopsFormText(_AM_DEFACER_PAGE_TITLE, 'page_title', 50, 255, $obj->getVar('page_title', 'e')), true);
    $furl = new \XoopsFormText(_AM_DEFACER_PAGE_URL, 'page_url', 50, 255, $obj->getVar('page_url', 'e'));
    $furl->setDescription(_AM_DEFACER_PAGE_URL_DESC);
    $form->addElement($furl, true);
    $form->addElement(new \XoopsFormRadioYN(_AM_DEFACER_PAGE_DISPLAY, 'page_status', $obj->getVar('page_status', 'e'), _YES, _NO));

    $tray = new \XoopsFormElementTray('', '');
    $tray->addElement(new \XoopsFormButton('', 'defacer_button', _SUBMIT, 'submit'));

    $btn = new \XoopsFormButton('', 'reset', _CANCEL, 'button');
    if (!$obj->isNew()) {
        $btn->setExtra('onclick="document.location.href=\'' . basename(__FILE__) . '\'"');
    } else {
        $btn->setExtra('onclick="document.getElementById(\'form\').style.display = \'none\'; return false;"');
    }
    $tray->addElement($btn);
    $form->addElement($tray);

    if (!$obj->isNew()) {
        $form->addElement(new \XoopsFormHidden('op', 'editok'));
        $form->addElement(new \XoopsFormHidden('itemid', $itemid));
    } else {
        $form->addElement(new \XoopsFormHidden('op', 'add'));
    }

    return $form->render();
}
