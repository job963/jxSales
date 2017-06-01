[{*debug*}]
[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign box=" "}]

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

    <h1>[{ oxmultilang ident="JXSALES_LATEST_TITLE" }]</h1>
    <form name="transfer" id="transfer" action="[{ $shop->selflink }]" method="post">
        [{ $shop->hiddensid }]
        <input type="hidden" name="oxid" value="[{ $oxid }]">
        <input type="hidden" name="cl" value="article" size="40">
        <input type="hidden" name="updatelist" value="1">
    </form>
        
    <form name="jxsales" id="jxsales" action="[{ $oViewConf->selflink }]" method="post">

    [{assign var="oConfig" value=$oViewConf->getConfig()}]
    
    <div id="liste">
        <table cellspacing="0" cellpadding="0" border="0" width="99%">
        <tr>
            [{ assign var="headStyle" value="border-bottom:1px solid #C8C8C8; font-weight:bold;" }]
            <td class="listfilter first" " style="[{$headStyle}]" height="15" width="30" align="center">
                <div class="r1"><div class="b1">[{ oxmultilang ident="GENERAL_ACTIVTITLE" }]</div></div>
            </td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ORDER_OVERVIEW_PDF_PURCHASENR" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ORDER_LIST_ORDERTIME" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_MAIN_NAME" }] ([{ oxmultilang ident="JXSALES_CUSTNO" }])</div></div></td>
            [{if $oConfig->getConfigParam("bJxSalesDisplayAddress") }]
                <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_MAIN_STRNR" }]</div></div></td>
            [{/if}]
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="USER_LIST_ZIP" }]/[{ oxmultilang ident="USER_LIST_PLACE" }]</div></div></td>
            [{if $oConfig->getConfigParam("bJxSalesDisplayCountry") }]
                <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="GENERAL_COUNTRY" }]</div></div></td>
            [{/if}]
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ORDER_LIST_PAID" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="ORDER_MAIN_PAIDWITH" }]</div></div></td>
            <td class="listfilter" style="[{$headStyle}]"><div class="r1"><div class="b1">[{ oxmultilang ident="JXSALES_TOTALSUM" }]</div></div></td>
        <td class="listfilter" style="[{$headStyle}]" align="center"><div class="r1"><div class="b1"><input type="checkbox" onclick="change_all('jxsales_oxid[]', this)"></div></div></td>
        </tr>

        [{assign var="actArtTitle" value="..." }]
        [{assign var="actArtVar" value="..." }]
        [{foreach name=outer item=aOrder from=$aOrders}]
            <tr>
                [{assign var="listclass" value="listitem2"}]
                <td class="[{$listclass}][{if $aOrder.oxstorno == 0}] active[{/if}]" style="background-color:#dcdcdc;">&nbsp;</td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.orderid}]','admin_order');" title="[{ oxmultilang ident="JXSALES_GOTOORDER" }]">[{$aOrder.oxordernr}]</a></td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.orderid}]','admin_order');" title="[{ oxmultilang ident="JXSALES_GOTOORDER" }]">[{$aOrder.oxorderdate}]</a></td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxbillfname}] [{$aOrder.oxbilllname}] ([{$aOrder.oxcustnr}])</a></td>
                [{if $oConfig->getConfigParam("bJxSalesDisplayAddress") }]
                    <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxbillstreet}] [{$aOrder.oxbillstreetnr}]</a></td>
                [{/if}]
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxbillzip}] [{$aOrder.oxbillcity}]</a></td>
                [{if $oConfig->getConfigParam("bJxSalesDisplayCountry") }]
                    <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxcountry}]</a></td>
                [{/if}]
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxpaid}]</a></td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxpayment}]</a></td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;" align="right"><a href="Javascript:editThis('[{$aOrder.userid}]','admin_user');" title="[{ oxmultilang ident="JXSALES_GOTOUSER" }]">[{$aOrder.oxtotalordersum|string_format:"%.2f"}] [{$aOrder.oxcurrency}]</a></td>
                <td class="[{$listclass}]" style="background-color:#dcdcdc;" align="center"><input type="checkbox" name="jxsales_oxid[]" value="[{$aOrder.orderartid}]"></td>
            </tr>
            <tr>
                <td class="listitem" style="background-color:white;" colspan="2"></td>
                <td class="listitem" style="padding: 0px 5px 0px 5px; background-color:white;" colspan="7">
                        <table style="background-color:white; width:100%; margin: 8px 0px 12px 0px; border-collapse:collapse; border:1px solid gainsboro;">
                            <colgroup>
                                <col style="width:3%;">
                                <col style="width:10%;">
                                <col style="width:20%;">
                                <col style="width:13%;">
                                <col style="width:15%;">
                                <col style="width:7%;">
                                <col style="width:7%;">
                            </colgroup>
                                [{assign var="b1Style" value="font-weight:bold; height:15px;" }]
                                [{assign var="thDetailStyle" value="color:gray; text-align:left; font-weight:bold; background-color:whitesmoke; padding:4px 4px 4px 2px;" }]
                                <tr>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="GENERAL_ACTIVTITLE" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="ARTICLE_MAIN_ARTNUM" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="ARTICLE_MAIN_TITLE" }], [{ oxmultilang ident="JXSALES_VARIANT" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="ARTICLE_FILES_TABLE_FILENAME" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="ORDER_DOWNLOADS_LASTDOWNLOAD" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="ORDER_OVERVIEW_PDF_UNITPRICE" }]</th>
                                    <th style="[{$thDetailStyle}]">[{ oxmultilang ident="JXSALES_ARTSUM" }]</th>
                            </tr>
                                [{assign var="oldartnum" value="---" }]
                                [{assign var="tdDetailStyle" value="border:none; background-color:white; padding:4px 2px 4px 2px;font-weight:normal;" }]
                                [{foreach name=inner item=aArticle from=$aOrder.details}]
                                    [{cycle values="listitem,listitem2" assign="innerlistclass" }]
                                    <tr>
                                        <td class="[{$innerlistclass}][{if $aArticle.oxactive == 1 AND $oldartnum != $aArticle.oxartnum}] active[{/if}]" style="[{$tdDetailStyle}]}">&nbsp;</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]">[{if $oldartnum != $aArticle.oxartnum}][{$aArticle.oxartnum}][{/if}]</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]">[{if $oldartnum != $aArticle.oxartnum}][{$aArticle.oxtitle}][{if $aArticle.oxselvariant!=""}][{$aArticle.oxselvariant}][{/if}][{/if}]</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]">[{$aArticle.oxfilename}]</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]">[{if $aArticle.oxfilename != ""}][{$aArticle.oxdownloadcount}] x, [{$aArticle.oxlastdownload}][{/if}]</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]" >[{if $oldartnum != $aArticle.oxartnum}][{$aArticle.oxamount}] x [{$aArticle.oxbprice|string_format:"%.2f"}][{/if}]</td>
                                        <td class="[{$innerlistclass}]" style="[{$tdDetailStyle}]" >[{if $oldartnum != $aArticle.oxartnum}][{$aArticle.oxbrutprice|string_format:"%.2f"}][{/if}]</td>
                                </tr>
                                [{assign var="oldartnum" value=$aArticle.oxartnum }]
                        [{/foreach}]
                    </table>
                </td>
                <td class="listitem" style="background-color:white;" colspan="3"></td>
                        
            </tr>
        [{/foreach}]

        </table>
    </div>
</form>
