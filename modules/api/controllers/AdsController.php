<?php
class AdsController extends ApiController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    { 
        return array( 
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('list','news','update','create','delete'  
                    ),
                'users'=>array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array(),
                'users'=>array('@'), 
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    


    public function actionList()
    {
        $criteria = new CDbCriteria;
        $criteria->order= 't.id DESC';
        $criteria->condition= 'published=:published';
        $criteria->params= array(':published'=>1);

        if(isset($_GET['mainCategoryID']))
        {
            $criteria->addCondition('t.mainCategoryID=:mainCategoryID');
            $criteria->params += array(':mainCategoryID' => $_GET['mainCategoryID']);  
        }


        if(isset($_GET['query']))
        {
            $query = trim($_GET['query']);
            $criteria->addCondition('t.name LIKE :name');
            $criteria->params += array(':name' => "%$query%");
        }

        if(isset($_GET['subCategoryID']))
        {
            $criteria->addCondition('t.categoryID=:categoryID');
            $criteria->params += array(':categoryID' => $_GET['subCategoryID']);
        }

        if (isset($_GET['user']))
        {
            $adUser = User::model()->findByPk($_GET['user']);
            $criteria->addCondition('t.userID=:userID');    
            $criteria->params += array(':userID' => $_GET['user']);
        }

        // Did we get some results?
  
            $jSonActiveDataProvider = new JSonActiveDataProvider('Ad', array(
                'attributes' => array('id', 'name', 'text','time','price','soldStatus'),
                'criteria'=>$criteria,     
                'relations' => array(
                                     'user'=> array(
                                        'attributes' => array('fio', 'id','avatar')
                                      ),
                                     'likes'=> array(
                                        'attributes' => array('userID')
                                      ),  
                                      'images'=> array(
                                        'attributes' => array('image')
                                      ),
                ),
                'pagination'=>array('currentPage'=>$_GET['page'],'pageSize'=>40)));
            $this->_sendResponse(200, $jSonActiveDataProvider->getJsonData());

    }

     
    public function actionView()
    {
        // Check if id was submitted via GET
        if(!isset($_GET['id']))
            $this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );

        switch($_GET['model'])
        {
            // Find respective model
            case 'posts':
                $model = Post::model()->findByPk($_GET['id']);
                break;
            default:
                $this->_sendResponse(501, sprintf(
                    'Mode <b>view</b> is not implemented for model <b>%s</b>',
                    $_GET['model']) );
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if(is_null($model))
            $this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
        else
            $this->_sendResponse(200, CJSON::encode($model));
    }


    public function actionCreate()
    {
        switch($_GET['model'])
        {
            // Get an instance of the respective model
            case 'posts':
                $model = new Post;
                break;
            default:
                $this->_sendResponse(501,
                    sprintf('Mode <b>create</b> is not implemented for model <b>%s</b>',
                    $_GET['model']) );
                    Yii::app()->end();
        }
        // Try to assign POST values to attributes
        foreach($_POST as $var=>$value) {
            // Does the model have this attribute? If not raise an error
            if($model->hasAttribute($var))
                $model->$var = $value;
            else
                $this->_sendResponse(500,
                    sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,
                    $_GET['model']) );
        }
        // Try to save the model
        if($model->save())
            $this->_sendResponse(200, CJSON::encode($model));
        else {
            // Errors occurred
            $msg = "<h1>Error</h1>";
            $msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
            $msg .= "<ul>";
            foreach($model->errors as $attribute=>$attr_errors) {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";
                foreach($attr_errors as $attr_error)
                    $msg .= "<li>$attr_error</li>";
                $msg .= "</ul>";
            }
            $msg .= "</ul>";
            $this->_sendResponse(500, $msg );
        }
    }


    public function actionUpdate()
    {
        // Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
        $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
        $put_vars = CJSON::decode($json,true);  //true means use associative array

        switch($_GET['model'])
        {
            // Find respective model
            case 'posts':
                $model = Post::model()->findByPk($_GET['id']);
                break;
            default:
                $this->_sendResponse(501,
                    sprintf( 'Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
                    $_GET['model']) );
                Yii::app()->end();
        }
        // Did we find the requested model? If not, raise an error
        if($model === null)
            $this->_sendResponse(400,
                    sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']) );

        // Try to assign PUT parameters to attributes
        foreach($put_vars as $var=>$value) {
            // Does model have this attribute? If not, raise an error
            if($model->hasAttribute($var))
                $model->$var = $value;
            else {
                $this->_sendResponse(500,
                    sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>',
                    $var, $_GET['model']) );
            }
        }
        // Try to save the model
        if($model->save())
            $this->_sendResponse(200, CJSON::encode($model));
        else
            // prepare the error $msg
            // see actionCreate
            // ...
            $this->_sendResponse(500, $msg );
    }


    public function actionDelete()
    {
        switch($_GET['model'])
        {
            // Load the respective model
            case 'posts':
                $model = Post::model()->findByPk($_GET['id']);
                break;
            default:
                $this->_sendResponse(501,
                    sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
                    $_GET['model']) );
                Yii::app()->end();
        }
        // Was a model found? If not, raise an error
        if($model === null)
            $this->_sendResponse(400,
                    sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']) );

        // Delete the model
        $num = $model->delete();
        if($num>0)
            $this->_sendResponse(200, $num);    //this is the only way to work with backbone
        else
            $this->_sendResponse(500,
                    sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
                    $_GET['model'], $_GET['id']) );
    }


    public function actionNews()
    {
        $relations = Relationship::model()->with('followed')->findAll('follower_id=:follower_id',array(':follower_id'=>$this->getUser()->id));
        $followedIdsArray = array();
        foreach ($relations as $relation){
           array_push($followedIdsArray, $relation->followed->id);  
        }  

        $criteria = new CDbCriteria;
        if ($_GET['type']=='new')
        {
            $criteria->order= 't.id DESC';
            $criteria->compare('published',1);
        }
        elseif ($_GET['type']=='sold'){
            $criteria->order = 't.soldTime DESC';
            $criteria->compare('t.soldTime', '>0');
            $criteria->compare('published',1);
        }

        $criteria->addInCondition('userID',$followedIdsArray);
        $jSonActiveDataProvider = new JSonActiveDataProvider('Ad', array(
                'attributes' => array('id', 'name', 'text','time','price','soldStatus'),
                'criteria'=>$criteria,
                'relations' => array(
                                     'user'=> array(
                                        'attributes' => array('fio', 'id','avatar')
                                      ),
                                      'images'=> array(
                                        'attributes' => array('image')
                                      ),
                ),
                'pagination'=>array('currentPage'=>$_GET['page'],'pageSize'=>40)));
        $this->_sendResponse(200, $jSonActiveDataProvider->getJsonData());



    }

    

    


}
