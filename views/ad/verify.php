<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerCssFile($baseUrl.'/css/new_form.css');
$cs->registerCssFile($baseUrl.'/css/jcarousel.connected-carousels.css');
?>
<div id="no_drop_area">
<div id="template_content">
<div id="main">

<section class="lfloat" style="width: 100%;">
<nav style="width: 100%;">
    <ul>
        <li>
            <div>
                <div class="circle lfloat" style="padding: 5px 0 0 1px;">
                    <span>1</span>
                </div>
                <div class="stepTitle lfloat">
                    <?php echo Yii::t('messages', 'Create'); ?>					</div>
            </div>
        </li>
        <li class="active">
            <div>
                <div>
                    <div class="circle lfloat" >
                        <span>2</span>
                    </div>
                    <div class="stepTitle lfloat">
                        <?php echo Yii::t('messages', 'Verify'); ?>
                    </div>
                </div>
            </div>
        </li>


    </ul>
</nav>


<div class="view_wrapper">

        <div class="title" style="padding-top: 88px; width:970px; float:left; padding-left: 16px;">
            <h2><?php echo $ad->name; ?></h2>

        </div>
        <br class="sep">
        <div class="extras">
            <div class="buttons" style="font-weight: normal;">
                <div>
                </div>
            </div>
            <div style="float: left; margin-left: 15px;  margin-top: 15px; margin-bottom: 15px;  text-align: left;">
                <a class="reply_layer" href="<?php echo Yii::app()->createurl('ad/edit',array('id'=>$ad->transName)); ?>"><strong><?php echo Yii::t('messages', 'Edit'); ?></strong></a>
            </div>

            <br class="sep">
        </div>


    <div style="position:relative;" class="view_content ">
        <div class="view_left">
            <?php if (count($ad->images)>0) : ?>
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
                                endforeach; ?>
                            </div>
                        </div>
                        <div id="slideshow-previous"></div>
                        <?php if (count($ad->images)>1) : ?>
                        <div id="slideshow-next"></div>
                        <?php endif; ?>
                    </div>
                    <style>
                        #slideshow-area, #slideshow-scroller {
                            width: 600px;
                            height: 600px;
                            position: relative;
                            overflow: hidden;
                            margin: 0 auto;
                        }

                        #slideshow-area {
                            border: 2px solid lightgrey;
                            // margin: 3px;
                        }
                        #slideshow-holder {
                            height: 600px;
                        }
                        #slideshow-previous, #slideshow-next {
                            width: 50px;
                            height: 50px;
                            position: absolute;
                            background: transparent url("<?php echo Yii::app()->request->baseUrl; ?>/images/static/arrow_sx.png") no-repeat 50% 50%;
                            top: 265px;
                            display: none;
                            cursor: pointer;
                            cursor: hand;
                        }

                        #slideshow-next {
                            display: block;
                            background: transparent url("<?php echo Yii::app()->request->baseUrl; ?>/images/static/arrow_dx.png") no-repeat 50% 50%;
                            top: 265px;
                            right: 0;
                        }

                        .slideshow-content {
                            float: left;
                        }
                    </style>
                    <?php if (count($ad->images)>1) :
                    ?>
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
                        <?php if (count($ad->images)>10) :
                        ?>
                        <a class="prev prev-navigation inactive" href="#" data-jcarouselcontrol="true">Previous</a>
                        <a class="next next-navigation" href="#" data-jcarouselcontrol="true">Next</a>
                        <? endif; ?>
                    </div>
                    <? endif; ?>
                </div>

            <?php endif; ?>




            <div class="annuncio_info">
                <ul>

                    <li class="price">
                        <b>
                            <?php echo Yii::t('messages', 'Price'); ?>

                        </b>
                        <?php echo $ad->price; ?> <?php echo Yii::t('messages', 'Currency_sign'); ?>
                    </li>


                    <?php if ($ad->cityName): ?>
                    <li><b>

                            <?php echo Yii::t('messages', 'City'); ?>

                        </b><?php echo $ad->cityName; ?>
                    </li>
                    <?php endif; ?>

<b>
<li>
                            <?php echo Yii::t('messages', 'Category'); ?>

                        </b><?php echo $ad->mainCategoryName; ?>
                    </li>
                    <?php if ($ad->categoryName): ?>
                    <li>
                        <b>
                            <?php echo Yii::t('messages', 'Subcategory'); ?>
                        </b>
                        <?php echo $ad->categoryName; ?>
                    </li>
                    <?php endif; ?>

                    <?php if ($ad->typeName): ?>
                        <li>
                            <b>
                                <?php echo Yii::t('messages', 'Type'); ?>
                            </b>
                            <?php echo $ad->typeName; ?>
                        </li>
                    <?php endif; ?>

                    <?php //$this->viewAdGetFields($ad); ?>
                </ul>
               <!-- <p id="body_txt">
                    <?php echo nl2br($ad->text); ?>
                </p> -->
                <br class="sep">
                <br class="sep">
            </div>
            <br class="sep">
            <br class="sep">
        </div>
        <br class="sep">
    </div>
</div>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'publish-ad-form',
    'enableAjaxValidation'=>false,
)); ?>
    <?php echo $form->textField($ad,'published',array('style'=>'display:none')); ?>
<?php $this->endWidget(); ?>
<div class="section_footer clearfix">
    <div class="btnGreen" id="btnAiSubmit" style="margin: 0 0 0 25px;""><?php echo Yii::t('messages', 'Publish'); ?></div>
</div>
</article>
</section>
</div>

</div><!-- content -->
</div>
<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript(); ?>
<script type="text/javascript" src="<?php echo $baseUrl.'/js/jquery.jcarousel.min.js'; ?>"></script>

<?php
// $cs->registerScriptFile($baseUrl.'/js/jquery.jcarousel.min.js', CClientScript::POS_HEAD);

Yii::app()->clientScript->registerScript('galleryscript',"


$('#btnAiSubmit').click(function() {
    $('#publish-ad-form').submit();
  });






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

   ",CClientScript::POS_READY); ?>
