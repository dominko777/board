<?php

class Searchtitles extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $category;
    public $mainCategory;
    public $city;
    public $st;
    public $type;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('index', array(
            'category' => $this->category,
            'city' => $this->city,
            'st'=>$this->st,
            'mainCategory'=>$this->mainCategory,
            'type'=>$this->type
        ));
    }
}