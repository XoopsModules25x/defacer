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


//if (!class_exists('XoopsPersistableObjectHandler')) {
//    require __DIR__   . '/object.php';
//}

/**
 * Class Permission
 * @package XoopsModules\Defacer
 */
class Permission extends \XoopsObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('permission_id', \XOBJ_DTYPE_INT, 0, true);
        $this->initVar('permission_groups', \XOBJ_DTYPE_ARRAY, \serialize([XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS]));
    }
}
