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
 * Class Page
 * @package XoopsModules\Defacer
 */
class Page extends \XoopsObject
{
    public function __construct()
    {
        parent::__construct();
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
