<ul class="profile-tabs">
      <li class="<?php if (Yii::app()->controller->action->id == 'user') echo 'active'; ?>">
        <a data-url-name="users.profile" href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$user->urlID)); ?>">
          <?php echo $user->countads; ?>
		  <div class="text-muted"><?php echo Yii::t('messages', 'ads N', array($user->countads)); ?></div>
        </a>
      </li><li class="<?php if (Yii::app()->controller->action->id == 'followers') echo 'active'; ?>">
        <a data-url-name="users.profile_followers" href="<?php echo Yii::app()->createUrl('account/followers',array('id'=>$user->urlID)); ?>">
          <?php echo $user->countuserfollowers; ?>
          <div class="text-muted"><?php echo Yii::t('messages', 'followers N', array($user->countuserfollowers)); ?></div>
        </a>
      </li><li class="<?php if (Yii::app()->controller->action->id == 'following') echo 'active'; ?>">
        <a data-url-name="users.profile_following" href="<?php echo Yii::app()->createUrl('account/following',array('id'=>$user->urlID)); ?>">
          <?php echo $user->countuserfollowing; ?>  
          <div class="text-muted"><?php echo Yii::t('messages', 'following N', array($user->countuserfollowing)); ?></div>
        </a>
      </li>
    </ul>
