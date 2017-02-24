
<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>

<div class="col-md-4 col-sm-5">
    <div class="panel seller-namecard">
      <div class="media">

          <span class="pull-left">

          <img class="img-circle media-object pretty-border" src="<?php
                                if ($user->avatar=='nothumb.jpg') echo Yii::app()->request->baseUrl.'/images/static/default.png';
                                else
                                    echo User::getAvatarFile($user->avatar); ?>" alt="<?php echo $user->fio; ?>">


          </span>

        <div class="media-body">
          <h1 class="media-heading">
            <?php echo $user->fio; ?>
          </h1>
          <div class="text-muted"><?php echo Yii::t('messages','On site with').'&nbsp;'.date('Y',strtotime($user->register_date)).'&nbsp;'.Yii::t('messages','(On site with) year'); ?></div>
        </div>
      </div>
    </div>
    <div class="panel">
        <div class="panel-body">
            <div id="feedback_ratings" style="padding-left: 4px;">
               <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::POSITIVE,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                    <span class="spr pos"></span>
                    <span class="num pos_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::POSITIVE,':sellerID'=>$user->id)); ?></span>
                    <div class="cf"></div><span class="txt"><?php echo Yii::t('messages','Positive rating'); ?></span>
                    </div>
               </a>
            <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEUTRAL,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                      <span class="spr nei"></span>
                      <span class="num neu_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEUTRAL,':sellerID'=>$user->id)); ?></span>
                      <span class="txt"><?php echo Yii::t('messages','Neitral rating'); ?></span>
                </div>
            </a>

            <a  onclick = " return false;" href="<?php echo Yii::app()->createUrl('sellerrating/create',array('type'=>SellerRating::NEGATIVE,'sellerId'=>$user->urlID)); ?>">
                <div class="score">
                    <span class="spr neg"></span>
                    <span class="num neg_r"><?php echo SellerRating::model()->count('type=:type AND sellerID=:sellerID',array(':type'=>SellerRating::NEGATIVE,':sellerID'=>$user->id)); ?></span>
                    <span class="txt"><?php echo Yii::t('messages','Negative rating'); ?></span>
                </div>
               </a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-8 col-sm-7">
     <div class="panel">
         <div class="panel-body">
             <h2><?php echo Yii::t('messages', 'My favorites'); ?></h2>
         </div>
     </div>
    <div class="profile-tab-content-container">
        <?php
                $today = date('Y-m-d');
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$ads,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_user_ad_item',
                    'pager' =>'CPager',
                    'ajaxUpdate'=>true,
                 //   'columns' => 3,
'enablePagination'=>true,
                 //   'enableHistory' => true,
                 //   'ajaxUrl'=>Yii::app()->createurl('ads/search').'?Ad_page_2&mc=kukhnya',
                    'afterAjaxUpdate' => 'function(id, data){
                       // changeBrowserUrl($.fn.yiiListView.getUrl(id));
                        $("html, body").animate({scrollTop: $(".profile-tab-content-container").position().top }, 100);}'
                ));
                ?>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog',
    'options' => array(
        'title' => Yii::t('messages', 'Deleting ad'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding: 20px"><?php echo Yii::t('messages', 'Ad was successfuly deleted'); ?></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'ratingDialog',
    'options' => array(
        'title' => Yii::t('messages', 'Rating'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>
<div id="msgModal" style="padding: 20px"><?php echo Yii::t('messages', 'You must be logged in to create rating');
echo ' <a style="text-decoration: underline; color: blue;" href="'.Yii::app()->createUrl('account/login').'">'.Yii::t('messages','Login link').'</a>'; ?></div>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');


if (Yii::app()->user->id!=$user->id):
Yii::app()->clientScript->registerScript('ratingscriptcabinet',"

$('#feedback_ratings > a').click(function() {
       $('#feedback_ratings').fadeTo(0, 0.5);
       var ratingUrl = $(this).attr('href');
       $.ajax({
                url: ratingUrl,
                method: 'GET',
                success: function(msg)
                {
                      var result = $.parseJSON(msg);
                      $('.pos_r').text(result.positive);
                      $('.neu_r').text(result.neutral);
                      $('.neg_r').text(result.negative);
                      $('#feedback_ratings').fadeTo(0, 1);
                }
        });
       return false;
});
",CClientScript::POS_READY);
endif;


if(Yii::app()->user->isGuest){
Yii::app()->clientScript->registerScript('notloggedratingscriptcabinet',"
$('#feedback_ratings > a').click(function() {
       $('#ratingDialog').dialog('open');
       return false;
});
",CClientScript::POS_READY);
}; ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'mydialog',
    'options' => array(
        'title' => Yii::t('messages', 'Deleting ad'),
        'autoOpen' => false,
        'modal' => true,
        'resizable'=> false
    ),
)); ?>

<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');

Yii::app()->clientScript->registerScript('myfavscript',"
var deleteFavUrl = '".Yii::app()->createurl('account/deleteFavorite')."';
$('.controls .remove_fav').click(function() {
if(!confirm('".Yii::t('messages', 'Do you want to delete this favorite?')."')) return false;
var id = this.id;
$.ajax({
url: deleteFavUrl,
method: 'POST',
data: 'id='+id,
success: function(response)
{
if(response.length >0)
$('#mydialog').dialog('open');
var html = '<div id=\"msgModal\" style=\"padding: 20px\">".Yii::t('messages', 'Favorite was successfuly deleted')."</div>';
$('#mydialog').append(html);
}
});
return false;
});

",CClientScript::POS_READY);