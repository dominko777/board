<?php
$searchForm->s = $ad->s;
?>
<div style="clear: both; position: relative" class="rowNode">
    <label class="lfloat"><?php echo Yii::t('messages', 'Type'); ?><br></label>
    <div class="boxInput lfloat">
        <?php echo CHtml::dropDownList('Ad[s]','',array(SearchForm::MALE=>Yii::t('messages', 'Male'),SearchForm::FEMALE=>Yii::t('messages', 'Female')),array('id'=>'s','prompt'=>Yii::t('messages', 'Type'),'options' => array($searchForm->s=>array('selected'=>true)))); ?>
    </div>
</div>

