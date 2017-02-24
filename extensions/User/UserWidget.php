<?php

class UserWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $user;
    public $ifImFollowing;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('index', array(
            'user' => $this->user,
            'ifImFollowing' => $this->ifImFollowing, 
        ));
    }
}
 
