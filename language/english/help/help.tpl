<div id="help-template" class="outer">
    <{include file=$smarty.const._MI_DEFACER_HELP_HEADER}>

    <h4 class="odd">DESCRIPTION</h4> <br>

    <p>Defacer is a new revolutionary XOOPS module that allows you to change themes, metadata and
        permissions for any given page on the XOOPS-based Website, thus giving you a level of control and customization
        not seen before. </p>

    <p>It also comes with jgrowl redirection system and the ability of using blocks anywhere in your theme and
        templates </p><br>

    <p>
        With this Xoops module, you can:
    <ul>
        <li>change themes, metadata and permissions for any given page.</li>
        <li>enable jgrowl redirection system</li>
        <li>use blocks anywhere</li>
    </ul>
    </p>

    <h4 class="odd">INSTALL/UNINSTALL</h4>

    <p class="even">Copy Defacer folder into the /modules directory of your website.
        Then log in to your site as administrator, go to System Admin > Modules, look for the defacer
        icon in the list of uninstalled modules and click in the install icon.
        Follow the directions in the screen.<br> <br>
        Detailed instructions on installing modules are available in the
        <a href="https://xoops.gitbook.io/xoops-operations-guide/" target="_blank">XOOPS Operations Manual</a>
    </p>


    <h4 class="odd">OPERATING INSTRUCTIONS</h4>

    <p class="even">
        When creating pages you can use '*' symbol in the url field to match any url.

        You should use relative paths
        If you select news module your path will be related to yoursite/module/news/
        You should add for example
        index.php and not modules/news/index.php<br> <br>

        System module is relative to root
        You can select system module and enter this url to cover all userinfo pages:
        userinfo.php*<br> <br>

        Tips for blocks anywhere (xoops 2.4 only)<br>
        =========<br> <br>
        Just prefix your block title with an underscore and you will be able to use it
        has a smarty variable inside your theme or template <br>
        Example: <br>
        -Edit User menu block and rename it to _User Menu <br>
        -Take notice of the "bid" in the url, in this case it is '1':
        modules/system/admin.php?fct=blocksadmin&op=edit&bid=1 <br>
        -Usage on theme/template: <br>
        < {$xoops_block_1.title} > --> echos User Menu <br>
        < {$xoops_block_1.content} > --> echos the block content

    </p>

    <h4 class="odd">Limitations</h4>

    <p class="even">
        The block for changing themes is deactivated when using Defacer Theme Changer.

    </p>

    <h4 class="odd">TUTORIAL</h4>

    <p class="even">
        Currently no tutorial is available.

    </p>


</div>
