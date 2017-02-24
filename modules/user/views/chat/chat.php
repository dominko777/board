<?php
$this->pageTitle = Yii::t('chat','Chat');
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/chat.css');
$cs->registerScriptFile("/js/crating.js", CClientScript::POS_END);   

$mineBlock = (Yii::app()->user->id == $chat->buyerID) ? $chat->buyerBlock : $chat->sellerBlock;


if ($chat->sellerID == Yii::app()->user->id)
{
    $mineAvatar = User::getAvatarImgSrc($chat->sellerAvatar);
    $blockReportUserUrlID = $chat->buyerUrlID;
    $srcAvatar =  User::getAvatarImgSrc($chat->buyerAvatar);
    $blockReportUserLogin = $chat->buyerLogin;
    $positiveRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$chat->buyerID));
    $neutralRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$chat->buyerID));
    $negativeRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$chat->buyerID));
    $me = User::model()->findByPk($chat->sellerID);
}
else
{
    $mineAvatar = User::getAvatarImgSrc($chat->buyerAvatar);
    $blockReportUserUrlID = $chat->sellerUrlID;
    $srcAvatar = User::getAvatarImgSrc($chat->sellerAvatar);
    $blockReportUserLogin = $chat->sellerLogin;
    $positiveRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$chat->sellerID));
    $neutralRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$chat->sellerID));
    $negativeRating = SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$chat->sellerID));
    $me = User::model()->findByPk($chat->buyerID);
}

if (!empty($chat->productPhoto))
               $productPhotoSrc = AdImage::getDirPathThumbs($chat->productPhoto);
            else
                $productPhotoSrc = Yii::app()->request->baseUrl.'/images/static/nothumb.png';  


?>
<div id="main-wrapper">
<div class="page-body container-fluid">
<section class="chat-convo-bottom js-region-bottom">

<main class="focus-mobile main-content container js-app-layout-main" role="main">
<div>
<div class="row">
 <!-- <div class="col-md-3">
    <?php /*$this->widget('application.modules.user.components.MailWidget', array()); */?>
  </div>-->
  <div class="col-md-12 chat-main">
    <div class="js-chat-content"><div><div class="chat-convo">
  <div class="js-top">
    <section class="media chat-convo-top">
  <a href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$chat->adTransName)); ?>" class="media-left chat-thumbnail">
 
    <img alt="Tan Boots" src="<?php echo $productPhotoSrc; ?>" class="item-image">

  </a>
  <div class="media-body">
      <h4 class="media-heading"><?php
   echo $chat->productName;   ?></h4>
    <p class="small">
      <span class="text-muted"><?php echo $chat->productPrice;  echo ' '.Yii::t('messages','Currency_sign small').'.'; ?></span>

    </p>

  </div>

  <div class="btn-group chat-action-group">



      <!--<button class="btn btn-default btn-sm js-archive-unarchive">
        <i class="fa fa-archive btn-icon"></i>
        <span class="hidden-xs">
          <?php /*if (empty($chat->archiveId))
                    echo Yii::t('chat','Archive');
                else
                    echo Yii::t('chat','Move to inbox');
            */?>
        </span>
      </button>-->

    <button id="delete_chat_button" aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-sm dropdown-toggle" type="button">
      <span class="caret"></span> 
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul id="popup_delete_chat_button" role="menu" class="dropdown-menu dropdown-menu-right chat-action-dropdown">
      <li>
        <a href="#" class="js-delete">
          <i class="fa fa-trash btn-icon"></i>
          <?php echo Yii::t('chat','Delete Chat'); ?>
        </a>
      </li>
    </ul>
  </div>
</section>
 
  </div>
  <section class="chat-convo-bottom js-region-bottom"><div class="row">
  <div class="col-sm-push-8 col-sm-4 chat-convo-meta-bg">
    <aside class="chat-convo-meta js-meta hidden-xs">
      <section class="chat-convo-meta-offer js-offer-container">
        <div class="offer js-offer">

    <?php if ($chat->buyerID == Yii::app()->user->id): ?>
      <form class="js-offer-form"> 
        <input type="hidden" value="34514735" name="product_id">
        <div class="form-group">
          <label for="price"><?php echo Yii::t('chat','Your offer (in grn)'); ?></label>
          <input type="number" value="<?php echo $chat->productPrice; ?>" name="latest_price" step="1" min="0" id="price" class="form-control">
        </div>
        <button type="submit" class="btn btn-sm btn-info btn-offer js-make-offer"><?php echo Yii::t('chat','Make Offer'); ?></button>
      </form>
    <?php endif; ?> 


