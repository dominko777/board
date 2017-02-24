<?php $this->widget('ext.widgets.EColumnListView', array(
    'dataProvider'=>$lives,
    'itemView'=>'_live_item',
    'ajaxUpdate'=>false,
    'template' => "{items}",
    'columns' => 3,
)); ?>