<?php
if ($ad->cb!=0) :
    echo '<li><b>'.Yii::t('messages', 'Car brand').'</b>'.FilterCarBrand::model()->find("orderID=:orderID",array(":orderID"=>$ad->cb))->name.'</li>';
endif;

if ($ad->cm!=0) :
    echo '<li><b>'.Yii::t('messages', 'Car model').'</b>'.FilterCarModel::model()->find("orderID=:orderID",array(":orderID"=>$ad->cm))->name.'</li>';
endif;
