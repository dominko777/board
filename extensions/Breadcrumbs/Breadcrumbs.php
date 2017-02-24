<?php

class Breadcrumbs extends CWidget
{
    /**
     * @var string имя пользователя
     */
    public $category;
    public $mainCategory;
    public $city;
    public $type;
    public $itemCount;
    public $totalItemCount;

    /**
     * Запуск виджета
     */
    public function run()
    {
        $this->render('index', array(
            'category' => $this->category,
            'city' => $this->city,
            'mainCategory'=>$this->mainCategory,
            'type'=>$this->type,
            'itemCount'=>$this->itemCount,
            'totalItemCount'=>$this->totalItemCount,
        ));
    }
}