<?php

Yii::app()->clientScript->registerMetaTag(Yii::t('messages', 'Seo description for search page'), 'description');
        $title = Yii::t('messages', 'Sale').' - '.Yii::t('messages', 'Name of site').' - '.Yii::t('messages', 'Site description for page title');
    if (isset($activeCity->name)):
        $title .= ' - ';
        $title .= $activeCity->name;
    endif;
    if (isset($activeMainCategory->name)):
            $title .= ' - ';
            $title .= $activeMainCategory->name;


        if ((isset($activeCategory->name)) && ($activeCategory!='0')):
                $title .= ' - ';
                $title .= $activeCategory->name;
        endif;
    endif;

$this->pageTitle = $title;
?>
<?php
$this->widget('ext.timeago.JTimeAgo', array(
    'selector' => ' .timeago',

));
?>
<div id="content_m">
<div id="row">


<div class="col-md-12 col-lg-12 col-xs-12">
<?php
$form=$this->beginWidget('CActiveForm', array(
                'id'=>'search-form',
                'enableClientValidation'=>false,
                'method'=>'GET',
                'action'=>'/ads/search',
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                            'class'=>'browse-filters form-inline',
                ),
 )); ?>
    <div  class="browse-other-filters">
        <div  class="browse-filter-group">
            <div  class="form-group">
                    <label  for="filter-category" class="browse-filter-label">
                        <span ><?php echo Yii::t('messages', 'What you search?'); ?></span>
                    </label>
                    <input value="<?php echo $searchForm->q; ?>" id="searchtext" name="q"  class="form-control">
            </div>
        </div>
        <div  class="browse-filter-group">
            <div  class="form-group">
                <label  for="filter-category" class="browse-filter-label">
                    <span ><?php echo Yii::t('messages', 'In what category?'); ?></span>
                </label>
                <select  id="mc_s" name="mc" class="form-control browse-filter-fc browse-filter-select">
                <option value="0" selected="selected"><?php echo Yii::t('messages', 'All categories'); ?></option>
                <?php
                    foreach ($main_categories as $main_category): ?>
                        <option <?php if ($searchForm->mc == $main_category->transName) echo 'selected="selected"'; ?> value="<?php echo $main_category->transName; ?>"><?php echo $main_category->name; ?></option>
                       <?php
                 endforeach; ?>
            </select>
            </div>
        </div>
        <div  class="browse-filter-group">
            <div class="form-group">
                <label  for="c" class="browse-filter-label">
                    <span ><?php echo Yii::t('messages', 'City?'); ?></span>
                </label>
                <?php echo $form->dropDownList($searchForm, 'c',  CHtml::listData($cities, 'transName', 'name'), array('class'=>'form-control browse-filter-fc browse-filter-select','name'=>'c','prompt'=>Yii::t('messages', 'All cities'))); ?>
            </div>
        </div>

        

        <div  class="browse-filter-group">
        <div  class="dropdown btn-group">
 

            <div id="popoverInner" style="display: none;">
                <label for="categoryBlock"><?php echo Yii::t('messages', 'In what subcategory?'); ?></label>
        <div class="form-group" style="float: left;">
            <select  id="ca_s" <?php if (!isset($activeCategory)): ?> disabled="disabled" <?php endif; ?> name="ca">
                <option value=""  selected="selected"><?php echo Yii::t('messages', 'Select subcategory'); ?></option>
                <?php

                if ((isset($activeCategory->transName)) && (isset($searchForm->mc))):
                  $mainCategory = Main_categories::model()->find('transName=:transName',array(':transName'=>$searchForm->mc));
                  $catzz = Categories::model()->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>$mainCategory->id),'order'=>'name ASC'));
                    foreach ($catzz as $cat):  ?>
                        <option <?php  if ($activeCategory->transName == $cat->transName) echo 'selected="selected"'; ?> value="<?php echo $cat->transName; ?>"><?php echo $cat->name; ?></option>
                    <?php
                    endforeach;
                endif;


                if ((isset($activeMainCategory->transName)) && (!isset($searchForm->ca))):
                    $mainCategory = Main_categories::model()->find('transName=:transName',array(':transName'=>$searchForm->mc));
                    $catzz = Categories::model()->findAll(array('condition'=>'mainCategoryID=:mainCategoryID','params'=>array(':mainCategoryID'=>$mainCategory->id),'order'=>'name ASC'));
                    foreach ($catzz as $cat):  ?>
                        <option  value="<?php echo $cat->transName; ?>"><?php echo $cat->name; ?></option>
                    <?php
                    endforeach;
                endif;

                ?>
             </select>
            </div>
            <div class="form-group"  style="float: left;">
                <label class="price_label"><?php echo Yii::t('messages', 'Condition'); ?></label>
                <?php echo CHtml::dropDownList('condition','',
                    array(
                        Ad::ALL_CONDITION_VALUE=>Yii::t('messages', 'All condition text'),
                        Ad::NEW_CONDITION_VALUE=>Yii::t('messages', 'New condition text'),
                        Ad::BU_CONDITION_VALUE=>Yii::t('messages', 'Bu condition text'),
                    ),
                    array('prompt'=>Yii::t('messages', 'Choose condition'),'options' => array($searchForm->pm=>array('selected'=>true)))); ?>
            </div>
            <div class="form-group">
                <label for="po"><input type="checkbox" id="photos-only" name="photos" /> <span><?php echo Yii::t('messages', 'Only with photo'); ?></span></label>
            </div>
            </div>


            <button data-placement="bottom" template='<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content"><label class="price_label">"<?php echo Yii::t("messages", "Condition"); ?>"</label></div></div>' data-toggle="popover"   aria-expanded="false" aria-haspopup="true" type="button" id="dropdown-custom-menu" class="dropdown-toggle btn-sm cs-dropdown-toggle btn btn-default">
                <span ><?php echo Yii::t('messages','More Filters'); ?></span>
                <span >
                    <span> </span><span  class="caret">

                    </span>
            </span></button>

        </div>
    </div>
        
        <div  class="browse-filter-group">
            <button class="btn btn-lg btn-primary" value="<?php echo Yii::t('messages', 'Search'); ?>" id="submitSearchForm"><?php echo Yii::t('messages', 'Search'); ?></button>
        </div>

    </div>
