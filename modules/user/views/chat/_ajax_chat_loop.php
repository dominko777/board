<?php
     $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$chats,
    'viewData'=>array('archive'=>$archive),
    'itemView'=>'chat_item',
    'ajaxUpdate'=>false,
    'emptyText' => '',                                           
    'template' => "{items}", 
)); ?>
 
