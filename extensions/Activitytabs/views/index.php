<ul class="profile-tabs">
      <li class="<?php if (Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
        <a  href="<?php echo Yii::app()->createUrl('activity/index'); ?>">
         <?php echo Yii::t('messages','New ads'); ?>
        </a>
      </li><li class="<?php if (Yii::app()->controller->action->id == 'sold') echo 'active'; ?>">
        <a  href="<?php echo Yii::app()->createUrl('activity/sold'); ?>">
        <?php echo Yii::t('messages','Sold'); ?>
        </a>
      </li><li class="<?php if (Yii::app()->controller->action->id == 'users') echo 'active'; ?>">
        <a  href="<?php echo Yii::app()->createUrl('activity/users'); ?>">
        <?php echo Yii::t('messages','Followers'); ?>
        </a>
      </li>
</ul>
