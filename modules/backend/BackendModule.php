<?php

class BackendModule extends CWebModule
{
	public function init()
	{
                $this->setLayoutPath(Yii::getPathOfAlias('admin.views.layouts'));
                $this->layout="adminLayout";

		

		$this->setImport(array(
			'backend.models.*',
			'backend.components.*',
		)); 

	}


	
}
