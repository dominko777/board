<?php
$this->pageTitle = Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title'); //anytime this view gets called
?>
<div class="col-md-4 col-sm-5">
    <?php $this->widget('ext.User.UserWidget',array('user'=>$user,'ifImFollowing' => $ifImFollowing)); ?>
</div>
<div class="col-md-8 col-sm-7">
    <?php $this->widget('ext.Usertabs.UsertabsWidget',array('user'=>$user)); ?>
    <div class="profile-tab-content-container">
        <div class="row card-row" >
        <?php
                $today = date('Y-m-d');
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$userFollowing,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_user_following',
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
</div>
 
