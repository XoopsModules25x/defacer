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
 * Class Meta
 * @package XoopsModules\Defacer
 */
class Meta extends \XoopsObject
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
