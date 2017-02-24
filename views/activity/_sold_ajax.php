<?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$soldAds,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_sold_item',
                    'ajaxUpdate'=>false,
                    'template'=>"{items}",

                ));
?>
 
