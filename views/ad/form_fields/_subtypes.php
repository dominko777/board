<div class="rowNode optim-type" id="ti_block">
    <label class="lfloat"><?php echo Yii::t('messages','Type of interest') ?><br></label>
    <div class="boxInput lfloat">
        <div id="typeInterestDiv">
            <input type="radio" aria-required="true" value="s" checked="checked" required="true" name="Ad[subtypeID]">
            <span><?php echo Yii::t('messages','Sale') ?></span>
            <input type="radio" aria-required="true" value="k" required="true" name="Ad[subtypeID]">
            <span><?php echo Yii::t('messages','Needed') ?></span>
        </div>
    </div>
</div>