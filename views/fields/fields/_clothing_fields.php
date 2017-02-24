<div class="sb_advfields" style="display: inline-block;">
    <label><?php echo Yii::t('messages', 'Type'); ?></label>
    <div class="sb_advfield">
        <?php echo CHtml::dropDownList('s','',array(SearchForm::MALE=>Yii::t('messages', 'Male'),SearchForm::FEMALE=>Yii::t('messages', 'Female')),array('prompt'=>Yii::t('messages', 'Type'),'options' => array($searchForm->s=>array('selected'=>true)))); ?>
    </div>
</div>

