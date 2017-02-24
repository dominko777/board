<div class="activity-list-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="media">
                            <a class="activity-link">

                            </a>
                            <span  class="media-left hidden-xs">
                                <img  alt="<?php echo $data->userLogin; ?>" src="<?php echo User::getAvatarImgSrc($data->userAvatar); ?>" class="activity-avatar">
                            </span>

                            <div  class="media-body">
                                <h4  class="media-heading">
                                    <span class="activity-new-icon"><?php echo Yii::t('messages','New'); ?></span>
                                   
                                    <span>
                                        <a href="<?php echo Yii::app()->createUrl('account/user',array('id'=>$data->userUrlID)); ?>"><?php echo $data->userLogin; ?></a>
                                        <span ><?php  echo $data->name; ?></span>
                                    </span>
                                </h4> 
                                <time  class="small text-muted">
                                    <?php echo CHtml::openTag('span',array('class'=>'timeago',
                                     'title'=>date('F j, Y',$data->time),
                                    ));?>
                                    </span>
                                </time> 
                                <figure  class="activity-figure">
                                    <img  alt="<?php echo $data->name; ?>" src="<?php echo Ad::getAdCoverImage ($data->images); ?>">
                                </figure>
                            </div>
                        </div>
                    </div>

                </div>
            </div>