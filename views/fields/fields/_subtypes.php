<div  <?php
if ($searchForm->subtypeParam == SearchForm::SALE_RENT_WANTED)
    $sa = Ad::$subtypesRentArray;
else
    $sa = Ad::$subtypesArray;

if($searchForm->type != SearchForm::DYNAMIC_SEARCH) { ?> style="display:none;" <?php } ?> id="subtypes" class="sb_advfields sb_advfields_double">
    <?php     echo CHtml::radioButtonList('st', $searchForm->st ,$sa,
        array(
            'labelOptions'=>array('style'=>'display:inline'),
            'separator'=>'',
            'template'=>'
            <span class="sb_searchtype">
            {input}
            {label}
            </span>
            ',
        ));
    ?>
</div>