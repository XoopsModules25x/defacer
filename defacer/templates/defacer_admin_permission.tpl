<script type="text/javascript">
function defacer_showDiv(type, id){
	divs = document.getElementsByTagName('div');
	for (i=0; i<divs.length;i++){
		if (/opt_divs/.test(divs[i].className)){
			divs[i].style.display = 'none';
		}
	}
	if (!id)id = '';
	document.getElementById(type+id).style.display = 'block';
	document.anchors.item(type+id).scrollIntoView();
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
  <{$smarty.const._AM_DEFACER_PERMISSIONMAN}>
</div>
<br />
-->
<br style="clear: right; line-height:1px;" />
  <table width="100%" cellspacing="1" cellpadding="0" class="outer">
    <tr align="center">
      <th width="5%"><{$smarty.const._AM_DEFACER_ID}></th>
      <th><{$smarty.const._AM_DEFACER_MODULE}></th>
      <th><{$smarty.const._AM_DEFACER_PAGE}></th>
      <th><{$smarty.const._AM_DEFACER_PERMISSION_GROUPS}></th>
      <th width="15%"><{$smarty.const._OPTIONS}></th>
    </tr>
    <{if $count > 0}>
    <{foreach item=item key=key from=$items}>
      <tr class="<{cycle values="even,odd"}>" align="center">
        <td><{$item.permission_id}></td>
        <td align="left"><{$item.module}></td>
        <td align="left"><{$item.permission_title}></td> <!-- -<{$item.module}>-<{$item.permission_url}> -->
        <td align="left">
        <{foreach item=groupid from=$item.permission_groups name=grouploop}>
            <{$groups[$groupid]}><{if !$smarty.foreach.grouploop.last}>, <{/if}>
        <{/foreach}>
        </td>
        <td>
          <{if $item.permission_vurl != '0'}>
            <a href="<{$item.permission_vurl}>" rel="external"><img src="<{xoModuleIcons16 search.png}>" title="<{$smarty.const._PREVIEW}>" alt="<{$smarty.const._PREVIEW}>" /></a>
          <{else}>
            <img src="<{$xoops_url}>/modules/defacer/assets/images/view_big_off.png" title="<{$smarty.const._PREVIEW}>" alt="<{$smarty.const._PREVIEW}>" />
          <{/if}>
      	  <a href="admin_permission.php?op=edit&itemid=<{$item.permission_id}>"><img src="<{xoModuleIcons16 edit.png}>" title="<{$smarty.const._EDIT}>" alt="<{$smarty.const._EDIT}>" /></a>
      	  <a href="admin_permission.php?op=del&itemid=<{$item.permission_id}>"><img src="<{xoModuleIcons16 delete.png}>" title="<{$smarty.const._DELETE}>" alt="<{$smarty.const._DELETE}>" /></a>
        </td>
      </tr>
    <{/foreach}>
    <{else}>
      <tr><td class="head" colspan="5" align="center"><{$smarty.const._AM_DEFACER_NOTFOUND}></td></tr>
    <{/if}>
    <tr>
      <td class="head" colspan="5" align="right">
        <{$pagenav}>
        <input type="button" onclick="defacer_showDiv('form','','hiddendiv'); return false;" value="<{$smarty.const._ADD}>" />
      </td>
   </tr>
  </table>
<br />
<a name="form_anchor"></a>
<div id="form" class="hiddendiv" style="display:none;"><{$form}></div>
