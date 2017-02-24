<?php
$isBuyer = (Yii::app()->user->id == $data['buyerID']) ? true : false;
                if ($isBuyer)
                     $unreadMessages =  ($data['countRepliesSellers'] - $data['readRepliesSellers']);
                else
                    $unreadMessages =  ($data['countRepliesBuyers'] - $data['readRepliesBuyers']);

 
      if (!empty($data['productPhoto']))
               $productPhotoSrc = AdImage::getDirPathThumbs($data['productPhoto']);
            else
                $productPhotoSrc = Yii::app()->request->baseUrl.'/images/static/nothumb.png';

      $avatarSrc = User::getAvatarImgSrc($data['userAvatar']);


?>

<a class="chat-list-item <?php if  ($unreadMessages==0) echo 'unread'; ?>" href="<?php echo Yii::app()->createUrl('user/chat/view',array('id'=>$data['chatUrlID'])); ?>">
  <div class="row">
    <div class="col-sm-1 hidden-xs">
      <span class="chat-list-checkbox">
        <input type="checkbox" class="checking_item" id="<?php echo $data['chatUrlID']; ?>">
        <label class="checking_item_label" for="<?php echo $data['chatUrlID']; ?>"></label>
      </span>
    </div>
    <div class="col-sm-4 col-xs-2 chat-list-item-user">
      <div class="media">
        <span class="media-left">
          <img class="pretty-border img-circle" src="<?php echo $avatarSrc; ?>">
               <?php
                 if  ($unreadMessages!=0):
                ?>

            <span class="chat-unread-count">
                <?php echo $unreadMessages; ?>
            </span>
            <?php endif; ?>
        </span>
        <div class="media-body hidden-xs"> 
          <h4 class="media-heading"><?php echo $data['lastReplyLogin']; ?></h4>
          <time class="small text-muted"><?php echo date('H:i d-m-Y', strtotime($data['lastReplyTime'])); ?></time>
        </div>
      </div>
    </div>
    <div class="col-sm-7 col-xs-10">
      <small class="small chat-list-item-user-mob visible-xs">minniemm <time class="text-muted pull-right">15/11/2015, 03:54pm</time></small>
      <div class="chat-list-item-product">
        <h4 class="chat-list-item-product-title"><?php echo $data['productName']; ?></h4>
        <p class="chat-list-item-product-details">
<?php echo  $data['lastReply']; ?>
</p>
        <small class="text-muted small chat-list-item-product-offer">
            <?php
      if ($data['chatOffer']!=0)
            if ($isBuyer)
                echo Yii::t('chat','Your offer is').' '.$data['chatOffer'].' '.Yii::t('chat','grn.');
            else
                echo Yii::t('chat','Buyers offer is').' '.$data['chatOffer'].' '.Yii::t('chat','grn.');
      else
        if ($isBuyer)
            echo Yii::t('chat','You have not made an offer on this item yet');
        else
            echo Yii::t('chat','Buyer have not made an offer on this item yet'); 
?>
        </small>
        <div class="chat-list-item-thumbnail">
          <img class="item-picture" style="width: 60px" src="<?php echo $productPhotoSrc; ?>" alt="">
            <?php if ($data['adSoldStatus'] == Ad::SOLD): ?>
            <div class="item-status small"><?php echo Yii::t('messages','Sold'); ?></div> 
            <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</a>  
 
