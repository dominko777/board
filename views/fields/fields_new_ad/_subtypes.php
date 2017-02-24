<div class="rowNode optim-type">
    <label class="lfloat"><?php echo Yii::t('messages', 'Type of interest'); ?><br></label>
    <div class="boxInput lfloat">
        <div>
            <?php if ($searchForm->subtypeParam = SearchForm::SALE_WANTED)
                $st = Ad::$subtypesArray;
            else
                $st = Ad::$subtypesRentArray;
            foreach ($st as $key=>$value):
                echo '<input type="radio" name="Ad[subtypeID]" required="true" ';
                if ($searchForm->st == $key) echo 'checked="checked" ';
                echo 'value="'.$key.'" aria-required="true">';
                echo '<span>'.$value.'</span>';
            endforeach;
            ?>
        </div>
        </div>
</div>
