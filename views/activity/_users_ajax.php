<?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider'=>$followers,
                    'summaryText'=>'',
                    'emptyText' => '',
                    'itemView'=>'_users_item',
                    'ajaxUpdate'=>false,
                    'template'=>"{items}",

                ));
?>
