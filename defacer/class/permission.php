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
 * @version         $Id: permission.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

if (!class_exists('XoopsPersistableObjectHandler')) {
    include dirname(__FILE__) . '/object.php';
}

class DefacerPermission extends XoopsObject
{
    /**
     * constructor
     */
    function DefacerPermission()
    {
        $this->XoopsObject();
        $this->initVar("permission_id", XOBJ_DTYPE_INT, 0, true);
        $this->initVar('permission_groups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
    }
}

class DefacerPermissionHandler extends XoopsPersistableObjectHandler
{
    function DefacerPermissionHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, 'defacer_permission', 'DefacerPermission', 'permission_id', 'permission_groups');
    }

    function &get($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('defacer_permission') . ' WHERE permission_id=' . $id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $obj = new DefacerPermission();
                    $obj->assignVars($this->db->fetchArray($result));
                    return $obj;
                }
            }
        }

        $obj = $this->create();
        return $obj;
    }

    function updateByField(&$obj, $field_name, $field_value)
    {
        $obj->unsetNew();
        $obj->setVar($field_name, $field_value);
        return $this->insert($obj);
    }
}
?>