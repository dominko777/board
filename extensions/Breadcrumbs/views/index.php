<?php
echo '<ol class="breadcrumb breadcrumb-cs">';
    echo '<li><a href="'.Yii::app()->createUrl('site/index').'">'.Yii::t('messages', 'Home').'</a></li>';


        if (isset($city->name)):
            echo '<li>';
            echo $city->name;
            echo '</li>';
        endif;

             if (isset($mainCategory->name)):
                if (!isset($category->name)) {
                    echo '<li>';
                    echo $mainCategory->name;
                    echo '</li>';

                }
                 else
                 {
                     echo '<li>';
                     echo $mainCategory->name;
                     echo '</li>';
                 }

                    if (isset($category) && (!empty($category))):
                        /*
                        else {
                            echo '&gt';
                            echo '<a  href="'.Yii::app()->createUrl('ads/view',array('mc'=>$category->mainCategory->transName,'ca'=>$category->transName)).'">';
                            echo $category->name;
                            echo '</a>';
                        }


                            if ($type->name):
                                echo '&gt';
                                echo '<span style=\'font-weight: bold; margin-left: 20px;\'>';
                                echo $type->name;
                                echo '</span>';
                             endif; */
                     endif;
             endif;

if ($itemCount!=0) {
    echo '<li>';
    echo  Yii::t('messages', 'Found').'&nbsp'.$itemCount.'&nbsp'.Yii::t('messages', 'from').'&nbsp'.$totalItemCount;
    echo '</li>';
    } 
echo '</ol>';
