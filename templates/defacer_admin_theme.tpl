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
<div style="background-image: url(<{$xoops_url}>/modules/defacer/images/pages_big.png);
            background-repeat: no-repeat;
            background-position: left top;
            font-size: 20px;
            color: #1E90FF;
            font-weight: bold;
            height: 40px;
            vertical-align: middle;
            padding: 10px 0 0 50px;
            border-bottom: 3px solid #1E90FF;">
  <{$smarty.const._AM_DEFACER_THEMEMAN}>
</div>
<br>
-->
<br style="clear: right; line-height:1px;"/>
<table width="100%" cellspacing="1" cellpadding="0" class="outer">
    <tr align="center">
        <th width="5%"><{$smarty.const._AM_DEFACER_ID}></th>
        <th><{$smarty.const._AM_DEFACER_MODULE}></th>
        <th><{$smarty.const._AM_DEFACER_PAGE}></th>
        <th><{$smarty.const._AM_DEFACER_THEME}></th>
        <th width="15%"><{$smarty.const._OPTIONS}></th>
    </tr>
    <{if $count > 0}>
        <{foreach item=item key=key from=$items}>
            <tr class="<{cycle values="even,odd"}>" align="center">
                <td><{$item.theme_id}></td>
                <td align="left"><{$item.module}></td>
                <td align="left"><{$item.theme_title}></td> <!-- -<{$item.module}>-<{$item.theme_url}> -->
                <td><{$item.theme_name}></td>
                <td>
                    <{if $item.theme_vurl != '0'}>
                        <a href="<{$item.theme_vurl}>" rel="external"><img
                                    src="<{$xoops_url}>/modules/defacer/images/view_big.png"
                                    title="<{$smarty.const._PREVIEW}>"
                                    alt="<{$smarty.const._PREVIEW}>"/></a>
                    <{else}>
                        <img src="<{$xoops_url}>/modules/defacer/images/view_big_off.png"
                             title="<{$smarty.const._PREVIEW}>" alt="<{$smarty.const._PREVIEW}>"/>
                    <{/if}>
                    <a href="admin_theme.php?op=edit&itemid=<{$item.theme_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/images/edit_big.png" title="<{$smarty.const._EDIT}>"
                                alt="<{$smarty.const._EDIT}>"/></a>
                    <a href="admin_theme.php?op=del&itemid=<{$item.theme_id}>"><img
                                src="<{$xoops_url}>/modules/defacer/images/delete_big.png"
                                title="<{$smarty.const._DELETE}>"
                                alt="<{$smarty.const._DELETE}>"/></a>
                </td>
            </tr>
        <{/foreach}>
    <{else}>
        <tr>
            <td class="head" colspan="5" align="center"><{$smarty.const._AM_DEFACER_NOTFOUND}></td>
        </tr>
    <{/if}>
    <tr>
        <td class="head" colspan="5" align="right">
            <{$pagenav}>
            <input type="button" onclick="defacer_showDiv('form','','hiddendiv'); return false;"
                   value="<{$smarty.const._ADD}>"/>
        </td>
    </tr>
</table>
<br>
<a name="form_anchor"></a>
<div id="form" class="hiddendiv" style="display:none;"><{$form}></div>
