<div class="sb_advfields" style="display: inline-block;">
    <label><?php echo Yii::t('messages', 'Brand/Model'); ?></label>
    <div class="sb_advfield">
        <?php $phoneBrands = FilterPhoneBrands::model()->findAll();
        $phoneBrandsList = CHtml::listData($phoneBrands, 'orderID', 'name'); ?>
        <?php echo CHtml::dropDownList('phb','',$phoneBrandsList,array('prompt'=>Yii::t('messages', 'Phone brand'),'options' => array($searchForm->phb=>array('selected'=>true)))); ?>
        <?php
        $phoneModelsList = array();
        if ($searchForm->phb) {
            $carBrand = FilterPhoneBrands::model()->find('orderID=:orderID',array(':orderID'=>$searchForm->phb));
            $phoneModels=FilterPhoneModels::model()->findAll('phoneBrandID=:phoneBrandID',array(':phoneBrandID'=>$carBrand->id));
            $phoneModelsList = CHtml::listData($phoneModels, 'orderID', 'name');
        }
        ?>
        <?php echo CHtml::dropDownList('phm','',$phoneModelsList,array('prompt'=>Yii::t('messages', 'Phone model'),'options' => array($searchForm->phm=>array('selected'=>true)))); ?>
    </div>
</div>


<?php   Yii::app()->clientScript->registerScript('phonebrandmodelcript',"
    $('#phb').on('change',function(e) {
        var brandId = $('#phb option:selected').val();
        var url = '".Yii::app()->createurl('backend/filter/filterPhoneModels/getPhoneModel')."';
        $.ajax({
            url: url,
            method: 'GET',
            data: 'brandId='+brandId,
            success: function(response)
            {
                $('#phm').empty().append(response);
            }
        });
    })
",CClientScript::POS_READY);
?>

<div class="sb_advfields" style="display: inline-block;">
    <label><?php echo Yii::t('messages', 'Price'); ?></label>
    <div class="sb_advfield">
        <?php
        $phoneBrands = FilterPhonePrice::model()->findAll(array('order'=>'orderID ASC'));
        $phonePriceList = CHtml::listData($phoneBrands, 'orderID', 'name'); ?>
        <?php echo CHtml::dropDownList('ppm','',$phonePriceList,array('prompt'=>Yii::t('messages', 'Price min'),'options' => array($searchForm->pm=>array('selected'=>true)))); ?>
        <?php echo CHtml::dropDownList('ppma','',$phonePriceList,array('prompt'=>Yii::t('messages', 'Price max'),'options' => array($searchForm->pma=>array('selected'=>true)))); ?>
    </div>
</div>
<?php   Yii::app()->clientScript->registerScript('maxmincript',"
    $('#pma').on('change',function(e) {
            var pmSelected = $( '#ppm option:selected' ).val();
            var pmaSelected = $( '#ppma option:selected' ).val();
            if (pmSelected > pmaSelected)
                $('#ppm').val(pmaSelected);

     });

     $('#pm').on('change',function(e) {
            var pmSelected = $( '#ppm option:selected' ).val();
            var pmaSelected = $( '#ppma option:selected' ).val();
            if (pmSelected > pmaSelected)
                $('#ppma').val(pmSelected);

     });
",CClientScript::POS_READY);
?>

