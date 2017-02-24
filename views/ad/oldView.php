<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jcarousel.connected-carousels.css" media="screen" />

<?php

$formatedAdDate = date("d-m-Y",$ad->time);

$this->pageTitle = $ad->name.'&nbsp;'.Yii::t('messages','Seo keywords on Dominko'); //anytime this view gets called
$seo_description = $ad->name.'. ';
$seo_description .= Yii::t('messages','Seo description on ad page first part');
$seo_description .= $ad->price.' ';
$seo_description .= Yii::t('messages','Seo description on ad page currency part');
$seo_description .= ' ';
$seo_description .= Yii::t('messages','Seo description on ad page third part');
$seo_description .= $ad->user->fio.'. ';
$seo_description .= Yii::t('messages','Seo description on ad page fourth part');
$seo_description .= $formatedAdDate.'. ';
if (!empty($ad->mcategory->name)){$seo_description .= Yii::t('messages','Seo description on ad page fifth part');
$seo_description .= $ad->mcategory->name.'.';}

Yii::app()->clientScript->registerMetaTag($seo_description, 'description');

?> 

<div class="row">
    <div class="col-md-7 carousel">



    <div class="connected-carousels">


        <div id="slideshow-area">
            <div id="slideshow-scroller">
                <div id="slideshow-holder">
                    <?php
                    $i=0;
                    foreach ($ad->images as $image):
                    $imagePath = AdImage::getDirPathFullsize($image->image); ?>
                    <div class="slideshow-content">
                        <div style="height: 600px; width: 600px; position: relative;">
                            <img style="max-height: 600px; max-width: 600px; position: absolute; top: 0;
                                        bottom: 0; left: 0; right: 0; margin: auto; background:" src="<?php echo $imagePath; ?>" />
                        </div>
                    </div>
                        <?php
                        $i++;
                    endforeach;
                    if (count($ad->images)==0) {    ?>
                        <div class="slideshow-content">
                        <div style="height: 600px; width: 600px; position: relative;">
                            <img style="max-height: 600px; max-width: 600px; position: absolute; top: 0;
                                        bottom: 0; left: 0; right: 0; margin: auto; background:" src="<?php echo Yii::app()->request->baseUrl.'/images/static/nothumb.jpg'; ?>" />
                        </div>
                    </div>

                    <?php }   ?>
                </div>
            </div>
            <div id="slideshow-previous"></div>
            <?php if (count($ad->images)>1): ?>
                <div id="slideshow-next"></div>
            <?php endif; ?>
        </div>

<?php if (count($ad->images)>1) : ?>
        <div class="navigation">

            <div class="carousel carousel-navigation" data-jcarousel="true">
                <ul style="left: 0px; top: 0px;">
                    <?php
                    $i=0;
                    foreach ($ad->images as $image):
                    $imagePath = AdImage::getDirPathThumbs($image->image);    ?>
                    <li data-jcarouselcontrol="true" class="<?php if ($i=0) echo 'active'; ?>"><img width="50" height="50" alt="" src="<?php echo $imagePath; ?>"></li>
                    <?php
                    $i++;
                    endforeach; ?>
                </ul>
            </div>
             <?php if (count($ad->images)>10) : ?>
                 <a class="prev prev-navigation inactive" href="#" data-jcarouselcontrol="true">Previous</a>
                 <a class="next next-navigation" href="#" data-jcarouselcontrol="true">Next</a>
              <?php endif;   ?>
        </div>

