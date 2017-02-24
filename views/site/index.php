<?php
$this->pageTitle = Yii::t('messages', 'Name of site').'-'.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
Yii::app()->clientScript->registerMetaTag(Yii::t('messages', 'Seo description for index page'), 'description');
?>
<div class="row">
    <div class="visible-lg col-lg-2">
        <div class="browse-sidebar-col">
            <div  class="browse-categories">
            <h4  class="browse-category-heading"><span><?php //echo Yii::t('messages','Shop by category'); ?></span></h4>
            <?php foreach ($mainCategories as $mainCategory): ?>
            <ul  class="browse-category">
                <li  class="browse-category-label"><span><?php echo $mainCategory->name; ?></span></li>
                <?php foreach ($mainCategory->categoriesOrderID as $category): ?>
                <li  class="browse-category-item">
                    <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>$mainCategory->transName,'ca'=>$category->transName)); ?>"><?php echo $category->name; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endforeach; ?>
            </div>
        </div>   
    </div>


    
    <div class="col-md-12 col-lg-10">  
        <div  class="row discover-collection" style="margin-top: 0px">
            <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>'odejda-i-aksesuary')); ?>">
                <span  class="discover-collection-title">
                    <span>Одежда и аксессуары</span></span>
                <span  class="small u-mar-left">
                    <span style="padding-left: 3px;"><?php echo Yii::t('messages','View more'); ?></span>
                </span>
            </a>
            <div style="display: table; ">
            <?php foreach ($adsCategoryOne as $adCategoryOne):

          $this->renderPartial('_index_item', array('data'=>$adCategoryOne));
            endforeach; ?>
             </div>
        </div>
        
        <hr class="c-hr">
        <div  class="row discover-collection">
            <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>'dom-i-obraz-jizni')); ?>">
                <span  class="discover-collection-title">
                    <span>Дом и образ жизни</span></span>
                <span  class="small u-mar-left">
                    <span style="padding-left: 3px;"><?php echo Yii::t('messages','View more'); ?></span>
                </span>
            </a>
            <div style="display: table; ">
            <?php foreach ($adsCategoryTwo as $adCategoryTwo):
          $this->renderPartial('_index_item', array('data'=>$adCategoryTwo)); 
            endforeach; ?>
             </div>
        </div>
        <hr class="c-hr">
        <div  class="row discover-collection">
            <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>'hobby_i_gadjety')); ?>">
                <span  class="discover-collection-title">
                    <span>Хобби и гаджеты</span></span>
                <span  class="small u-mar-left">
                    <span style="padding-left: 3px;"><?php echo Yii::t('messages','View more'); ?></span>
                </span>
            </a>
            <div style="display: table; ">
            <?php foreach ($adsCategoryThree as $adCategoryThree):
          $this->renderPartial('_index_item', array('data'=>$adCategoryThree));
            endforeach; ?>
             </div>
        </div>
        <hr class="c-hr">
        <div  class="row discover-collection">
            <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>'razvlecheniya')); ?>">
                <span  class="discover-collection-title">
                    <span>Развлечения</span></span>
                <span  class="small u-mar-left">
                    <span style="padding-left: 3px;"><?php echo Yii::t('messages','View more'); ?></span>
                </span>
            </a>
            <div style="display: table; ">
            <?php foreach ($adsCategoryFour as $adCategoryFour):
          $this->renderPartial('_index_item', array('data'=>$adCategoryFour));
            endforeach; ?>
             </div>
        </div>
        <hr class="c-hr">
        <div  class="row discover-collection">
            <a  href="<?php echo $this->createUrl('ads/view',array('mc'=>'drugoe')); ?>">
                <span  class="discover-collection-title">
                    <span>Другое</span></span>
                <span  class="small u-mar-left">
                    <span style="padding-left: 3px;"><?php echo Yii::t('messages','View more'); ?></span>
                </span> 
            </a>
            <div style="display: table; ">
            <?php foreach ($adsCategoryFive as $adCategoryFive):
          $this->renderPartial('_index_item', array('data'=>$adCategoryFive));
            endforeach; ?>
             </div>
        </div>

    
        

    </div>
    
</div>