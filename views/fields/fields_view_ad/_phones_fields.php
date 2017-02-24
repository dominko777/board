<?php
if ($ad->phb!=0) :
    echo '<li><b>'.Yii::t("messages", "Phone brand").'</b>'.FilterPhoneBrands::model()->find("orderID=:orderID",array(":orderID"=>$ad->phb))->name.'</li>';
endif;

if ($ad->phm!=0) :
    echo '<li><b>'.Yii::t("messages", "Phone model").'</b>'.FilterPhoneModels::model()->find("orderID=:orderID",array(":orderID"=>$ad->phm))->name.'</li>';
endif;
