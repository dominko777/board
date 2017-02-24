<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<p class="bg-success main-site-messages"><?php
        echo Yii::t('messages', 'Congratulations - You have successfuly registered. Check your email and follow link to activate your account.').'&nbsp;';
        echo '<br><b>'.Yii::t('messages','If you don\'t receive email, check folder Spam').'</b>'.'.&nbsp;';
        echo '<br>'.Yii::t('messages', 'If you have problems contact us via email').' '.Yii::app()->params['email']; ?>
<p>
