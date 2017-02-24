<?php
/* @var $this Main_categoriesController */
/* @var $model Main_categories */

$this->breadcrumbs=array(
	'Main Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Main_categories', 'url'=>array('index')),
	array('label'=>'Manage Main_categories', 'url'=>array('admin')),
);
?>

<h1>Create Main_categories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>