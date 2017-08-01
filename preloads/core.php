<?php
/**
 * Defacer
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Defacer
 * @since           2.4.0
 * @author          trabis <lusopoemas@gmail.com>
 */

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Profile core preloads
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 */
class DefacerCorePreload extends XoopsPreloadItem
{
    public static function eventCoreHeaderStart($args)
    {
            if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/defacer/include/beforeheader.php')) {
                include $filename;
            }
    }

    public static function eventCoreFooterStart($args)
    {
            if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/defacer/include/beforefooter.php')) {
                include $filename;
            }
    }

    public static function eventCoreHeaderAddmeta($args)
    {
        if (DefacerCorePreload::isRedirectActive()) {
            if (!empty($_SESSION['redirect_message'])) {
                global $xoTheme;
                $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
                $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.jgrowl.js');
                $xoTheme->addStylesheet('modules/defacer/assets/js/jquery.jgrowl.css', array('media' => 'screen'));

                $xoTheme->addScript('', null, '
                    (function($){
                        $(document).ready(function(){
                            $.jGrowl("' . $_SESSION['redirect_message'] . '", {position:"center"});
                        });
                    })(jQuery);
                ');
                //{ life:5000 , position:\'bottom-left\', speed:\'slow\' }
                unset($_SESSION['redirect_message']);
            }
        }
    }

    public static function eventSystemClassGuiHeader($args)
    {
        DefacerCorePreload:: eventCoreHeaderAddmeta($args);
    }

    public function eventCoreIncludeFunctionsRedirectheader($args)
    {
        if (DefacerCorePreload::isRedirectActive() && !headers_sent()) {
            global $xoopsConfig;
            if (!empty($_SERVER['REQUEST_URI']) && strstr($_SERVER['REQUEST_URI'], 'user.php?op=logout')) {
                unset($_SESSION['redirect_message']);

                return;
            }
            list($url, $time, $message, $addredirect, $allowExternalLink) = $args;

            if (preg_match("/[\\0-\\31]|about:|script:/i", $url)) {
                if (!preg_match('/^\b(java)?script:([\s]*)history\.go\(-[0-9]*\)([\s]*[;]*[\s]*)$/si', $url)) {
                    $url = XOOPS_URL;
                }
            }

            if (!$allowExternalLink && $pos = strpos($url, '://')) {
                $xoopsLocation = substr(XOOPS_URL, strpos(XOOPS_URL, '://') + 3);
                if (strcasecmp(substr($url, $pos + 3, strlen($xoopsLocation)), $xoopsLocation)) {
                    $url = XOOPS_URL;
                }
            }

            if (!empty($_SERVER['REQUEST_URI']) && $addredirect && strstr($url, 'user.php')) {
                if (!strstr($url, '?')) {
                    $url .= '?xoops_redirect=' . urlencode($_SERVER['REQUEST_URI']);
                } else {
                    $url .= '&amp;xoops_redirect=' . urlencode($_SERVER['REQUEST_URI']);
                }
            }

            if (defined('SID') && SID
                && (!isset($_COOKIE[session_name()])
                    || ($xoopsConfig['use_mysession']
                        && $xoopsConfig['session_name'] != ''
                        && !isset($_COOKIE[$xoopsConfig['session_name']])))) {
                if (!strstr($url, '?')) {
                    $url .= '?' . SID;
                } else {
                    $url .= '&amp;' . SID;
                }
            }

            $url                          = preg_replace('/&amp;/i', '&', htmlspecialchars($url, ENT_QUOTES));
            $message                      = trim($message) != '' ? $message : _TAKINGBACK;
            $_SESSION['redirect_message'] = $message;
            header('Location: ' . $url);
            exit();
        }
    }

    public static function eventCoreClassTheme_blocksRetrieveBlocks($args)
    {
            //$args[2] = array();
            $class     =& $args[0];
            $template  =& $args[1];
            $block_arr =& $args[2];

            foreach ($block_arr as $key => $xobject) {
                if (strpos($xobject->getVar('title'), '_') !== 0) {
                    continue;
                }

                $block = array(
                    'id'      => $xobject->getVar('bid'),
                    'module'  => $xobject->getVar('dirname'),
                    'title'   => ltrim($xobject->getVar('title'), '_'),
                    'weight'  => $xobject->getVar('weight'),
                    'lastmod' => $xobject->getVar('last_modified')
                );

                $bcachetime = (int)$xobject->getVar('bcachetime');
                if (empty($bcachetime)) {
                    $template->caching = 0;
                } else {
                    $template->caching        = 2;
                    $template->cache_lifetime = $bcachetime;
                }
                $template->setCompileId($xobject->getVar('dirname', 'n'));
                $tplName = ($tplName = $xobject->getVar('template')) ? "db:$tplName" : 'db:system_block_dummy.tpl';
                $cacheid = $class->generateCacheId('blk_' . $xobject->getVar('bid'));

                $xoopsLogger = XoopsLogger::getInstance();
                if (!$bcachetime || !$template->is_cached($tplName, $cacheid)) {
                    $xoopsLogger->addBlock($xobject->getVar('name'));
                    if ($bresult = $xobject->buildBlock()) {
                        $template->assign('block', $bresult);
                        $block['content'] = $template->fetch($tplName, $cacheid);
                    } else {
                        $block = false;
                    }
                } else {
                    $xoopsLogger->addBlock($xobject->getVar('name'), true, $bcachetime);
                    $block['content'] = $template->fetch($tplName, $cacheid);
                }
                $template->setCompileId();
                $template->assign("xoops_block_{$block['id']}", $block);
                unset($block_arr[$key]);
            }
    }

    public static function isRedirectActive()
    {
        require_once __DIR__ . '/../include/common.php';
        $defacer = DefacerDefacer::getInstance();

        return $defacer->getConfig('enable_redirect');
    }
}
