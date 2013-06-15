[{*debug*}]
[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box=" "}]

[{*<script type="text/javascript" src="[{$shop->basetpldir}]sortable/sortable.js"></script>
<link rel="stylesheet" type="text/css" href="[{$shop->basetpldir}]sortable/sortable.css" />
<script type="text/javascript">image_path = "[{$shop->basetpldir}]sortable/";</script>*}]

<script type="text/javascript">
  if(top)
  {
    top.sMenuItem    = "[{ oxmultilang ident="mxorders" }]";
    top.sMenuSubItem = "[{ oxmultilang ident="jxsales_menu" }]";
    top.sWorkArea    = "[{$_act}]";
    top.setTitle();
  }

function editThis( sID, sClass )
{
    [{assign var="shMen" value=1}]

    [{foreach from=$menustructure item=menuholder }]
      [{if $shMen && $menuholder->nodeType == XML_ELEMENT_NODE && $menuholder->childNodes->length }]

        [{assign var="shMen" value=0}]
        [{assign var="mn" value=1}]

        [{foreach from=$menuholder->childNodes item=menuitem }]
          [{if $menuitem->nodeType == XML_ELEMENT_NODE && $menuitem->childNodes->length }]
            [{ if $menuitem->getAttribute('id') == 'mxorders' }]

              [{foreach from=$menuitem->childNodes item=submenuitem }]
                [{if $submenuitem->nodeType == XML_ELEMENT_NODE && $submenuitem->getAttribute('cl') == 'admin_order' }]

                    if ( top && top.navigation && top.navigation.adminnav ) {
                        var _sbli = top.navigation.adminnav.document.getElementById( 'nav-1-[{$mn}]-1' );
                        var _sba = _sbli.getElementsByTagName( 'a' );
                        top.navigation.adminnav._navAct( _sba[0] );
                    }

                [{/if}]
              [{/foreach}]

            [{ /if }]
            [{assign var="mn" value=$mn+1}]

          [{/if}]
        [{/foreach}]
      [{/if}]
    [{/foreach}]

    var oTransfer = document.getElementById("transfer");
    oTransfer.oxid.value=sID;
    oTransfer.cl.value=sClass; /*'article';*/
    oTransfer.submit();
}

function change_all( name, elem )
{
    if(!elem || !elem.form) 
        return alert("Check Parameters");

    var chkbox = elem.form.elements[name];
    if (!chkbox) 
        return alert(name + " doesn't exist!");

    if (!chkbox.length) 
        chkbox.checked = elem.checked; 
    else 
        for(var i = 0; i < chkbox.length; i++)
            chkbox[i].checked = elem.checked;
}

</script>

[{*<div class="center">*}]
    <h1>[{ oxmultilang ident="JXSALES_TITLE" }]</h1>
    <form name="transfer" id="transfer" action="[{ $shop->selflink }]" method="post">
        [{ $shop->hiddensid }]
        <input type="hidden" name="oxid" value="[{ $oxid }]">
        <input type="hidden" name="cl" value="article" size="40">
        <input type="hidden" name="updatelist" value="1">
    </form>
        
<form name="jxsales" id="jxsales" action="[{ $oViewConf->selflink }]" method="post">
    <p>
        [{ $oViewConf->hiddensid }]
        <input type="hidden" name="cl" value="jxsales">
        <input type="hidden" name="fnc" value="">
        <input type="hidden" name="oxid" value="[{ $oxid }]">
        <table width="80%"><tr>
        <td align="left">
            <label>Suchbegriff:</label> <input type="text" name="jxsales_srcval" value="[{ $jxsales_srcval }]">
            <input type="submit" 
                onClick="document.forms['jxsales'].elements['fnc'].value = '';" 
                value=" [{ oxmultilang ident="ORDER_MAIN_UPDATE_DELPAY" }] " />
        </td>
        <td align="right">
            [{*<input type="submit" value=" [{ oxmultilang ident="ORDER_MAIN_UPDATE_DELPAY" }] " />*}]
        </td>
        <td>
            <input class="edittext" type="submit" 
                onClick="document.forms['jxsales'].elements['fnc'].value = 'downloadResult';" 
                value=" [{ oxmultilang ident="JXSALES_DOWNLOAD" }] " [{ $readonly }]>
        </td>
        </tr></table>
        [{*</form>*}]
    </p>

    <div id="liste">
        <table cellspacing="0" cellpadding="0" border="0" width="99%">
        <tr>
            [{ assign var="headStyle" value="border-bottom:1px solid #C8C8C8; font-weight:bold;" }]
            <td class="listfilter first" style="[{$headStyle}]" height="15" width="30" align="center">
                <div class="r1"><div class="b1">[{ oxmultilang ident="GENERAL_ACTIVTITLE" }]</div></div>
            </td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ARTICLE_MAIN_ARTNUM" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ARTICLE_MAIN_TITLE" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="JXSALES_VARIANT" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ARTICLE_MAIN_EAN" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="GENERAL_DATE" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_MAIN_NAME" }] ([{ oxmultilang ident="JXSALES_CUSTNO" }])</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_MAIN_STRNR" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_LIST_ZIP" }]/[{ oxmultilang ident="USER_LIST_PLACE" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="GENERAL_COUNTRY" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]" align="center"><div class="r1"><div class="b1"><input type="checkbox" onclick="change_all('jxsales_oxid[]', this)"></div></div></td>
        </tr>

        [{*<tbody>*}]
        [{ assign var="actArtTitle" value="..." }]
        [{ assign var="actArtVar" value="..." }]
        [{foreach name=outer item=Order from=$aOrders}]
            <tr>
                [{ cycle values="listitem,listitem2" assign="listclass" }]
                [{ if $actArtTitle != $Order.oxtitle }]
                    <td valign="top" class="[{$listclass}][{ if $Order.oxactive == 1}] active[{/if}]" height="15">
                        <div class="listitemfloating">&nbsp</a></div>
                    </td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxartnum}]</a></td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxtitle}]</a></td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxselvariant}]</a></td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxean}]</a></td>
                    [{ assign var="actArtTitle" value=$Order.oxtitle }]
                    [{ assign var="actArtVar" value=$Order.oxselvariant }]
                [{ elseif $actArtVar != $Order.oxselvariant }]
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxselvariant}]</a></td>
                    <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.artid}]','article');" title="[{ oxmultilang ident="JXSALES_GOTOPRODUCT" }]">[{$Order.oxean}]</a></td>
                    [{ assign var="actArtVar" value=$Order.oxselvariant }]
                [{ else }]
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                    <td class="[{$listclass}]"> </td>
                [{/if}]
                <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.orderid}]','admin_order');" title="[{ oxmultilang ident="JXSALES_GOTOORDER" }]">[{$Order.oxorderdate}]</a></td>
                <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$Order.oxbillfname}] [{$Order.oxbilllname}] ([{$Order.oxcustnr}])</a></td>
                <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$Order.oxbillstreet}] [{$Order.oxbillstreetnr}]</a></td>
                <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$Order.oxbillzip}] [{$Order.oxbillcity}]</a></td>
                <td class="[{$listclass}]"><a href="Javascript:editThis('[{$Order.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$Order.oxcountry}]</a></td>
                <td class="[{$listclass}]" align="center"><input type="checkbox" name="jxsales_oxid[]" value="[{$Order.orderartid}]"></td>
            </tr>
        [{/foreach}]
        [{*</tbody>*}]

        </table>
    </div>
</form>
[{*</div>*}]
