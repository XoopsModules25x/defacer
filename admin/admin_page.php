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

require_once __DIR__ . '/admin_header.php';

$actions = ['list', 'add', 'edit', 'editok', 'del', 'delok', 'changestatus'];
$op      = isset($_REQUEST['op']) && in_array($_REQUEST['op'], $actions) ? $_REQUEST['op'] : 'list';

$itemid = isset($_REQUEST['itemid']) ? (int)$_REQUEST['itemid'] : 0;
$limit  = isset($_REQUEST['limit']) ? (int)$_REQUEST['limit'] : 15;
$start  = isset($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
$query  = isset($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

$adminObject = \Xmf\Module\Admin::getInstance();

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

    $defacer = DefacerDefacer::getInstance();

    $xoopsTpl->assign('query', $query);

    $criteria = new \CriteriaCompo();
    if (!empty($query)) {
        $myts = \MyTextSanitizer::getInstance();
        $criteria->add(new \Criteria('page_title', $myts->addSlashes($query) . '%', 'LIKE'));
    }

    $count = $defacer->getHandler('page')->getCount($criteria);
    $xoopsTpl->assign('count', $count);

    $criteria->setStart($start);
    $criteria->setLimit($limit);
    $criteria->setSort('name');
    $criteria->setOrder('ASC');
    $objs = $defacer->getHandler('page')->getObjects($criteria);

    if ($count > $limit) {
        require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $nav = new \XoopsPageNav($count, $limit, $start, 'start', 'op=list');
        $xoopsTpl->assign('pagenav', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
    }

    foreach ($objs as $obj) {
        $item = $obj->getValues();

        if ('*' === substr($obj->getVar('page_url'), -1)) {
            $item['page_vurl'] = 0;
        } else {
            if (1 == $obj->getVar('page_moduleid')) {
                $item['page_vurl'] = XOOPS_URL . '/' . $obj->getVar('page_url');
            } else {
                $item['page_vurl'] = XOOPS_URL . '/modules/' . $obj->getVar('dirname') . '/' . $obj->getVar('page_url');
            }
        }

        $xoopsTpl->append('items', $item);
    }

    $xoopsTpl->assign('form', defacer_form());

    return $xoopsTpl->fetch('db:defacer_admin_page.tpl');
}

function defacer_add()
{
    $defacer = DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!isset($_POST['page_moduleid']) || 0 == $_POST['page_moduleid']) {
        $_POST['page_moduleid'] = 1;
    }

    $obj = $defacer->getHandler('page')->create();
    $obj->setVars($_POST);

    if (!$defacer->getHandler('page')->insert($obj)) {
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
    $defacer = DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!isset($_POST['page_moduleid']) || 0 == $_POST['page_moduleid']) {
        $_POST['page_moduleid'] = 1;
    }

    $obj = $defacer->getHandler('page')->get($itemid);
    $obj->setVars($_POST);

    if (!$defacer->getHandler('page')->insert($obj)) {
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
    $defacer = DefacerDefacer::getInstance();

    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(basename(__FILE__), 1, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($itemid <= 0) {
        redirect_header(basename(__FILE__), 1);
    }

    $obj = $defacer->getHandler('page')->get($itemid);
    if (!is_object($obj)) {
        redirect_header(basename(__FILE__), 1);
    }

    if (!$defacer->getHandler('page')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('page_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $defacer->getHandler('theme')->get($itemid);
    if (is_object($obj) && !$defacer->getHandler('theme')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('theme_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $defacer->getHandler('meta')->get($itemid);
    if (is_object($obj) && !$defacer->getHandler('meta')->delete($obj)) {
        xoops_cp_header();
        xoops_error(sprintf(_AM_DEFACER_ERROR, $obj->getVar('meta_id')));
        xoops_cp_footer();
        exit();
    }

    $obj = $defacer->getHandler('permission')->get($itemid);
    if (is_object($obj) && !$defacer->getHandler('permission')->delete($obj)) {
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
    $defacer = DefacerDefacer::getInstance();

    $obj = $defacer->getHandler('page')->get($itemid);
    $obj->setVar('page_status', !$obj->getVar('page_status'));

    if (!$defacer->getHandler('page')->insert($obj)) {
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
    $defacer = DefacerDefacer::getInstance();
    $obj     = $defacer->getHandler('page')->get($itemid);

    if ($obj->isNew()) {
        $ftitle = _EDIT;
    } else {
        $ftitle = _ADD;
    }

    $form = new \XoopsThemeForm($ftitle, 'page_form', basename(__FILE__), 'post', true);

    $mid                         = new \XoopsFormSelect(_AM_DEFACER_PAGE_MODULE, 'page_moduleid', $obj->getVar('page_moduleid', 'e'));
    $mid->customValidationCode[] = 'var value = document.getElementById(\'page_moduleid\').value; if (value == 0){alert("' . _AM_DEFACER_SELECTMODULE_ERR . '"); return false;}';

    /** @var XoopsModuleHandler $moduleHandler */
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
