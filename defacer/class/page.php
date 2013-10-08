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
 * @version         $Id: page.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

if (!class_exists('XoopsPersistableObjectHandler')) {
    include dirname(__FILE__) . '/object.php';
}

class DefacerPage extends XoopsObject
{

    function DefacerPage()
    {
        $this->XoopsObject();
        $this->initVar('page_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('page_moduleid', XOBJ_DTYPE_INT, 1, true);
        $this->initVar('page_title', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('page_url', XOBJ_DTYPE_TXTBOX, '*', true, 255);
        $this->initVar('page_status', XOBJ_DTYPE_INT, 1, false);

        //extra vars from modules table
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 255);
        $this->initVar('dirname', XOBJ_DTYPE_TXTBOX, null, true, 255);
    }
}

class DefacerPageHandler extends XoopsPersistableObjectHandler
{
    function DefacerPageHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, 'defacer_page', 'DefacerPage', 'page_id', 'page_title');
    }

    function &get($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $sql = "SELECT * FROM " . $this->db->prefix('defacer_page') . ", " . $this->db->prefix('modules') . " WHERE page_id=" . $id . " AND mid=page_moduleid";
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $obj = new DefacerPage();
                    $obj->assignVars($this->db->fetchArray($result));
                    return $obj;
                }
            }
        }

        $obj = $this->create();
        return $obj;
    }

    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = "SELECT * FROM " . $this->db->prefix('defacer_page') . ", " . $this->db->prefix('modules');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $where = $criteria->renderWhere();
            if ($where != '') {
                $where .= ' AND (mid=page_moduleid)';
            } else {
                $where .= 'WHERE (mid=page_moduleid)';
            }
            $sql .= ' '.$where;
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        } else {
            $sql .= ' WHERE (mid=page_moduleid)';
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $page = new DefacerPage();
            $page->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $page;
            } else {
                $ret[$myrow['page_id']] =& $page;
            }
            unset($page);
        }
        return $ret;
    }

    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('defacer_page') . ', ' . $this->db->prefix('modules');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $where = $criteria->renderWhere();
            if ($where != '') {
                $where .= ' AND (mid=page_moduleid)';
            } else {
                $where .= 'WHERE (mid=page_moduleid)';
            }
            $sql .= ' '.$where;
        }
        if (!$result =& $this->db->query($sql)) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    function getList($criteria = null)
    {
        $pages = $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($pages) as $i) {
            $ret[$i] = $pages[$i]->getVar('name') . ' -> ' . $pages[$i]->getVar('page_title');
        }
        return $ret;
    }

    function updateByField(&$page, $field_name, $field_value)
    {
        $page->unsetNew();
        $page->setVar($field_name, $field_value);
        return $this->insert($page);
    }

    function getPageSelOptions($value=null)
    {
        if (!is_array($value)){
            $value = array($value);
        }
        $module_handler =& xoops_gethandler('module');
        $criteria = new CriteriaCompo(new Criteria('hasmain', 1));
        $criteria->add(new Criteria('isactive', 1));
        $module_list =& $module_handler->getObjects($criteria);
        $mods = '';
        foreach ($module_list as $module){
            $mods .= '<optgroup label="'.$module->getVar('name').'">';
            $criteria = new CriteriaCompo(new Criteria('page_moduleid', $module->getVar('mid')));
            $criteria->add(new Criteria('page_status', 1));
            $pages =& $this->getObjects($criteria);
            $sel = '';
            if (in_array($module->getVar('mid').'-0',$value)){
                $sel = ' selected=selected';
            }
            $mods .= '<option value="'.$module->getVar('mid').'-0"'.$sel.'>'._AM_ALLPAGES.'</option>';
            foreach ($pages as $page){
                $sel = '';
                if (in_array($module->getVar('mid').'-'.$page->getVar('page_id'),$value)){
                    $sel = ' selected=selected';
                }
                $mods .= '<option value="'.$module->getVar('mid').'-'.$page->getVar('page_id').'"'.$sel.'>'.$page->getVar('page_title').'</option>';
            }
            $mods .= '</optgroup>';
        }

        $module = $module_handler->get(1);
        $criteria = new CriteriaCompo(new Criteria('page_moduleid', 1));
        $criteria->add(new Criteria('page_status', 1));
        $pages =& $this->getObjects($criteria);
        $cont = '';
        if (count($pages) > 0){
            $cont = '<optgroup label="'.$module->getVar('name').'">';
            $sel = '';
            if (in_array($module->getVar('mid').'-0',$value)){
                $sel = ' selected=selected';
            }
            $cont .= '<option value="'.$module->getVar('mid').'-0"'.$sel.'>'._AM_ALLPAGES.'</option>';
            foreach ($pages as $page){
                $sel = '';
                if (in_array($module->getVar('mid').'-'.$page->getVar('page_id'),$value)){
                    $sel = ' selected=selected';
                }
                $cont .= '<option value="'.$module->getVar('mid').'-'.$page->getVar('page_id').'"'.$sel.'>'.$page->getVar('page_title').'</option>';
            }
            $cont .= '</optgroup>';
        }
        $sel = $sel1 = '';
        if (in_array('0-1',$value)){
            $sel = ' selected=selected';
        }
        if (in_array('0-0',$value)){
            $sel1 = ' selected=selected';
        }
        $ret = '<option value="0-1"'.$sel.'>'._AM_TOPPAGE.'</option><option value="0-0"'.$sel1.'>'._AM_ALLPAGES.'</option>';
        $ret .= $cont.$mods;

        return $ret;
    }
}
?>