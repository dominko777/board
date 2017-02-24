<?php $this->renderPartial('form_fields/_subtypes', array('searchForm'=>$searchForm)); ?>

    <div class="sb_advfields" style="display: inline-block;">
        <label><?php echo Yii::t('messages','Car brand') ?></label>
        <div class="sb_advfield">
            <?php $carBrands = FilterCarBrand::model()->findAll();
            $carBrandsList = CHtml::listData($carBrands, 'orderID', 'name_cn'); ?>
            <?php echo CHtml::dropDownList('cb','',$carBrandsList,array('prompt'=>Yii::t('messages','Car brand'),'options' => array($searchForm->cb=>array('selected'=>true)))); ?>
            <?php
            $carModelsList = array();
            if ($searchForm->cb) {
                $carBrand = FilterCarBrand::model()->find('orderID=:orderID',array(':orderID'=>$searchForm->cb));
                $carModels=FilterCarModel::model()->findAll('carBrandID=:carBrandID',array(':carBrandID'=>$carBrand->id));
                $carModelsList = CHtml::listData($carModels, 'orderID', 'name_cn');
            }
            ?>
            <?php echo CHtml::dropDownList('cm','',$carModelsList,array('prompt'=>'Car model','options' => array($searchForm->cm=>array('selected'=>true)))); ?>
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
    <div class="sb_advfields" style="display: inline-block;">
        <label>Price</label>
        <div class="sb_advfield">
            <?php
            $carBrands = FilterVehiclePrice::model()->findAll();
            $vehiclePriceList = CHtml::listData($carBrands, 'orderID', 'name_cn'); ?>
            <?php echo CHtml::dropDownList('pm','',$vehiclePriceList,array('prompt'=>'Price min','options' => array($searchForm->pm=>array('selected'=>true)))); ?>
            <?php echo CHtml::dropDownList('pma','',$vehiclePriceList,array('prompt'=>'Price max','options' => array($searchForm->pma=>array('selected'=>true)))); ?>
        </div>
    </div>
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