<?php endif; ?>
</div>
</div>

    <div  class="col-md-5"><section>
        <div  class="pdt-buy-box panel panel-no-border panel-default">
            <div  class="panel-body">
                <article  class="pdt-buy-box-overview">
                    <h1  class="pdt-buy-box-title"><?php echo $ad->name; ?></h1>
                    <p class="pdt-buy-box-attributes">
                        <span style="color: #b3b3b3;" class=" glyphicon glyphicon-user" aria-hidden="true"></span>
                        <a  href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$ad->user->urlID)); ?>"><?php echo $ad->user->fio; ?>
                        </a>
                    </p>
                    <p  class="pdt-buy-box-attributes">
                        <span style="color: #b3b3b3;" class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                        <span ><?php echo $ad->price.'&nbsp;'.Yii::t('messages', 'Currency_sign small').'.'; ?></span>
                    </p>

                    <?php if (($ad->hidePhone==1) &&  (!empty($ad->phone))): ?>
                    <p  class="pdt-buy-box-attributes">
                        <span style="color: #b3b3b3;" class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                        <span ><?php echo $ad->phone; ?></span>
                    </p>
                    <?php endif; ?>
                 

                    <?php if ($ad->condition!=Ad::ALL_CONDITION_VALUE): ?>
                    <p  class="pdt-buy-box-attributes">
                        <span style="color: #b3b3b3;" class="glyphicon glyphicon-phone" aria-hidden="true"></span>
                        <span ><?php if ($ad->condition == Ad::NEW_CONDITION_VALUE) echo Yii::t('messages', 'New condition text');
                                 else if ($ad->condition == Ad::BU_CONDITION_VALUE) echo Yii::t('messages', 'Bu condition text'); ?></span>
                    </p>
                    <?php endif; ?>                    <?php if (!empty($ad->mcategory->name)): ?>
                    <p class="pdt-buy-box-attributes">
                        <span style="color: #b3b3b3;" class=" glyphicon glyphicon-th-list" aria-hidden="true"></span>
                        <a  href="<?php echo Yii::app()->createUrl('ads/view',array('mc'=>$ad->mcategory->transName)); ?>"><?php  echo $ad->mcategory->name; ?>
                        </a>
                    </p>                    <?php endif; ?>

                </article>
                <div  class="pdt-buy-box-actions">
                    <?php if ($ad->soldStatus==1): ?>
                    <div>
                        <a  disabled="true" href="#" class="pdt-buy-box-chat btn btn-cta btn-default btn-block">
                            <span><?php echo Yii::t('messages','Sold'); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if ($ad->user->id == Yii::app()->user->id): ?>
                    <div>
                        <a  href="<?php echo Yii::app()->createUrl('ad/edit',array('id'=>$ad->transName)); ?>" class="pdt-buy-box-chat btn btn-cta btn-default btn-block">
                        <span><?php echo Yii::t('messages','Edit ad'); ?></span>
                        </a>
                    </div>
                    <?php endif; ?>
                    <?php if ($ad->user->id != Yii::app()->user->id): ?>
                    <div>
                    <a  href="<?php if(Yii::app()->user->isGuest) echo Yii::app()->createUrl('account/login'); else echo Yii::app()->createUrl('user/chat/create',array('product'=>$ad->transName)); ?>" class="pdt-buy-box-chat btn btn-secondary btn-cta btn-block">
                        <span ><?php echo Yii::t('messages','Chat to Buy'); ?></span>
                    </a>
                    </div>
                    <?php endif; ?>
                    <button  data-link="<?php echo Yii::app()->createUrl('ad/like',array('name'=>$ad->transName)); ?>"
                             data-logged="<?php if(!Yii::app()->user->isGuest) echo 'true'; else echo 'false'; ?>"
                             class="pdt-buy-box-like btn btn-block btn-default btn-cta <?php if ($ad->isliked>0) echo 'pdt-buy-box-like-success'; ?>" style="padding: 0;">
                        <span >
                            <span><?php echo Yii::t('messages','Like This'); ?></span></span>
                        <span  class="pdt-buy-box-likes-count">
                            <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> 
                            <span class="like-nmb"><?php echo $ad->countlikes; ?></span>
                        </span>
                    </button>
                   
                </div>
            </div>
        </div>
    </section>

    <div  class="pdt-social-box panel panel-no-border panel-default">
        <div  class="panel-body">
            <p  class="text-muted">
                <span><?php echo Yii::t('messages','Share This With Friends'); ?></span></p>
            <div  class="pdt-social-icons">
                <script type="text/javascript">(function() {
                  if (window.pluso)if (typeof window.pluso.start == "function") return;
                  if (window.ifpluso==undefined) { window.ifpluso = 1;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                    var h=d[g]('body')[0];
                    h.appendChild(s);
                  }})();</script>
                <script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="#ffffff" data-options="big,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google, moimir,email,print"></div>
            </div>
        </div>
    </div>

    </div>
</div>

