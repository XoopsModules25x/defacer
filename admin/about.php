<?php

/**
 * Defacer module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright    The XOOPS Project (https://xoops.org)
 * @license      GNU GPL (https://www.gnu.org/licenses/gpl-2.0.html/)
 * @package      Defacer
 * @since        2.5.0
 * @author       trabis <lusopoemas@gmail.com>
 */
use Xmf\Module\Admin;
/** @var Admin $adminObject */

require __DIR__ . '/admin_header.php';
xoops_cp_header();

$adminObject->displayNavigation(basename(__FILE__));
$adminObject::setPaypal('xoopsfoundation@gmail.com');
$adminObject->displayAbout(false);

require_once __DIR__ . '/admin_footer.php';
