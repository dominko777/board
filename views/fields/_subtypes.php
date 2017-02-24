<div style="display: none" id="subtypes" class="sb_advfields sb_advfields_double">
    <?php     echo CHtml::radioButtonList('st', $searchForm->st ,Ad::$subtypesArray,
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