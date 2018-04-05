<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult - основной массив в котором содержаться даннные, которые можно выводить*/
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<!--    <pre>-->
<!--    --><?//print_r($arResult)?>
<?//print_r($arResult['ITEMS'][1]['PROPERTIES']['svjazi']['VALUE']);?>
<?
$cnt = 1;
foreach($arResult["ITEMS"] as $arItem){
    $url = $arItem['DETAIL_PAGE_URL'];
    echo "<p style=\"border: 1px solid red\"><li>";
    echo $cnt. ' - '. $arItem['NAME'] . ' <a href="'.$url.'">[+]</a>';
    echo "<p>";
    echo " Тип лицензии: ".$arItem['DISPLAY_PROPERTIES']['licenz_1']['VALUE'];
    echo "<p>";
    echo "</li></p>";

    echo "<p style=\"border: 1px solid green\">";
    $anons = substr($arItem['PREVIEW_TEXT'], 0, 100);
    echo $anons.' <a href="'.$url.'">...</a>';
    echo "</p>";

    echo "<p>";
    $src = $arItem['DETAIL_PICTURE']['SRC'];

    if (arItem['ID']){
        $file = CFile::ResizeImageGet(
            $arItem['ID'],
            array('width'=>150, 'height'=>150),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            true);
        echo $img = '<img src="'.$file['src'].'" width="'.$file['width'].'" height="'.$file['height'].'" />';
    }

    echo "</p>";
    $cnt++;
}
$idSvjazi = array();
    $cnt = count(($arResult['ITEMS']));
    for($i = 0; $i < $cnt; $i++){
        if($arResult['ITEMS'][$i]['PROPERTIES']['svjazi']['VALUE']){

            $yvalue = 1;
            $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL");
//$arSelect = Array();
            $arSort = array(
                "name" => "asc",
                "name"=>"asc",
            );

            if( !empty($arResult['ITEMS'][$i]['PROPERTIES']['svjazi']['VALUE']) ){
                $arFilter = Array("IBLOCK_ID" => IntVal($yvalue), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "ID" => $arResult['ITEMS'][$i]['PROPERTIES']['svjazi']['VALUE']);

                $res = CIBlockElement::GetList($arSort, $arFilter, false, Array("nTopCount" => count($arResult['ITEMS'][$i]['PROPERTIES']['svjazi']['VALUE'])), $arSelect);

                while ($ob = $res->GetNextElement()) {
                    $arFields = $ob->GetFields();
                    echo "<a href='".$arFields['DETAIL_PAGE_URL']."'>".$arFields['NAME']."</a>"."<br>";
                }
            }


        }
    }
?>
<!--</pre>-->
    <ul>
        <?
        //foreach($arResult["ITEMS"] as $arItem){
        //    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        //    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        //    echo "<li id='".$this->GetEditAreaId($arItem['ID'])."'>";
        //        echo $arItem['NAME'];
        //    echo "</li>";
        //}


        // От сюда раскоментировать


        ?>
    </ul>

<?/*<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<p class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img
						class="preview_picture"
						border="0"
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						style="float:left"
						/></a>
			<?else:?>
				<img
					class="preview_picture"
					border="0"
					src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
					width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
					height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
					alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
					title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
					style="float:left"
					/>
			<?endif;?>
		<?endif?>
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
			<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
		<?endif?>
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
			<?else:?>
				<b><?echo $arItem["NAME"]?></b><br />
			<?endif;?>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<?echo $arItem["PREVIEW_TEXT"];?>
		<?endif;?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
	</p>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>
*/