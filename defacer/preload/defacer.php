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
 * Initiating Defacer module
 *
 * This file is responsible for initiating the Defacer module so no hacks on header.php and footer.php are required
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Defacer
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: defacer.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('ICMS_ROOT_PATH') or die("ICMS root path not defined");

class IcmsPreloadDefacer extends IcmsPreloadItem
{
    function eventbeforeFooter()
    {
        if (file_exists($filename = ICMS_ROOT_PATH . '/modules/defacer/include/beforefooter.php')) {
            include $filename;
        }
    }

    function eventfinishCoreBoot()
    {
        if (file_exists($filename = ICMS_ROOT_PATH . '/modules/defacer/include/beforeheader.php')) {
            include $filename;
        }
    }

}
?>
