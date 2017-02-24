<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/listing.min.css" media="screen" />
<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" media="screen" />
<div id="regContainer">
    <div id="box_registrazione">
        <div id="myads">
            <div class="view_header" style="padding-left: 0px; display: table; width: 100%;">
                <img style="width: 160px; height: 160px; float: left; display: inline-block; vertical-align: middle;" src="<?php
                            if ($user->avatar=='nothumb.jpg') echo Yii::app()->request->baseUrl.'/images/static/default.png';
                            else
                                echo User::getAvatarFile($user->avatar); ?>">  
                <div class="title" style="display: table-cell; line-height: 1.4em;     vertical-align: top; padding-top: 10px; padding-left: 20px;
    ">
                <?php if ($user->id == Yii::app()->user->id){ ?>
                    <h1><?php echo Yii::t('messages', 'My ads'); ?></h1>
                <?php  } else  { ?>
                    <h1><?php echo Yii::t('messages', 'Users ads'); ?>&nbsp;<?php echo $user->fio; ?></h1>
                <?php } ?>
                    <span style="float: left; width: 100%; padding-left: 1px; padding-top: 20px; padding-bottom: 23px; font-size: 15px;"><?php
if (Yii::app()->user->id!=$user->id)
echo Yii::t('messages','Seller ratings');
else
echo Yii::t('messages','My rating');
 ?></span>
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


            <?php if ($ads->totalItemCount==0) { ?>
                <span style="font-size: 17px; padding-top: 10px; float: left; width: 100%; "><?php echo Yii::t('messages', 'You havent ads yet.'); ?> &nbsp; <a style="text-decoration: underline" rel="nofollow" href="<?php echo Yii::app()->createurl('ad/new'); ?>" ><?php echo Yii::t('messages', 'Place my ad'); ?></a></span>
                <?php 
            }
            else
            {
            ?>
            <div>
                    <ul style="background-color: #ffffff;" class="newList userAdList">
                    <?php
                    $today = date('Y-m-d');
                    $this->widget('zii.widgets.CListView', array(
                        'viewData' => array('today_date' => $today),
                        'dataProvider'=>$ads,
                        'emptyText' => '',
                        'summaryText'=>'',
                        'itemView'=>'_cabinet_search_item',
                        'pager' =>'CPager',
                        'ajaxUpdate'=>false,
                    ));
                    ?>
                    </ul>
            </div>
            <?php } ?>
         </div>
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

Yii::app()->clientScript->registerScript('myadscript',"
var deleteAdUrl = '".Yii::app()->createurl('ad/delete')."';

$('.controls .remove_ad').click(function() {
if(!confirm('".Yii::t('messages', 'Do you want to delete this ad?')."')) return false;
    var id = this.id;
    $.ajax({
                url: deleteAdUrl,
                method: 'POST',
                data: 'id='+id,
                success: function(response)
                {
                      if(response.length >0)
                          $('#mydialog').dialog('open');
                }
        });
        return false;
});

",CClientScript::POS_READY);

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
}