<?php $this->endWidget(); ?>
</div>



</div>
</div>



 <?php
 $cs = Yii::app()->getClientScript();


 Yii::app()->clientScript->registerScript('search1script',"
       $('[data-toggle=\'popover\']').popover({
       container: 'body',
       html : true,
       content: function() {
        return $('#popoverInner').html();
      }
       })

 

        $('#mc_s').on('change',function(e) {
            var mcTransName = $('#mc_s option:selected').val();
            var url = '".Yii::app()->createurl('ad/getSearchCategories')."';
            $.ajax({
                url: url,
                method: 'GET',
                data: 'cmTransName='+mcTransName,
                success: function(response)
                {
                    $('select#ca_s').empty().append(response);
                    if (response.length>50)
                    {
                        $('select#ca_s').attr('disabled', false);
                    }
                    else
                    {
                        $('select#ca_s').attr('disabled', true);
                    }
                }
            }); 
        })



        $('div.searchbutton').on('click', function(){
                $('#search-form').submit();
        })



        $('#submitSearchForm').on('click', function(){
                search();
                return false;
        })


 

        function search(){
            $('#main_ads_list').fadeTo('fast', 0.2);
            var searchUrl = '".Yii::app()->createurl('ads/search')."';
            searchUrl = searchUrl + '?' + $('#search-form').serialize()+getSubCategoryParameter()+getConditionParameter()+getPhotoParameter();
                $.ajax({
                url: searchUrl,
                method: 'GET',
                success: function(response)
                {
                   $('#main_ads_list').remove();
                   $('#content_m').append(response);
                }
            });
        }



        function getSubCategoryParameter(){
            var subCategoryParameter = ''; 
            var subCategoryId = $('.popover select#ca_s').val(); 
            if (subCategoryId)
                subCategoryParameter = '&ca='+subCategoryId;

            return subCategoryParameter;
        }
        
        function getConditionParameter(){
            var conditionParameter = '';
            var conditionId = $('.popover select#condition').val();
            if (conditionId)
                conditionParameter = '&condition='+conditionId;

            return conditionParameter;
        }

        function getPhotoParameter(){
            var photoParameter = '';
            var photoId = $('.popover input#photos-only').prop('checked') ? 1 : 0;
            if (photoId)
                photoParameter = '&photos='+photoId;

            return photoParameter;
        }



    ",CClientScript::POS_READY);
?>



<!------------------------ Main List--------------------------->
    <?php  echo
    $this->renderPartial('_main_ads_list', array(
    'ads'=>$ads,
    'activeMainCategory'=>$activeMainCategory,
    'activeCategory'=>$activeCategory,
    'activeCity'=>$activeCity,
    'activeProperty'=>$searchForm->f,
    ));  ?>
</div>
