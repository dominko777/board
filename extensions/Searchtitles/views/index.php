<?php
    if ($st):
        echo ' - ';
            if ($st == Ad::SALE)
                echo Yii::t("messages", "Sale");
            if ($st == Ad::WANTED)
                echo Yii::t("messages", "Needed");

        if ($city->name):
            echo ' - ';
            echo $city->name;
        endif;

             if ($mainCategory):
                if (!$category->name) {
                    echo ' - ';
                    echo $mainCategory->name;
                }
                 else
                 {
                     echo ' - ';
                     echo $mainCategory->name;
                 }

                    if ($category && ($category!=0)):
                        if (!$type->name) {
                            echo ' - ';
                            echo $category->name;
                        }
                        else {
                            echo ' - ';
                            echo $category->name;
                        }


                            if ($type->name):
                                echo ' - ';
                                echo $type->name;
                             endif;
                     endif;
             endif;
    endif;