<div  class="row">
    <div  class="col-md-7">
        <div  class="pdt-tabs panel panel-no-border panel-default">
            <div  class="panel-body">
                <div >
                    <nav  class="collapse in" role="tablist">
                        <ul  class="nav nav-tabs" role="tablist">
                            <li  role="presentation" class="active">
                                <a  aria-selected="true" tabindex="0" href="" role="tab"><?php echo Yii::t('messages','Description'); ?></a></li>
                           
                        </ul>
                    </nav>
                    <div  class="tab-content">
                        <div  aria-hidden="false" role="tabpanel" class="pdt-tab tab-pane fade active in">
                            <div  class="pdt-description"><div  class="pdt-description-content">
                                <p ><?php echo $ad->text; ?></p>
                            </div>
                                <br>
                                <small  class="pdt-description-time u-absolute u-bottom-right">
                                    <time  class="text-muted">
                                        <span><?php echo Yii::t('messages','Listed on'); ?> </span>
                                        <span><?php echo date('d-m-Y', $ad->time); ?></span>
                                    </time> 
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="col-md-5">
        <aside >
            <h3  class="text-center letterpress-heading mod-dark heading-two">
                <span  class="letterpress-heading-text">
                    <span ><?php echo Yii::t('messages','Meet the seller'); ?></span>
                </span>
            </h3>
            <div  class="pdt-seller panel panel-no-border panel-default">
                <div  class="panel-body">
                    <a  href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$ad->user->urlID)); ?>" class="pdt-seller-profile media" style="margin-bottom: 0">
                        <img   src="<?php
                                if ($ad->user->avatar=='default.jpg') echo Yii::app()->request->baseUrl.'/images/static/default.png';
                                else
                                    echo User::getAvatarFile($ad->user->avatar); ?>" alt="<?php echo $ad->user->fio; ?>" class="pdt-seller-image pull-left media-object img-circle"  style="width: 76px; height: 76px;">
                        <div  class="media-body">
                            <h4  class="media-heading pdt-seller-name"><?php echo $ad->user->fio; ?></h4>
                            <div  class="pdt-seller-reputation" style="padding:0">
                                <?php $this->widget('application.extensions.Rating.RatingWidget', array(
                                    'user' => $ad->user
                                )); ?>
                            </div>
                        </div>
                    </a>
                    <div >
                        <div  class="row card-row" style="display: table;padding-top: 20px; width: 100%;">
                          <?php foreach ($userAds as $userAd): ?>
                           <div  class="col-xs-6">
                               <figure  class="card pdt-card pdt-card-mini">
                                   <div  class="pdt-card-img">   
                                       <a  href="<?php echo Yii::app()->createUrl('ad/view',array('name'=>$userAd->transName)); ?>" class="pdt-card-thumbnail">
                                           <img  src="<?php echo Ad::getAdCoverImage($userAd->images); ?>" alt="Naked brush set"></a>
                                       <button  class="btn btn-default pdt-card-like 
                                          <?php foreach ($userAd->likes as $like):
                                                if ($like->userID == Yii::app()->user->id) echo 'btn-success';
                                                endforeach; ?>"
                                                data-logged="<?php if(!Yii::app()->user->isGuest) echo 'true'; else echo 'false'; ?>"
                                                data-link="<?php echo Yii::app()->createUrl('ad/like',array('name'=>$userAd->transName)); ?>">
                                               <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                                          </button>
                                   </div>
                                   <figcaption  class="pdt-card-caption">
                                       <h4  class="pdt-card-title"><?php echo $userAd->name; ?></h4>
                                   </figcaption>
                               </figure>
                           </div>
                           <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
<div class='row'><div class='col-md-12'><hr style="margin-bottom:5px !important; margin-top:5px !important; " ></div></div>
<div class="pdt-recommend">
<h2  class="text-center letterpress-heading mod-dark heading-two">
   <?php if (count($similarAds)>0): ?>
    <h3 class="text-center letterpress-heading mod-dark heading-two">
                <span class="letterpress-heading-text">
                    <span><?php echo Yii::t('messages','Others also viewed'); ?></span>
                </span>
    </h3>
    <?php endif; ?>
  
</h2>
<div class="row card-row" style="display: table;padding-top: 20px; width: 100%;">
<?php foreach ($similarAds as $similarAd): ?>
  <div class="col-md-3 col-xs-6">
      <?php $this->renderPartial('_similar_item', array('data'=>$similarAd));  ?>
  </div>
<?php endforeach; ?>
</div>
</div>



<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl."/js/jquery.jcarousel.min.js");


