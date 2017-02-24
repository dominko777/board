<?php switch ($categoryID) {
    case 1:
        if (($searchType==Ad::SALE) or ($searchType->st==Ad::WANTED)){
            $this->renderPartial('form_fields/car_fields', array('searchForm'=>$searchForm));
        }
        elseif ($searchType->st==Ad::RENT)
            break;
    case 2:
        break;
}