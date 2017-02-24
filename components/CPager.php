<?php

class CPager extends CLinkPager
{

    public function run()
    {
        $this->registerClientScript();
        $buttons=$this->createPageButtons();
        if(empty($buttons))
            return;
        //echo $this->header;
        echo '<div style="float:left; width: 100%; text-align: center; padding:15px 0;">';
        echo CHtml::tag('ul class="pagination pagination-sm"',$this->htmlOptions,implode("\n",$buttons));
        echo '</ul>';
        echo '</div>';
        echo $this->footer;
    }


    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        if ($selected) 
            return '<li class="active">'.CHtml::link($label,$this->createPageUrl($page),array('class'=>$class)).'</li>';
        return '<li>'.CHtml::link($label,$this->createPageUrl($page),array('class'=>$class)).'</li>';
    }



} ?>