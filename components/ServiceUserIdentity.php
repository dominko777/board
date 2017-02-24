<?php
class ServiceUserIdentity extends UserIdentity {
	const ERROR_NOT_AUTHENTICATED = 3;

	/**
	 * @var EAuthServiceBase the authorization service instance.
	 */
	protected $service;
	
	/**
	 * Constructor.
	 * @param EAuthServiceBase $service the authorization service instance.
	 */
	public function __construct($service) {
	    $this->service = $service;
	}
	
	/**
	 * Authenticates a user based on {@link username}.
	 * This method is required by {@link IUserIdentity}.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {        
	    if ($this->service->isAuthenticated) {
	        $this->username = $this->service->getAttribute('name');

            $serviceName=$this->service->getAttribute('serviceName');
            $uid = $this->service->getAttribute('id');
           // var_dump($uid); exit();
         //   var_dump($this->service->getAttribute('name').'-'.$this->service->getAttribute('id')); exit();
            $user=User::model()->find('identity=:identity AND service=:service',array(':identity'=>$uid,':service'=>$serviceName));
            if (empty($user))  
            { 
                $model=new User('register');
                $model->fio=$this->username;  
              //  $salt = $model->generateSalt(); 
                $model->password = $uid;
                $model->password_repeat = $uid;   
                $model->activation_key=1;    
                $model->role="user";
                $model->email = $this->service->getAttribute('id').'@'.$serviceName.'.com';  
                $model->last_visit_date=date('Y-m-d');
                $model->register_date=date('Y-m-d');
                $model->service = $serviceName;
                $model->identity = $this->service->getAttribute('id');  
                if ($model->save())
                {
                    $this->_id=$model->id;
                    $this->_urlID=$model->urlID;
                    $this->email=$model->email;
                   $this->errorCode = self::ERROR_NONE;
                }
                else
                    $this->errorCode = self::ERROR_NONE;  
            }
            else
        {  //var_dump('user exist'); exit();  
            $this->_id=$user->id;
            $this->_urlID=$user->urlID;
            $this->email=$user->email;
            $this->errorCode=self::ERROR_NONE;
        }
	    }
	    else {
	        $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
	    }
	    return !$this->errorCode;  
	}
  
    public function getId() {
		return $this->_id;
	}

	/**
	 * Returns the display name for the identity.
	 * This method is required by {@link IUserIdentity}.
	 *
	 * @return string the display name for the identity.
	 */
	
}