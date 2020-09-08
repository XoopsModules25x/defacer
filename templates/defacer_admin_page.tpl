<script type="text/javascript">
    function defacer_showDiv(type, id) {
        divs = document.getElementsByTagName('div');
        for (i = 0; i < divs.length; i++) {
            if (/opt_divs/.test(divs[i].className)) {
                divs[i].style.display = 'none';
            }
        }
        if (!id)id = '';
        document.getElementById(type + id).style.display = 'block';
        document.anchors.item(type + id).scrollIntoView();
    }
</script>
<!--
<div style="background-image: url(<{$xoops_url}>/modules/defacer/assets/images/pages_big.png);
            background-repeat: no-repeat;
            background-position: left top;
            font-size: 20px;
            color: #1E90FF;
            font-weight: bold;
            height: 40px;
            vertical-align: middle;
            padding: 10px 0 0 50px;
            border-bottom: 3px solid #1E90FF;">
  <{$smarty.const._AM_DEFACER_PAGEMAN}>
</div>
<br>
-->
<div style="margin-top:0; float: right; width:400px;" align="right">
    <form action="admin_page.php?op=list" method="POST">
        <input type="text" name="query" id="query" size="30" value="<{$query}>">
        <input type="submit" name="btn" value="<{$smarty.const._SEARCH}>">
        <input type="submit" name="btn1" value="<{$smarty.const._CANCEL}>"
               onclick="document.getElementById('query').value='';">
    </form>
</div>
<br style="clear: right; line-height:1px;">
<table width="100%" cellspacing="1" cellpadding="0" class="outer">
    <tr align="center">
        <th width="5%"><{$smarty.const._AM_DEFACER_ID}></th>
        <th width="10%"><{$smarty.const._AM_DEFACER_MODULE}></th>
        <th width="20%"><{$smarty.const._AM_DEFACER_PAGE}></th>
        <th width="25%"><{$smarty.const._AM_DEFACER_URL}></th>
        <th width="5%"><{$smarty.const._AM_DEFACER_STATUS}></th>
        <th width="15%"><{$smarty.const._AM_DEFACER_QUICKLAUNCH}></th>
        <th width="15%"><{$smarty.const._OPTIONS}></th>
    </tr>
    <{if $count > 0}>
        <{foreach item=item key=key from=$items}>
            <tr class="<{cycle values="even,odd"}>" align="center">
                <td><{$item.page_id}></td>
                <td align="left"><{$item.name}></td>
                <td align="left"><{$item.page_title}></td>
                <td align="left"><{$item.page_url}></td>
                <td><a href="admin_page.php?op=changestatus&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/<{$item.page_status}>.png"
                                title="<{$smarty.const._AM_DEFACER_CHANGESTATUS}>"
                                alt="<{$smarty.const._AM_DEFACER_CHANGESTATUS}>"></a>
                </td>
                <td>
                    <a href="admin_theme.php?op=edit&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/themes_small.png"
                                title="<{$smarty.const._AM_DEFACER_THEMEMAN}>"
                                alt="<{$smarty.const._AM_DEFACER_THEMEMAN}>"></a>
                    <a href="admin_meta.php?op=edit&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/metas_small.png"
                                title="<{$smarty.const._AM_DEFACER_METAMAN}>"
                                alt="<{$smarty.const._AM_DEFACER_METAMAN}>"></a>
                    <a href="admin_permission.php?op=edit&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/permissions_small.png"
                                title="<{$smarty.const._AM_DEFACER_PERMISSIONMAN}>"
                                alt="<{$smarty.const._AM_DEFACER_PERMISSIONMAN}>"></a>
                </td>
                <td>
                    <{if $item.page_vurl != '0'}>
                        <a href="<{$item.page_vurl}>" rel="external"><img
                                    src="<{$xoops_url}>/modules/defacer/assets/images/view_big.png"
                                    title="<{$smarty.const._PREVIEW}>" alt="<{$smarty.const._PREVIEW}>"></a>
                    <{else}>
                        <img src="<{$xoops_url}>/modules/defacer/assets/images/view_big_off.png"
                             title="<{$smarty.const._PREVIEW}>" alt="<{$smarty.const._PREVIEW}>">
                    <{/if}>
                    <a href="admin_page.php?op=edit&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/edit_big.png" title="<{$smarty.const._EDIT}>"
                                alt="<{$smarty.const._EDIT}>"></a>
                    <a href="admin_page.php?op=del&itemid=<{$item.page_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/assets/images/delete_big.png"
                                title="<{$smarty.const._DELETE}>"
                                alt="<{$smarty.const._DELETE}>"></a>
                </td>
            </tr>
        <{/foreach}>
    <{else}>
        <tr>
            <td class="head" colspan="7" align="center"><{$smarty.const._AM_DEFACER_NOTFOUND}></td>
        </tr>
    <{/if}>
    <tr>
        <td class="head" colspan="7" align="right">
            <{$pagenav|default:false}>
            <input type="button" onclick="defacer_showDiv('form','','hiddendiv'); return false;"
                   value="<{$smarty.const._ADD}>">
        </td>
    </tr>
</table>
<br>
<a name="form_anchor"></a>
<div id="form" class="hiddendiv" style="display:none;"><{$form}></div>
