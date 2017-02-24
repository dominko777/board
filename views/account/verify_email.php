<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<p class="bg-success main-site-messages">
    <?php echo $activation_msg;?>
    <a href="<?php echo Yii::app()->createurl('account/login'); ?>">  
            <?php echo Yii::t('messages','Login link'); ?>
    </a>
</p>


