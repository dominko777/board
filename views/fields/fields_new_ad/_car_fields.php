<?php
$searchForm->cb = $ad->cb;
$searchForm->cm = $ad->cm;
?>
<div style="clear: both; position: relative" class="rowNode optim-car_brand">
    <label class="lfloat"><?php echo Yii::t('messages', 'Car brand'); ?><br></label>
    <div class="boxInput lfloat">
        <?php $carBrands = FilterCarBrand::model()->findAll();
        $carBrandsList = CHtml::listData($carBrands, 'orderID', 'name'); ?>
        <?php echo CHtml::dropDownList('Ad[cb]','',$carBrandsList,array('id'=>'cb','prompt'=>Yii::t('messages', 'Car brand'),'options' => array($searchForm->cb=>array('selected'=>true)))); ?>
    </div>
</div>

<div style="clear: both; position: relative" class="rowNode optim-car_model">
    <label class="lfloat"><?php echo Yii::t('messages', 'Car model'); ?><br></label>
    <div class="boxInput lfloat">
        <?php
        $carModelsList = array();
        if ($searchForm->cm) {
            $carModel = FilterCarModel::model()->find('orderID=:orderID',array(':orderID'=>$searchForm->cm));
            $carModelsList = CHtml::listData(FilterCarModel::model()->findAll('carBrandID=:carBrandID',array(':carBrandID'=>$carModel->carBrandID)), 'orderID', 'name');
        }
        echo CHtml::dropDownList('Ad[cm]','',$carModelsList,array('id'=>'cm','prompt'=>Yii::t('messages', 'Car model'),'options' => array($searchForm->cm=>array('selected'=>true)))); ?>
    </div>
</div>


<?php   Yii::app()->clientScript->registerScript('carbrandmodelcript',"
    $('#cb').on('change',function(e) {
        var brandId = $('#cb option:selected').val();
        var url = '".Yii::app()->createurl('ad/getCarModel')."';
        $.ajax({
            url: url,
            method: 'GET',
            data: 'brandId='+brandId,
            success: function(response)
            {
                $('#cm').empty().append(response);
            }
        });
    })
",CClientScript::POS_READY);
?>





<?php   Yii::app()->clientScript->registerScript('maxmincript',"
    $('#pma').on('change',function(e) {
            var pmSelected = $( '#pm option:selected' ).val();
            var pmaSelected = $( '#pma option:selected' ).val();
            if (pmSelected > pmaSelected)
                $('#pm').val(pmaSelected);

     });

     $('#pm').on('change',function(e) {
            var pmSelected = $( '#pm option:selected' ).val();
            var pmaSelected = $( '#pma option:selected' ).val();
            if (pmSelected > pmaSelected)
                $('#pma').val(pmSelected);

     });
",CClientScript::POS_READY);
?>


