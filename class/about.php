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
 * @author          The SmartFactory <www.smartfactory.ca>
 */

defined('XOOPS_ROOT_PATH') || die('XOOPS root path not defined');

/**
 * Class About is a simple class that lets you build an about page
 * @author The SmartFactory <www.smartfactory.ca>
 */
class DefacerAbout
{
    public $_lang_aboutTitle;
    public $_lang_author_info;
    public $_lang_developer_lead;
    public $_lang_developer_contributor;
    public $_lang_developer_website;
    public $_lang_developer_email;
    public $_lang_developer_credits;
    public $_lang_module_info;
    public $_lang_module_status;
    public $_lang_module_release_date;
    public $_lang_module_demo;
    public $_lang_module_support;
    public $_lang_module_bug;
    public $_lang_module_submit_bug;
    public $_lang_module_feature;
    public $_lang_module_submit_feature;
    public $_lang_module_disclaimer;
    public $_lang_author_word;
    public $_lang_version_history;
    public $_lang_by;
    public $_tpl;

    /**
     * @param string $aboutTitle
     */
    public function __construct($aboutTitle = 'About')
    {
        global $xoopsModule, $xoopsConfig;

        $fileName = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/about.php';
        if (file_exists($fileName)) {
            require_once $fileName;
        } else {
            require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/language/english/about.php';
        }
        $this->_aboutTitle = $aboutTitle;

        $this->_lang_developer_contributor = _AB_DEFACER_DEVELOPER_CONTRIBUTOR;
        $this->_lang_developer_website     = _AB_DEFACER_DEVELOPER_WEBSITE;
        $this->_lang_developer_email       = _AB_DEFACER_DEVELOPER_EMAIL;
        $this->_lang_developer_credits     = _AB_DEFACER_DEVELOPER_CREDITS;
        $this->_lang_module_info           = _AB_DEFACER_MODULE_INFO;
        $this->_lang_module_status         = _AB_DEFACER_MODULE_STATUS;
        $this->_lang_module_release_date   = _AB_DEFACER_MODULE_RELEASE_DATE;
        $this->_lang_module_demo           = _AB_DEFACER_MODULE_DEMO;
        $this->_lang_module_support        = _AB_DEFACER_MODULE_SUPPORT;
        $this->_lang_module_bug            = _AB_DEFACER_MODULE_BUG;
        $this->_lang_module_submit_bug     = _AB_DEFACER_MODULE_SUBMIT_BUG;
        $this->_lang_module_feature        = _AB_DEFACER_MODULE_FEATURE;
        $this->_lang_module_submit_feature = _AB_DEFACER_MODULE_SUBMIT_FEATURE;
        $this->_lang_module_disclaimer     = _AB_DEFACER_MODULE_DISCLAIMER;
        $this->_lang_author_word           = _AB_DEFACER_AUTHOR_WORD;
        $this->_lang_version_history       = _AB_DEFACER_VERSION_HISTORY;
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function sanitize($value)
    {
        $myts = MyTextSanitizer::getInstance();

        return $myts->displayTarea($value, 1);
    }

    public function render()
    {
        /**
         * @todo move the output to a template
         * @todo make the output XHTML compliant
         */
        $myts = MyTextSanitizer::getInstance();

        global $xoopsModule, $xoopsUser;

        xoops_cp_header();
        defacer_adminMenu(4);

        /** @var XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $versioninfo   = $moduleHandler->get($xoopsModule->getVar('mid'));

        require_once XOOPS_ROOT_PATH . '/class/template.php';

        $this->_tpl = new XoopsTpl();

        $this->_tpl->assign('module_url', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/');
        $this->_tpl->assign('module_image', $versioninfo->getInfo('image'));
        $this->_tpl->assign('module_name', $versioninfo->getInfo('name'));
        $this->_tpl->assign('module_version', $versioninfo->getInfo('version'));
        $this->_tpl->assign('module_status_version', $versioninfo->getInfo('status_version'));

        // Left headings...
        if ('' != $versioninfo->getInfo('author_realname')) {
            $author_name = $versioninfo->getInfo('author') . ' (' . $versioninfo->getInfo('author_realname') . ')';
        } else {
            $author_name = $versioninfo->getInfo('author');
        }
        $this->_tpl->assign('module_author_name', $author_name);

        $this->_tpl->assign('module_license', $versioninfo->getInfo('license'));

        $this->_tpl->assign('module_credits', $versioninfo->getInfo('credits'));

        // Developers Information
        $this->_tpl->assign('module_developer_lead', $versioninfo->getInfo('developer_lead'));
        $this->_tpl->assign('module_developer_contributor', $versioninfo->getInfo('developer_contributor'));
        $this->_tpl->assign('module_developer_website_url', $versioninfo->getInfo('developer_website_url'));
        $this->_tpl->assign('module_developer_website_name', $versioninfo->getInfo('developer_website_name'));
        $this->_tpl->assign('module_developer_email', $versioninfo->getInfo('developer_email'));

        $people = $versioninfo->getInfo('people');

        $people['testers'][] = is_object($xoopsUser) ? $xoopsUser->getVar('uname') : null;
        if ($people) {
            $this->_tpl->assign('module_people_developers', isset($people['developers']) ? array_map([$this, 'sanitize'], $people['developers']) : false);
            $this->_tpl->assign('module_people_testers', isset($people['testers']) ? array_map([$this, 'sanitize'], $people['testers']) : false);
            $this->_tpl->assign('module_people_translaters', isset($people['translaters']) ? array_map([$this, 'sanitize'], $people['translaters']) : false);
            $this->_tpl->assign('module_people_documenters', isset($people['documenters']) ? array_map([$this, 'sanitize'], $people['documenters']) : false);
            $this->_tpl->assign('module_people_other', isset($people['other']) ? array_map([$this, 'sanitize'], $people['other']) : false);
        }
        //$this->_tpl->assign('module_developers', $versioninfo->getInfo('developer_email'));

        // Module Development information
        $this->_tpl->assign('module_date', $versioninfo->getInfo('date'));
        $this->_tpl->assign('module_status', $versioninfo->getInfo('status'));
        $this->_tpl->assign('module_demo_site_url', $versioninfo->getInfo('demo_site_url'));
        $this->_tpl->assign('module_demo_site_name', $versioninfo->getInfo('demo_site_name'));
        $this->_tpl->assign('module_support_site_url', $versioninfo->getInfo('support_site_url'));
        $this->_tpl->assign('module_support_site_name', $versioninfo->getInfo('support_site_name'));
        $this->_tpl->assign('module_submit_bug', $versioninfo->getInfo('submit_bug'));
        $this->_tpl->assign('module_submit_feature', $versioninfo->getInfo('submit_feature'));

        // Warning
        $this->_tpl->assign('module_warning', $this->sanitize($versioninfo->getInfo('warning')));

        // Author's note
        $this->_tpl->assign('module_author_word', $versioninfo->getInfo('author_word'));

        // For changelog thanks to 3Dev
        $filename = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/changelog.txt';
        if (is_file($filename)) {
            $filesize = filesize($filename);
            $handle   = fopen($filename, 'r');
            $this->_tpl->assign('module_version_history', $myts->displayTarea(fread($handle, $filesize), true));
            fclose($handle);
        }

        $this->_tpl->display('db:defacer_admin_about.tpl');

        xoops_cp_footer();
    }
}
