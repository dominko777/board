<?php
/* @var $this Main_categoriesController */
/* @var $model Main_categories */

$this->breadcrumbs=array(
	'Main Categories'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Main_categories', 'url'=>array('index')),
	array('label'=>'Create Main_categories', 'url'=>array('create')),
	array('label'=>'View Main_categories', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Main_categories', 'url'=>array('admin')),
);
?>

<h1>Update Main_categories <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>