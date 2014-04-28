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
 * @version         $Id: theme.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

if (!class_exists('XoopsPersistableObjectHandler')) {
    include dirname(__FILE__) . '/object.php';
}

/**
 * Class DefacerTheme
 */
class DefacerTheme extends XoopsObject
{
    /**
     * constructor
     */
    function DefacerTheme()
    {
        $this->XoopsObject();
        $this->initVar("theme_id", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("theme_name", XOBJ_DTYPE_TXTBOX, null, true, 255);
    }
}

/**
 * Class DefacerThemeHandler
 */
class DefacerThemeHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param $db
     */
    function DefacerThemeHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, 'defacer_theme', 'DefacerTheme', 'theme_id', 'theme_name');
    }

    /**
     * @param mixed|null $id
     *
     * @return DefacerTheme|object
     */
    function &get($id)
    {
        $id = intval($id);
        if ($id > 0) {
            $sql = 'SELECT * FROM ' . $this->db->prefix('defacer_theme') . ' WHERE theme_id=' . $id;
            if ($result = $this->db->query($sql)) {
                $numrows = $this->db->getRowsNum($result);
                if ($numrows == 1) {
                    $obj = new DefacerTheme();
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
     *
     * @return bool
     */
    function updateByField(&$obj, $field_name, $field_value)
    {
        $obj->unsetNew();
        $obj->setVar($field_name, $field_value);

        return $this->insert($obj);
    }
}