</div>
      </section>
      <section class="chat-convo-meta-user js-user-container text-center">
        <hr>


<h4> 
    <?php if ($chat->buyerID == Yii::app()->user->id) echo Yii::t('chat','About the seller'); else echo Yii::t('chat','About the buyer'); ?>
    </h4>
          <a href="<?php
      echo Yii::app()->createUrl('account/user',array('id'=>$blockReportUserUrlID)); ?>">

    <img src="<?php  echo $srcAvatar; ?>" class="img-circle pretty-border"></a>
<p><?php  echo $blockReportUserLogin; 


    ?></p>
<?php if ($chat->buyerID == Yii::app()->user->id): ?>
<div class="reputation" style="text-align: center">
  <div id="feedback_ratings" style="display: inline-block;">
   <a href="<?php  echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::POSITIVE,'sellerId'=>$blockReportUserUrlID)); ?>" onclick=" return false;">
	<div class="score">
		<span class="spr pos"></span>
		<span class="num pos_r"><?php  echo $positiveRating; ?></span>
		</div>
   </a>
<a href="<?php  echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEUTRAL,'sellerId'=>$blockReportUserUrlID)); ?>"  onclick=" return false;">
	<div class="score">
	      <span class="spr nei"></span>
	      <span class="num neu_r"><?php echo $neutralRating; ?></span>
	</div>
</a>

<a href="<?php  echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEGATIVE,'sellerId'=>$blockReportUserUrlID)); ?>" onclick=" return false;">
	<div class="score">
		<span class="spr neg"></span>
		<span class="num neg_r"><?php echo $negativeRating; ?></span>  
	</div>
   </a> 
</div>
</div>
    <?php endif; ?> 
<hr>


  <p class="chat-convo-meta-actions">  
    <button  class="btn btn-sm btn-default js-block-unblock">
        <?php if ($mineBlock == Chat::UNBLOCK)
            echo Yii::t('chat','Block User'); 
        else  
            echo Yii::t('chat','Unblock User'); ?>
    </button>


         <button id="reportButton" type="button" class="btn btn-sm btn-default"><?php echo Yii::t('chat','Report User'); ?></button>
    
  </p>

      </section>
    </aside>
    <button class="visible-xs btn btn-sm btn-block btn-default chat-toggle-meta-btn js-toggle-meta">
    </button>
  </div>
  <div class="col-sm-pull-4 col-sm-8 chat-convo-main">
    <ul class="chat-convo-main-messages js-messages">

    

        <?php
        if (!empty($chatReplies))
            foreach($chatReplies as $chatReply):
                                $avatarSrc = User::getAvatarImgSrc($chatReply->userAvatar);

                ?>
            <li class="media">
              <a href="<?php echo Yii::app()->createUrl('ad/user',array('id'=>$chatReply->userUrlID)); ?>" class="media-left">
                <img alt="<?php echo $chatReply->userLogin; ?>" src="<?php echo $avatarSrc; ?>" class="img-circle pretty-border chat-convo-avatar">
              </a> 
              <div class="media-body">
                <small class="media-heading"><?php echo $chatReply->userLogin; ?></small>

                  <p class="chat-convo-message"><?php echo $chatReply->reply; ?></p>

                <time class="small chat-convo-time"><?php echo date('H:i d-m-Y', $chatReply->time); ?></time>
              </div>
            </li>
        <?php endforeach; ?>

    </ul>

    <div class="chat-convo-forms">
     

      <form class="chat-convo-forms-message js-message-form">
        <input type="hidden" value="34514735" name="product_id">
        <div class="input-group">
          <textarea required="" rows="1" name="message" class="form-control simplebox" style="overflow: hidden; word-wrap: break-word; resize: none; height: 66px;"></textarea>
          <span type="submit" class="input-group-addon btn btn-default"><?php echo Yii::t('chat','Send') ?></span>
        </div>
      </form>
    </div>
  </div>


  <a href="/inbox/" class="visible-xs chat-nav-link"><i class="fa fa-angle-left"></i> Back to Inbox</a>
</div></section> 
</div>
</div></div>
  </div>
</div></div></main>
</section>
</div>
</div>
<?php

