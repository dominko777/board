<?php
$this->pageTitle=$model->name;
if(Yii::app()->user->hasFlash('success')):?>
                    <p class="bg-success  main-site-messages">
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                    </p>
                <?php endif; ?>   
            <div class="row">


                <div class="col-md-8">
                 <div class="row card-row" style="margin-bottom: 20px;">
        <?php
                $today = date('Y-m-d');
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$ads,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_group_ad_item',
                    'pager' =>'CPager',
                    'ajaxUpdate'=>true,
                 //   'columns' => 3,
                    'enablePagination'=>true,
                 //   'enableHistory' => true,  
                 //   'ajaxUrl'=>Yii::app()->createurl('ads/search').'?Ad_page_2&mc=kukhnya',
                    'afterAjaxUpdate' => 'function(id, data){
                       // changeBrowserUrl($.fn.yiiListView.getUrl(id));
                        $("html, body").animate({scrollTop: $(".navbar").position().top }, 100);}'
                ));
                ?>
                     
          </div>
     </div>


                <div class="col-md-4">
                    <div class="panel seller-namecard">
                      <div class="media">

                          <span class="pull-left">

                          <img src="<?php echo Yii::app()->request->baseUrl.'/images/groups/'.$model->photo; ?>" class="img-circle media-object pretty-border">


                          </span>



                          <!--<div class="text-muted">На сайте с&nbsp;2016&nbsp;года</div>-->
                       
                       <div class="media-body" style="vertical-align: top">
                           <h3 class="media-heading">
                            <?php echo $model->name; ?></h3> 
                          <?php echo $model->description; ?>
                          <!--<div class="text-muted">На сайте с&nbsp;2016&nbsp;года</div>-->
                        </div>


                      </div>


                    </div>
                    <!--<div class="panel">
                        <div class="panel-body">
                            <div id="feedback_ratings" style="padding-left: 4px;">
                               <a  onclick = " return false;" href="">
                                <div class="score">
                                    <span class="spr pos"></span>
                                    <span class="num pos_r"></span>
                                    <div class="cf"></div><span class="txt"></span>
                                    </div>
                               </a>
                            <a  onclick = " return false;" href="">
                                <div class="score">
                                      <span class="spr nei"></span>
                                      <span class="num neu_r"></span>
                                      <span class="txt"></span>
                                </div>
                            </a>

                            <a  onclick = " return false;" href="">
                                <div class="score">
                                    <span class="spr neg"></span>
                                    <span class="num neg_r"></span>
                                    <span class="txt"></span>
                                </div>
                               </a>
                            </div>
                        </div>
                    </div>-->
                    <div class="panel">
                            <div class="panel-body">
                                <a class="btn btn-primary manage_block_button" style="width: 100%;  " href="<?php echo $this->createUrl('group/edit',array('id'=>$model->id)); ?>">Подписаться</a>

                                <?php if(Yii::app()->user->id == $model->owner_id): ?>
                                    <a class="btn btn-default manage_block_button" style="width: 100%" href="<?php echo $this->createUrl('group/edit',array('id'=>$model->id)); ?>">Редактировать группу</a>
                                    <a class="btn btn-default" style="width: 100%" href="<?php echo $this->createUrl('group/edit',array('id'=>$model->id)); ?>">Заявки (5)</a>
                                <?php endif; ?>
                                            </div>
                        </div>

                    <div class="panel">
                            <div class="panel-body">
                               <a class="header_block">  
                                  <div class="header_top clearfix">
                                    Подписчики
                                  </div>  
                                  <div class="header_bottom">
                                    1<span class="follow_number"> </span>896 подписчиков
                                  </div>
                                </a>
                                <div class="public_followers row">
                                    <?php
                                    $user=User::model()->findByPk(Yii::app()->user->id);  
                                    for ($i=0;$i<9; $i++) { ?>
                                    <div class="col-md-4">
                                    <figure class="card user-card" style="margin-top:0;">
                                      <a href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$data->follower->urlID)); ?>">
                                          <img class="img-circle pretty-border  follow" src="<?php

                                              echo User::getAvatarImgSrc($user->avatar); ?>">
                                        <figcaption class="caption">
                                          tryrty  
                                        </figcaption>
                                      </a>
                                       </figure>
                                    </div>
                                          
                                    <?php } ?>  
                                </div>
                            </div>
                    </div>

                    <div class="panel">
                            <div class="panel-body">
                               <div class="header_block">
                                  <div class="header_top clearfix">
                                    Администратор
                                  </div>
                               </div>
                                <figure style="margin-top:0;" class="small-user-card">
                                      <a href="/account/user/">
                                          <img src="/images/static/default.png" class="img-circle pretty-border  small_user_icon_img">
                                          <div style="padding: 21px 11px 21px 9px;float: left;">sdfsd</div>
                                      </a>
                                </figure>
                              
                            </div>
                    </div>



                </div>  
            </div>


</div>

<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#followersModal">Open Info Modal</button>

<!-- Modal -->
<div id="followersModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Участники группы <?php echo $model->name; ?> </h4>
      </div>
      <div class="modal-body">
          <form action="/ads/view" role="search" class="navbar-form" id="nav-search-form" style="padding-left: 0px !important;">
        <div class="input-group">
            <input type="text" id="srch-term" name="q" placeholder="Найти" class="form-control">
            <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form> 
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>

  </div>
</div>  
 
