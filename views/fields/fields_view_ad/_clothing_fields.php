<?php
if ($ad->s!=0) :
    echo '<li><b>'.Yii::t("messages", "Type").'</b>';
    if ($ad->s==1)
        echo Yii::t('messages', 'Male');
    elseif ($ad->s==2)
        echo Yii::t('messages', 'Female');
    echo '</li>';
endif;