$blockUrl = Yii::app()->createUrl('user/chat/block',array('chatID'=>$chat->urlID));
$deleteUrl = Yii::app()->createUrl('user/chat/remove',array('chatID'=>$chat->urlID));      
$archiveChatUrl = Yii::app()->createUrl('user/chat/archived',array('chatID'=>$chat->urlID));
$replyUrl = Yii::app()->createUrl('user/chat/newreply',array('chatID'=>$chat->urlID));
$makeOfferUrl = Yii::app()->createUrl('user/chat/offer',array('chatID'=>$chat->urlID));

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'popupDialog',
    'options' => array(
        'title' => Yii::t('chat', 'Chat'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding-bottom: 20px; padding-top: 20px; text-align: center;"></div>
<button type="button" class="btn btn-success center-block" id="closePopup" style="width: 50%;">Ok</button>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScript('chatscript',"

$('.js-block-unblock').click(function() {
       $.ajax({
                url: '".$blockUrl."',
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      $('#msgModal').text(result.popupMessage);
                      $('.js-block-unblock').text(result.blockButtonStatus); 
                      $('#popupDialog').dialog('open');  
                }
        });
       return false;
});

$('.js-archive-unarchive').click(function() {
       $.ajax({
                url: '".$archiveChatUrl."',
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      $('#msgModal').text(result.popupMessage);
                      $('.js-archive-unarchive').text(result.archiveBtnStatus);
                      $('#popupDialog').dialog('open');  
                }
        });
       return false;
});  



$('#closePopup').click(function() {
       $('#popupDialog').dialog('close');  
       if (redirectAfterDelete)
           document.location.href='".Yii::app()->createUrl('user/chat/inbox')."';
       return false;
});

$('#delete_chat_button').click(function() {
       $('#popup_delete_chat_button').toggle();
       return false;
});

var redirectAfterDelete = false;

$('#popup_delete_chat_button').click(function() {
       $.ajax({
                url: '".$deleteUrl."',
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      $('#msgModal').text(result.popupMessage);
                      $('#popup_delete_chat_button').hide();
                      redirectAfterDelete = true;
                      $('#popupDialog').dialog('open');    
                }
        });
       return false; 
});

  
$('.input-group-addon').click(function() {
      var reply = $('.simplebox').val();
      sendReply(reply, 'simple');
      $('.simplebox').val('');
      return false;
});  

$('.js-make-offer').click(function() {
    var offerValue = $('input#price').val();
    sendReply(offerValue, 'offer');
    return false; 
});

$('#reportButton').click(function() { 
    sendReply('report', 'report');  
    return false;
}); 

function sendReply(reply, typeReply){
if (reply.length !=0 )
       $.ajax({
                url: '".$replyUrl."',
                method: 'POST',
                data: 'reply='+reply+'&typeReply='+typeReply,  
                success: function(msg)
                {     if (msg.length !=0)
                      {
                          var result = $.parseJSON(msg);
                          if (result.blockMessage.length!=0)
                          {
                            $('#msgModal').text(result.blockMessage); 
                            $('#popupDialog').dialog('open');
                          }
                          else {
                              var newReply, newTime;
                              var d = new Date(result.time*1000)
                              var curr_date = d.getDate();
                              var curr_month = d.getMonth()+1;
                              var curr_year = d.getFullYear();
                              var hours = d.getHours();
                              var minutes = d.getMinutes();
                              newTime = hours+'-'+minutes+' '+curr_date+'-'+curr_month+'-'+curr_year;
                              $('#msgModal').text(result.popupMessage);
                              newReply = '<li class=\"media\"><a class=\"media-left\" href=\"/ad/user/178479191\"><img class=\"img-circle pretty-border chat-convo-avatar\" src=\"".$mineAvatar."\"></a><div class=\"media-body\"><small class=\"media-heading\">'+result.login+'</small><p class=\"chat-convo-message\">'+result.reply+'</p><time class=\"small chat-convo-time\">'+newTime+'</time></div></li>';
                             $('.js-messages').append(newReply);
                             $('.js-messages').scrollTop($('.js-messages').prop('scrollHeight'));
                             sendNotification(result.replyId);  
                         }
                     }
                }
        });
}

function sendNotification(replyId){
$.post( '".Yii::app()->createUrl('api/message/notification')."',
{ email: '".$me->email."', chatReplyId: replyId } );       
}


",CClientScript::POS_READY);

