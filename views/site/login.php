<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1>Login</h1>

<p><h2>Do you already have an account on one of these sites? Click the logo to log in with it here:</h2>
<?php Yii::app()->eauth->renderWidget(); ?></p>
   