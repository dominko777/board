<div class="col-md-4 col-xs-6">
<figure class="card user-card" style="padding:15px; margin-top:0;">
  <a href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$data->followed->urlID)); ?>">
      <img class="img-circle pretty-border  follow" src="<?php echo User::getAvatarImgSrc($data->followed->avatar); ?>">
    <figcaption class="caption">
      <h3 class="title"><?php echo $data->followed->fio; ?></h3>
      <p>
        <?php echo $data->followed->countuserfollowers; ?>
        <?php echo Yii::t('messages', 'followers N', array($data->followed->countuserfollowers)); ?>
      </p>
    </figcaption>
  </a>

  <button id="<?php echo $data->followed->urlID; ?>" class=" btn
  <?php
            echo 'btn-success';
        ?>
        btn-block js-follow">
      <?php   
            echo Yii::t('messages','Followed');
        ?>
      </button>

   </figure>
</div>

<?php
if(Yii::app()->user->isGuest){
Yii::app()->clientScript->registerScript('notloggedfcabinet',"
$('.js-follow').click(function() {
    window.location = '".Yii::app()->createUrl('account/login')."';
});
",CClientScript::POS_READY);
}
else {
Yii::app()->clientScript->registerScript('followlistscript',"
$('.js-follow').click(function() {
       var fId = $(this).attr('id');
       $.ajax({
                url: '".Yii::app()->createUrl('account/follow')."',
                method: 'GET',
                data: 'id='+fId,
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      if (result.follow == 'created')
                      {
                         var userLogin = $('#'+fId+'.js-follow').parent().find('h3').text();
                         $('#'+fId+'.js-follow').text('".Yii::t('messages','Followed')."').removeClass('btn-default').addClass('btn-success');
                         $('#infodialog > #msgModal').empty().text('".Yii::t('messages','You have followed user')."'+' '+userLogin)
                         $('#infodialog').dialog('open');
                      }
                      else
                      if (result.follow == 'deleted')
                      {
                         var userLogin = $('#'+fId+'.js-follow').parent().find('h3').text();
                         $('#'+fId+'.js-follow').text('".Yii::t('messages','Follow')."').removeClass('btn-success').addClass('btn-default');
                         $('#infodialog > #msgModal').empty().text('".Yii::t('messages','You have not followed user')."'+' '+userLogin)
                         $('#infodialog').dialog('open');
                      }

                }
        });
       return false;
});

$('#closePopup').click(function() {
       $('#infodialog').dialog('close');
       return false;
});
",CClientScript::POS_READY);
}
 
