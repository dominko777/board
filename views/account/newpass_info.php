<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<p class="bg-success main-site-messages">
            <?php echo Yii::t('messages','We will email you a link to reset your password. When you receive the email, click on the link to reset it on our site.').'&nbsp;'; ?>
            <?php echo '<br><b>'.Yii::t('messages','This email may take a little while to arrive. If you don\'t see it shortly, check your Spam and Junk folders.').'</b>'; ?>
</p>

