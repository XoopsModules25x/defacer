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
 * @author          InstantZero <http://xoops.instant-zero.com/>
 * @version         $Id: admin_header.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function defacer_adminMenu($currentoption = 0, $breadcrumb = '')
{
    $defacer =& DefacerDefacer::getInstance();
    /* Nice buttons styles */
    echo "
    <style type='text/css'>
    #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/" . $defacer->getModule()->dirname() . "/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
    #buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
    #buttonbar li { display:inline; margin:0; padding:0; }
    #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/" . $defacer->getModule()->dirname() . "/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
    #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/" . $defacer->getModule()->dirname() . "/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #buttonbar a span {float:none;}
    /* End IE5-Mac hack */
    #buttonbar a:hover span { color:#333; }
    #buttonbar #current a { background-position:0 -150px; border-width:0; }
    #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
    #buttonbar a:hover { background-position:0% -150px; }
    #buttonbar a:hover span { background-position:100% -150px; }
    </style>
    ";

    $tblColors = array('', '', '', '', '');
    if($currentoption >= 0) {
        $tblColors[$currentoption] = 'current';
    }

    if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/' . $defacer->getModule()->dirname() . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php')) {
        include_once $filename;
    } else {
        include_once XOOPS_ROOT_PATH . '/modules/' . $defacer->getModule()->dirname() . '/language/english/modinfo.php';
    }

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $defacer->getModule()->mid() . "\">" . _AM_DEFACER_GENERALSET . "</a>";
    echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $defacer->getModule()->name() . "  " . _AM_DEFACER_MODULEADMIN . "</b> " . $breadcrumb . "</td>";
    echo "</tr></table>";
    echo "</div>";

    echo "<div id='buttonbar'>";
    echo "<ul>";
    echo "<li id='" . $tblColors[0] . "'><a href=\"admin_page.php\"\"><span>" . _MI_DEFACER_PAGEMANAGER . "</span></a></li>\n";
    echo "<li id='" . $tblColors[1] . "'><a href=\"admin_theme.php\"\"><span>" . _MI_DEFACER_THEMEMANAGER . "</span></a></li>\n";
    echo "<li id='" . $tblColors[2] . "'><a href=\"admin_meta.php\"\"><span>" . _MI_DEFACER_METAMANAGER . "</span></a></li>\n";
    echo "<li id='" . $tblColors[3] . "'><a href=\"admin_permission.php\"\"><span>" . _MI_DEFACER_PERMISSIONMANAGER . "</span></a></li>\n";
    echo "<li id='" . $tblColors[4] . "'><a href=\"admin_about.php\"\"><span>" . _MI_DEFACER_ABOUT . "</span></a></li>\n";
    echo "</ul></div><div>&nbsp;</div>";
}
?>