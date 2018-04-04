<?php namespace XoopsModules\Defacer;

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

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include __DIR__ . '/object.php';
//}

/**
 * Class PermissionHandler
 * @package XoopsModules\Defacer
 */
class PermissionHandler extends \XoopsPersistableObjectHandler
{
    /**
     * PermissionHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'defacer_permission', Permission::class, 'permission_id', 'permission_groups');
    }

    /**
     * @param null $id
     * @param null $fields
     * @return \XoopsModules\Defacer\Permission|\XoopsObject
     */
    public function get($id = null, $fields = null)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('defacer_permission') . ' WHERE permission_id=' . $id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if (1 == $numrows) {
                    $obj = new Defacer\Permission();
                    $obj->assignVars($this->db->fetchArray($result));

                    return $obj;
                }
            }
        }

        $obj = $this->create();

        return $obj;
    }

    /**
     * @param $obj
     * @param $field_name
     * @param $field_value
     * @return mixed
     */
    public function updateByField($obj, $field_name, $field_value)
    {
        $obj->unsetNew();
        $obj->setVar($field_name, $field_value);

        return $this->insert($obj);
    }
}
