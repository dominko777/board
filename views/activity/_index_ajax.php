<?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$newAds,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_index_item',
                    'ajaxUpdate'=>false,
                    'template'=>"{items}",
                    
                ));
?>
