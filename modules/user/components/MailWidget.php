<?php

class MailWidget extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $archive;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('chat', array('archive'=>$this->archive )); 
    }
}