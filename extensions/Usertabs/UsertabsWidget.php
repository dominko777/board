<?php

class UsertabsWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $user;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('index', array(
            'user' => $this->user,
        ));
    }
}
 
