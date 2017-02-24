<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jcarousel.connected-carousels.css" media="screen" />
<div id="template_content">

<div id="content">


<div class="view_wrapper">
<div class="view_header">
    <div class="title">
        <h1 id="subject_ad"><?php echo $ad->name; ?></h1>
        <div class="price"><?php echo $ad->price; ?> CNY</div>
    </div>
    <br class="sep">
    <div class="extras">
        <div class="buttons" style="font-weight: normal;">
            <div>
             </div>
        </div>
        <div style="float: left; margin-top: -15px; text-align: right;">
            <a class="reply_layer" href="<?php echo Yii::app()->createurl('ad/edit',array('id'=>$ad->urlID)); ?>"><strong>Edit</strong></a>
        </div>
        <div class="date_user">
            <div><?php echo $ad->date_time; ?></div>
            <div class="user_extra_info">
                <a href="#reply_layer" class="reply_layer"><strong><?php echo $ad->userFio;  ?></strong></a>

            </div>
        </div>
        <br class="sep">
    </div>
</div>

<div style="position:relative;padding-bottom: 40px;" class="view_content ">
<div class="view_left">
<?php if (count($ad->images)>0) :
    ?>


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
            <div id="slideshow-next"></div>
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
                margin: 3px;
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
            <a class="prev prev-navigation inactive" href="#" data-jcarouselcontrol="true">Previous</a>
            <a class="next next-navigation" href="#" data-jcarouselcontrol="true">Next</a>
        </div>
    </div>

<?php endif; ?>




<div class="annuncio_info">

    <img class="hide" id="annuncio_imgprint" src="http://s.sbito.it/images/18/18155355419764.jpg" alt="" title="IPhone 6 Plus 64 GB Originale">


    <ul>

        <li class="price">
            <b>
                Price

            </b>
            <?php echo $ad->price; ?> CNY
        </li>



        <li><b>

                City

            </b><?php echo $ad->cityName; ?></li>
        <li><b>

                Category

            </b><?php echo $ad->categoryName; ?></li>
<?php $this->viewAdGetFields($ad); ?>
    </ul>
    <p id="body_txt">
        <?php echo $ad->text; ?>
    </p>
    <br class="sep">
    <br class="sep">
</div>
<br class="sep">
<br class="sep">
</div>
<div class="view_right">
    <div class="box" id="mpu_placeholder">
        <div id="EAS_fif_13714" class="wsz" data-pid="7475" style="width: 300px; height: 250px; ">
        </div>
    </div>
    <div class="box_sponsor" id="bs_textlinks" style="display:none"></div>

</div>
<br class="sep">
</div>
</div>
</div>
</div>
<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.jcarousel.min.js');

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





   ",CClientScript::POS_READY); ?>
