<?php

namespace XoopsModules\Defacer;

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



//if (!class_exists('XoopsPersistableObjectHandler')) {
//    require __DIR__   . '/object.php';
//}

/**
 * Class ThemeHandler
 * @package XoopsModules\Defacer
 */
class ThemeHandler extends \XoopsPersistableObjectHandler
{
    /**
     * ThemeHandler constructor.
     * @param \XoopsDatabase|null $db
     */
    public function __construct(\XoopsDatabase $db = null)
    {
        parent::__construct($db, 'defacer_theme', Theme::class, 'theme_id', 'theme_name');
    }

    /**
     * @param null $id
     * @param null $fields
     * @return \XoopsModules\Defacer\Theme|\XoopsObject
     */
    public function get($id = null, $fields = null)
    {
        $id = (int)$id;
        if ($id > 0) {
            $sql    = 'SELECT * FROM ' . $this->db->prefix('defacer_theme') . ' WHERE theme_id=' . $id;
            $result = $this->db->query($sql);
            if ($result) {
                $numrows = $this->db->getRowsNum($result);
                if (1 == $numrows) {
                    $obj = new Theme();
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
