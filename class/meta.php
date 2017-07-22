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

//if (!class_exists('XoopsPersistableObjectHandler')) {
//    include __DIR__ . '/object.php';
//}

class DefacerMeta extends XoopsObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        //        $this->XoopsObject();
        parent::__construct();
        $this->initVar('meta_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('meta_sitename', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('meta_pagetitle', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('meta_slogan', XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('meta_keywords', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('meta_description', XOBJ_DTYPE_TXTAREA, null, false);
    }
}

class DefacerMetaHandler extends XoopsPersistableObjectHandler
{
    public function __construct(XoopsDatabase $db = null)
    {
        parent::__construct($db, 'defacer_meta', 'DefacerMeta', 'meta_id', 'meta_sitename');
    }

    public function get($id = null, $fields = null)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('defacer_meta') . ' WHERE meta_id=' . $id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $obj = new DefacerMeta();
                    $obj->assignVars($this->db->fetchArray($result));

                    return $obj;
                }
            }
        }

        $obj = $this->create();

        return $obj;
    }

    public function updateByField($obj, $field_name, $field_value)
    {
        $obj->unsetNew();
        $obj->setVar($field_name, $field_value);

        return $this->insert($obj);
    }
}
