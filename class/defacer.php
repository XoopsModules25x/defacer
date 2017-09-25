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
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

class DefacerDefacer
{
    public $dirname;
    public $module;
    public $handler;
    public $config;
    public $debug;
    public $debugArray = [];

    public function __construct($debug)
    {
        $this->debug   = $debug;
        $this->dirname = basename(dirname(__DIR__));
    }

    public static function getInstance($debug = false)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($debug);
        }

        return $instance;
    }

    public function getModule()
    {
        if (null == $this->module) {
            $this->initModule();
        }

        return $this->module;
    }

    public function getConfig($name = null)
    {
        if (null == $this->config) {
            $this->initConfig();
        }
        if (!$name) {
            $this->addLog('Getting all config');

            return $this->config;
        }

        if (!isset($this->config[$name])) {
            $this->addLog("ERROR :: Config '{$name}' does not exist");

            return null;
        }

        $this->addLog("Getting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    public function setConfig($name = null, $value = null)
    {
        if (null == $this->config) {
            $this->initConfig();
        }

        $this->config[$name] = $value;

        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);

        return $this->config[$name];
    }

    public function getHandler($name)
    {
        $ret = false;
        if (!isset($this->handler[$name . 'Handler'])) {
            $this->initHandler($name);
        }

        if (!isset($this->handler[$name . 'Handler'])) {
            $this->addLog("ERROR :: Handler '{$name}' does not exist");
        } else {
            $this->addLog("Getting handler '{$name}'");
            $ret = $this->handler[$name . 'Handler'];
        }

        return $ret;
    }

    public function initModule()
    {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            $this->module = $xoopsModule;
        } else {
            $hModule      = xoops_getHandler('module');
            $this->module = $hModule->getByDirname($this->dirname);
        }
        $this->addLog('INIT MODULE');
    }

    public function initConfig()
    {
        $this->addLog('INIT CONFIG');
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            global $xoopsModuleConfig;
            $this->config = $xoopsModuleConfig;
        } else {
            $hModConfig   = xoops_getHandler('config');
            $this->config =& $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
        }
    }

    public function initHandler($name)
    {
        $this->addLog('INIT ' . $name . ' HANDLER');
        $this->handler[$name . 'Handler'] = xoops_getModuleHandler($name, $this->dirname);
    }

    public function addLog($log)
    {
        if ($this->debug) {
            if (is_object($GLOBALS['xoopsLogger'])) {
                $GLOBALS['xoopsLogger']->addExtra(is_object($this->module) ? $this->module->name() : $this->dirname, $log);
            }
        }
    }
}
