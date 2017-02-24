<?php
$searchForm->phb = $ad->phb;
$searchForm->phm = $ad->phm;
?>
<div style="clear: both; position: relative" class="rowNode optim-car_brand">
    <label class="lfloat"><?php echo Yii::t('messages', 'Phone brand'); ?><br></label>
    <div class="boxInput lfloat">
        <?php $phoneBrands = FilterPhoneBrands::model()->findAll();
        $phoneBrandsList = CHtml::listData($phoneBrands, 'orderID', 'name'); ?>
        <?php echo CHtml::dropDownList('Ad[phb]','',$phoneBrandsList,array('id'=>'phb','prompt'=>Yii::t('messages', 'Phone brand'),'options' => array($searchForm->phb=>array('selected'=>true)))); ?>
    </div>
</div>

<div style="clear: both; position: relative" class="rowNode optim-car_model">
    <label class="lfloat"><?php echo Yii::t('messages', 'Phone model'); ?><br></label>
    <div class="boxInput lfloat">
        <?php
        $phoneModelsList = array();
        if ($searchForm->phm) {
            $phoneModel = FilterPhoneModels::model()->find('orderID=:orderID',array(':orderID'=>$searchForm->phm));
            $phoneModelsList = CHtml::listData(FilterPhoneModels::model()->findAll('phoneBrandID=:phoneBrandID',array(':phoneBrandID'=>$phoneModel->phoneBrandID)), 'orderID', 'name');
        }
        echo CHtml::dropDownList('Ad[phm]','',$phoneModelsList,array('id'=>'phm','prompt'=>Yii::t('messages', 'Phone model'),'options' => array($searchForm->phm=>array('selected'=>true)))); ?>
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





<?php   Yii::app()->clientScript->registerScript('maxmincript',"
    $('#phma').on('change',function(e) {
            var pmSelected = $( '#phm option:selected' ).val();
            var pmaSelected = $( '#phma option:selected' ).val();
            if (pmSelected > pmaSelected)
                $('#pm').val(pmaSelected);

     });

     $('#phm').on('change',function(e) {
            var phmSelected = $( '#phm option:selected' ).val();
            var phmaSelected = $( '#phma option:selected' ).val();
            if (phmSelected > phmaSelected)
                $('#phma').val(phmSelected);

     });
",CClientScript::POS_READY);
?>


