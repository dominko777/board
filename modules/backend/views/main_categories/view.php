<?php
/* @var $this Main_categoriesController */
/* @var $model Main_categories */

$this->breadcrumbs=array(
	'Main Categories'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Main_categories', 'url'=>array('index')),
	array('label'=>'Create Main_categories', 'url'=>array('create')),
	array('label'=>'Update Main_categories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Main_categories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Main_categories', 'url'=>array('admin')),
);
?>

<h1>View Main_categories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'orderID',
	),
)); ?>
<a style="margin-top: 15px;" class="btn btn-success btn-lg" href="<?php echo Yii::app()->createUrl('backend/main_categories/admin'); ?>"><span aria-hidden="true" class="glyphicon glyphicon-ok"></span>&nbsp;<?php echo Yii::t('admin', 'Ok'); ?></a>
