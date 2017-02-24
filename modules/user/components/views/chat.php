<ul class="nav nav-stacked chat-menu js-chat-menu hidden-xs">
      <li role="presentation" class="<?php //if (!$archive) echo 'active'; ?>"><a href="<?php echo Yii::app()->createUrl('user/chat/inbox'); ?>" class="js-inbox"><?php echo Yii::t('chat','Inbox'); ?></a></li>
      <!--<li role="presentation" class="<?php /*if ($archive) echo 'active'; */?>"><a href="<?php /*echo Yii::app()->createUrl('user/chat/archive'); */?>" class="js-archive"><?php /*echo Yii::t('chat','Archived Chats'); */?></a></li>-->
</ul>   