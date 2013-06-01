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

function editThis( sID )
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
    oTransfer.cl.value='article';
    oTransfer.submit();
}
</script>

<div class="center">
    <h1>[{ oxmultilang ident="JXSALES_TITLE" }]</h1>
    <p>
        <form name="jxsales" id="jxsales_srcval" action="[{ $oViewConf->selflink }]" method="post">
        [{ $oViewConf->hiddensid }]
        <input type="hidden" name="cl" value="jxsales">
        <input type="hidden" name="oxid" value="[{ $oxid }]">
        <table width="80%"><tr>
        <td align="left">
            <label>Suchbegriff:</label> <input type="text" name="jxsales_srcval" value="[{ $jxsales_srcval }]">
            <input type="submit" value=" [{ oxmultilang ident="ORDER_MAIN_UPDATE_DELPAY" }] " />
        </td>
        <td align="right">
            [{*<input type="submit" value=" [{ oxmultilang ident="ORDER_MAIN_UPDATE_DELPAY" }] " />*}]
        </td>
        </tr></table>
        </form>
    </p>
    <p>
        <form name="transfer" id="transfer" action="[{ $shop->selflink }]" method="post">
            [{ $shop->hiddensid }]
            <input type="hidden" name="oxid" value="[{ $oxid }]">
            <input type="hidden" name="cl" value="article" size="40">
            <input type="hidden" name="updatelist" value="1">
        </form>
        
        <table width="100%">
        <thead><tr bgcolor="#dddddd">
            <th align="left">[{ oxmultilang ident="ARTICLE_MAIN_ARTNUM" }]</th>
            <th align="left">[{ oxmultilang ident="ARTICLE_MAIN_TITLE" }]</th>
            <th align="left">[{ oxmultilang ident="JXSALES_VARIANT" }]</th>
            <th align="left">[{ oxmultilang ident="ARTICLE_MAIN_EAN" }]</th>
            <th align="left">[{ oxmultilang ident="GENERAL_DATE" }]</th>
            <th align="left">[{ oxmultilang ident="USER_MAIN_NAME" }] ([{ oxmultilang ident="JXSALES_CUSTNO" }])</th>
            <th align="left">[{ oxmultilang ident="USER_MAIN_STRNR" }]</th>
            <th align="left">[{ oxmultilang ident="USER_LIST_ZIP" }]/[{ oxmultilang ident="USER_LIST_PLACE" }]</th>
            <th align="left">[{ oxmultilang ident="GENERAL_COUNTRY" }]</th>
        </tr></thead>

        <tbody>
        [{ assign var="actArtTitle" value="..." }]
        [{ assign var="actArtVar" value="..." }]
        [{foreach name=outer item=Order from=$aOrders}]
            <tr bgcolor="[{cycle values="#ffffff,#f0f0f0"}]">
                [{ if $actArtTitle != $Order.oxtitle }]
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxartnum}]</a></td>
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxtitle}]</a></td>
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxselvariant}]</a></td>
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxean}]</a></td>
                    [{ assign var="actArtTitle" value=$Order.oxtitle }]
                    [{ assign var="actArtVar" value=$Order.oxselvariant }]
                [{ elseif $actArtVar != $Order.oxselvariant }]
                    <td> </td>
                    <td> </td>
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxselvariant}]</a></td>
                    <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxean}]</a></td>
                    [{ assign var="actArtVar" value=$Order.oxselvariant }]
                [{ else }]
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                [{/if}]
                <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxorderdate}]</a></td>
                <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxbillfname}] [{$Order.oxbilllname}] ([{$Order.oxcustnr}])</a></td>
                <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxbillstreet}] [{$Order.oxbillstreetnr}]</a></td>
                <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxbillzip}] [{$Order.oxbillcity}]</a></td>
                <td><a href="Javascript:editThis('[{$Order.oxid}]');">[{$Order.oxcountry}]</a></td>
            </tr>
        [{/foreach}]
        </tbody>

        </table>
    </p>

</div>
