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
 * @version         $Id: defacer.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

/**
 * Class DefacerDefacer
 */
class DefacerDefacer
{
    var $dirname;
    var $module;
    var $handler;
    var $config;
    var $debug;
    var $debugArray = array();

    /**
     * @param $debug
     */
    function DefacerDefacer($debug)
    {
        $this->debug = $debug;
        $this->dirname = basename(dirname(dirname(__FILE__)));
    }

    /**
     * @param bool $debug
     *
     * @return DefacerDefacer
     */
    static function &getInstance($debug = false)
    {
        static $instance = false;
        if (!$instance) {
            $instance = new DefacerDefacer($debug);
        }

        return $instance;
    }

    function &getModule()
    {
        if ($this->module == null) {
            $this->initModule();
        }

        return $this->module;
    }

    /**
     * @param null $name
     *
     * @return null
     */
    function getConfig($name = null)
    {
        if ($this->config == null) {
            $this->initConfig();
        }
        if (!$name) {
            $this->addLog("Getting all config");

            return $this->config;
        }

        if (!isset($this->config[$name])) {
            $this->addLog("ERROR :: Config '{$name}' does not exist");

            return null;
        }

        $this->addLog("Getting config '{$name}' : " .$this->config[$name]);

        return $this->config[$name];
    }

    /**
     * @param null $name
     * @param null $value
     *
     * @return mixed
     */
    function setConfig($name = null, $value = null)
    {
        if ($this->config == null) {
            $this->initConfig();
        }

        $this->config[$name] = $value;

        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    function &getHandler($name)
    {
        $ret = false;
        if (!isset($this->handler[$name . '_handler'])) {
            $this->initHandler($name);
        }

        if (!isset($this->handler[$name . '_handler'])) {
            $this->addLog("ERROR :: Handler '{$name}' does not exist");
        } else {
            $this->addLog("Getting handler '{$name}'");
            $ret = $this->handler[$name . '_handler'];
        }

        return $ret;
    }

    function initModule()
    {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            $this->module =& $xoopsModule;
        } else {
            $hModule =& xoops_gethandler('module');
            $this->module =& $hModule->getByDirname($this->dirname);
        }
        $this->addLog('INIT MODULE');
    }

    function initConfig()
    {
        $this->addLog('INIT CONFIG');
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            global $xoopsModuleConfig;
            $this->config =& $xoopsModuleConfig;
        } else {
            $hModConfig =& xoops_gethandler('config');
            $this->config =& $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
        }
    }

    /**
     * @param $name
     */
    function initHandler($name)
    {
        $this->addLog('INIT ' . $name . ' HANDLER');
        $this->handler[$name . '_handler'] =& xoops_getModuleHandler($name, $this->dirname);
    }

    /**
     * @param $log
     */
    function addLog($log)
    {
        if ($this->debug) {
            if (is_object($GLOBALS['xoopsLogger'])) {
                $GLOBALS['xoopsLogger']->addExtra(is_object($this->module) ? $this->module->name() : $this->dirname, $log);
            }
        }
    }
}
