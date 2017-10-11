[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<script type="text/javascript">
  if(top)
  {
    top.sMenuItem    = "[{ oxmultilang ident="mxuadmin" }]";
    top.sMenuSubItem = "[{ oxmultilang ident="mxusers" }]";
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
    oTransfer.cl.value=sClass; /* 'admin_order' / 'article' */
    oTransfer.submit();
}
</script>

[{if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]


<form name="transfer" id="transfer" action="[{ $shop->selflink }]" method="post">
    [{ $shop->hiddensid }]
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="user_jxsales">
    <input type="hidden" name="editlanguage" value="[{ $editlanguage }]">
</form>

<div id="liste">
    <table cellspacing="0" cellpadding="0" border="0" style="width:100%;">
        <colgroup>
            <col width="2%">
            <col width="5%">
            <col width="5%">
            <col width="8%">
            <col width="8%">
            <col width="6%">
            <col width="6%">
            <col width="7%">
            <col width="15%">
            <col width="5%">
            <col width="5%">
            [{foreach name=AddHeader item=sArticleHead from=$oOrdersList->jxGetAdditionalArticleHeader() }]
                <col width="7%">
            [{/foreach}]
        </colgroup>
        <tr>
            <td class="listheader">[{oxmultilang ident="GENERAL_ACTIVTITLE" }]</td>
            <td class="listheader">[{oxmultilang ident="JXSALES_ORDERNO" }]</td>
            <td class="listheader">[{oxmultilang ident="JXSALES_INVNO" }]</td>
            <td class="listheader">[{oxmultilang ident="ORDER_PACKAGE_ORDERNR2" }]</td>
            <td class="listheader">[{oxmultilang ident="ORDER_MAIN_PAIDWITH" }]</td>
            <td class="listheader">[{oxmultilang ident="ORDER_MAIN_DISCOUNT" }]</td>
            <td class="listheader">[{oxmultilang ident="JXSALES_INVTOTAL" }]</td>
            [{assign var=headStyle value="font-weight:bold;color:gray;" }]
            <td class="listheader" style="[{$headStyle}]">[{oxmultilang ident="ORDER_OVERVIEW_PDF_ARTID" }]</td>
            <td class="listheader" style="[{$headStyle}]">[{oxmultilang ident="ARTICLE_MAIN_TITLE" }]</td>
            <td class="listheader" style="[{$headStyle}]">[{oxmultilang ident="ORDER_OVERVIEW_PDF_AMOUNT" }]</td>
            <td class="listheader" style="[{$headStyle}]">[{oxmultilang ident="JXSALES_ARTSUM" }]</td>
            [{foreach name=AddHeader item=sArticleHead from=$oOrdersList->jxGetAdditionalArticleHeader() }]
                <td class="listheader" style="[{$headStyle}]">[{$sArticleHead[$sIsoLang] }]</td>
            [{/foreach}]
        </tr>
        
        [{assign var=oUserPayments value=$edit->getUserPayments()}]
        
        [{foreach name=orders item=oOrder from=$oOrdersList}]
            [{ cycle values="listitem,listitem2" assign="listclass" }]
            <tr>
                <td valign="top" class="[{ $listclass}][{if $oOrder->oxorder__oxstorno->value == 0}] active[{/if}]" height="15">
                    <div class="listitemfloating">&nbsp</a></div>
                </td>
                <td class="[{ $listclass}]"><a href="Javascript:editThis('[{$oOrder->oxorder__oxid->value}]','admin_order');">[{$oOrder->oxorder__oxordernr->value}]</a></td>
                <td class="[{ $listclass}]">[{$oOrder->oxorder__oxinvoicenr->value}]</td>
                <td class="[{ $listclass}]">[{$oOrder->oxorder__oxorderdate->value|substr:0:10}]</td>
                <td class="[{ $listclass}]">
                    [{foreach item=oPayment from=$oUserPayments}]
                        [{if $oPayment->oxuserpayments__oxid->value == $oOrder->oxorder__oxpaymentid}]
                            [{$oPayment->oxpayments__oxdesc->value }]
                        [{/if}]
                    [{/foreach}]
                </td>
                <td class="[{ $listclass}]">[{$oOrder->oxorder__oxvoucherdiscount->value}]</td>
                <td class="[{ $listclass}]">[{$oOrder->oxorder__oxtotalordersum->value}]</td>
                
                [{assign var=oOrderArticles value=$oOrder->getOrderArticles()}]
                [{assign var=artStyle value="color:gray;" }]
                    
                <td class="[{ $listclass}]">
                    [{foreach item=oOrderArticle from=$oOrderArticles }]
                        <div style="[{$artStyle}]"><a href="Javascript:editThis('[{$oOrderArticle->oxorderarticles__oxartid->value}]','article');" style="[{$artStyle}]">[{$oOrderArticle->oxorderarticles__oxartnum->value}]</a></div>
                    [{/foreach}]
                </td>
                <td class="[{ $listclass}]">
                    [{foreach item=oOrderArticle from=$oOrderArticles }]
                        <div style="[{$artStyle}]">[{$oOrderArticle->oxorderarticles__oxtitle->value}][{if $oOrderArticle->oxorderarticles__oxselvariant->value}], [{$oOrderArticle->oxorderarticles__oxselvariant->value}][{/if}]</div>
                    [{/foreach}]
                </td>
                <td class="[{ $listclass}]">
                    [{foreach item=oOrderArticle from=$oOrderArticles }]
                        <div style="[{$artStyle}]">[{$oOrderArticle->oxorderarticles__oxamount->value}]</div>
                    [{/foreach}]
                </td>
                <td class="[{ $listclass}]">
                    [{foreach item=oOrderArticle from=$oOrderArticles }]
                        <div style="[{$artStyle}]">[{$oOrderArticle->oxorderarticles__oxbrutprice->value}]</div>
                    [{/foreach}]
                </td>
                [{foreach name=AddHeader item=sArticleData from=$oOrderArticle->jxGetAdditionalArticleData() }]
                    <td class="[{ $listclass}]">
                        [{foreach item=oOrderArticle from=$oOrderArticles }]
                            <div style="[{$artStyle}]">[{$sArticleData }]</div>
                        [{/foreach}]
                    </td>
                [{/foreach}]
                    
            </tr>
        [{/foreach}]
    </table>
</div>
    