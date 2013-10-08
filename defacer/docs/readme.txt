What is Defacer Module (v1.0 Final)
======================

With this Xoops module, you can:
- change themes, metadata and permissions for any given page.
- enable jgrowl redirection system
- use blocks anywhere


Requirements
====================

- XOOPS >= 2.5.0
- PHP version >= 5.2.0
- ModuleClasses in /Frameworks (download it from here: http://goo.gl/Bmknt)


How to install Defacer
====================

Copy defacer folder into the /modules directory of your website. 
Then log in to your site as administrator, go to System Admin > Modules, look for the defacer
icon in the list of uninstalled modules and click in the install icon. 
Follow the directions in the screen.


ATENTION, if you are NOT using xoops 2.4 or impressCms 1.1 
you have to add a line in header.php and footer.php at the root of your instalation

In yoursite/header.php paste the line 

@include_once XOOPS_ROOT_PATH . '/modules/defacer/include/beforeheader.php';

right after

defined("XOOPS_ROOT_PATH") or die( 'XOOPS root path not defined' );

In yoursite/footer.php paste the line

@include_once XOOPS_ROOT_PATH . '/modules/defacer/include/beforefooter.php';

right after

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}



Tips
=======
When creating pages you can use '*' symbol in the url field to match any url.

You should use relative paths
If you select news module your path will be related to yoursite/module/news/ 
You should add for example
index.php and not modules/news/index.php

System module is relative to root
You can select system module and enter this url to cover all userinfo pages:
userinfo.php*

Tips for blocks anywhere (xoops 2.4 only)
=========
Just prefix your block title with an underscore and you will be able to use it 
has a smarty variable inside your theme or template
Example:
-Edit User menu block and rename it to _User Menu
-Take notice of the "bid" in the url, in this case it is '1':
    modules/system/admin.php?fct=blocksadmin&op=edit&bid=1
-Usage on theme/template:
<{$xoops_block_1.title}> --> echos User Menu
<{$xoops_block_1.content}> --> echos the block content

Limitations
========

The block for changing themes is deactivated when using Defacer Theme Changer.



Feedback
========

Please use http://www.xuups.com (xoops user utilities)