Yii::app()->clientScript->registerScript('galleryscript',"
(function($) {
$(function() {
var startVal = 0;
var carouselNavigation = $('.carousel-navigation').jcarousel({
    start: startVal,
});

$('.prev-navigation').click(function() {
    $('.carousel-navigation').jcarousel('scroll', '-=1');
    return false;
});

$('.next-navigation').click(function() {
    $('.carousel-navigation').jcarousel('scroll', '+=1');
    return false;
});

    sel = $('.carousel-navigation li:nth-child(' + startVal + ')').find('img');
    sel.css('border', 'solid 2px blue'); //Here we can format it however we want

    //This function assigns a click event to each item in the carousel and changes which one is selected.
    $('.carousel-navigation img').click(function () {
        sel.css('border', '5px solid #fff');
        $(this).css('border', 'solid 2px grey');
        sel = $(this);
        var selNavLinkIndex = $('.carousel-navigation img').index($(this));

        var cS;
        if ((selNavLinkIndex+1)>currentSlide)
        {
            cS = currentSlide;
            for (var i = cS; i <= selNavLinkIndex; i++){
                showNextSlide();
            }
        }

        if (currentSlide>(selNavLinkIndex+2))
        {
            cS = currentSlide;
            for (var i = (selNavLinkIndex+2); i <= cS; i++){
                showPreviousSlide();
            }
        }

        if ((currentSlide>(selNavLinkIndex+1)) && currentSlide<=(selNavLinkIndex+2) )
        {
                showPreviousSlide();
        }

    });


    function showPreviousSlide()
    {
      currentSlide--;
      updateContentHolder();
      updateButtons();
    }

    function showNextSlide()
    {
      currentSlide++;
      updateContentHolder();
      updateButtons();
    }

    function updateContentHolder()
    {
      var scrollAmount = 0;
      contentSlides.each(function(i){
        if(currentSlide - 1 > i) {
          scrollAmount += this.clientWidth;
        }
      });
      $('#slideshow-scroller').animate({scrollLeft: scrollAmount}, 25);
    }

    function updateButtons()
    {
        if(currentSlide < totalSlides) {
            $('#slideshow-next').show();
        } else {
            $('#slideshow-next').hide();
        }
        if(currentSlide > 1) {
            $('#slideshow-previous').show();
        } else {
            $('#slideshow-previous').hide();
        }
    }

   var totalSlides = 0;
   var currentSlide = 0;
   var contentSlides = '';

  $('#slideshow-previous').click(showPreviousSlide);
  $('#slideshow-next').click(showNextSlide);

  var totalWidth = 0;
  contentSlides = $('.slideshow-content');
  contentSlides.each(function(i){
      totalWidth += this.clientWidth;
      totalSlides++;
  });
  $('#slideshow-holder').width(totalWidth);
  $('#slideshow-scroller').attr({scrollLeft: 0});
  updateButtons();
});
})(jQuery);


$('.showPhoneL').click(function(){
    var parts = ['".substr($ad->user->phone,0,2)."', '".substr($ad->user->phone,2,3)."', '".substr($ad->user->phone,5,15)."'];
    var phone = parts[0] + parts[1] + parts[2];
    $('#showPhoneIn').text('".Yii::t('messages', 'Phone').": '+phone);
    $(this).hide();
    return false;
});

$('.addFavL').click(function(){
    var addFavUrl = '".Yii::app()->createurl('ad/favorite')."';
    var favTransName = '".$ad->transName."';
    $.ajax({
        type: 'GET',
        url: addFavUrl,
        data: 'favTransName='+favTransName,
        success: function(msg){
            if(msg!='')
                window.location.href = '".Yii::app()->createUrl("account/favorites")."';
        }
    });
    return false;
});

var slides = $('.slider .slides').children('.slide');
	var width = $('.slider .slides').width();
	var i = slides.length;
	var offset = i * width;
	i--;
	$('.slider .slides').css('width',offset);

	offset = 0;
	$('#similar_ads .slider .next').click(function(){
		if (offset < width * i) {
			offset += width;
			$('.slider .slides').css('transform','translate3d(-'+offset+'px, 0px, 0px)');
                        $('#similar_ads .slider .next').hide();
                        $('#similar_ads .slider .prev').show();

		}
	});
	$('#similar_ads .slider .prev').click(function(){
		if (offset > 0) {
			offset -= width;
			$('.slider .slides').css('transform','translate3d(-'+offset+'px, 0px, 0px)');
                         $('#similar_ads .slider .next').show();
                        $('#similar_ads .slider .prev').hide();
		}
	});

var slidesMain = $('.sliderMain .slides').children('.slide');
	var widthM = $('.sliderMain .slides').width();
	var iM = slidesMain.length;
	var offsetM = iM * widthM;
	iM--;
	$('.sliderMain .slides').css('width',offsetM);

	offsetM = 0;
	$('#similar_ads .sliderMain .next').click(function(){
		if (offsetM < widthM * iM) {
			offsetM += widthM;
			$('.sliderMain .slides').css('transform','translate3d(-'+offsetM+'px, 0px, 0px)');
                        $('#similar_ads .sliderMain .next').hide();
                        $('#similar_ads .sliderMain .prev').show();

		}
	});
	$('#similar_ads .sliderMain .prev').click(function(){
		if (offsetM > 0) {
			offsetM -= widthM;
			$('.sliderMain .slides').css('transform','translate3d(-'+offsetM+'px, 0px, 0px)');
                         $('#similar_ads .sliderMain .next').show();
                        $('#similar_ads .sliderMain .prev').hide();
		}
	});


   ",CClientScript::POS_READY); ?>
