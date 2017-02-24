<?php
if ($searchForm->type == SearchForm::NEW_AD)
    $searchForm->fieldFolder = '/fields/fields_new_ad';
else if($searchForm->type == SearchForm::VIEW_AD)
    $searchForm->fieldFolder = '/fields/fields_view_ad';
else if($searchForm->type == SearchForm::EDIT_AD)
    $searchForm->fieldFolder = '/fields/fields_new_ad';
else
    $searchForm->fieldFolder = '/fields/fields';

switch ($searchForm->ca) {
    case 1:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;


    case 2:
    $searchForm->subtypeParam = SearchForm::SALE_WANTED;
    if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
        if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
            if ($searchForm->type == SearchForm::SEARCH)
                $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
            else
                $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
    }
    elseif ($searchForm->st==Ad::RENT) {}
    break;


    case 3:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 4:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 5:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 6:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 7:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 8:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 9:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 10:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 11:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 12:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 13:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 14:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 15:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 16:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 17:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 18:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 19:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 20:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 21:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 22:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 23:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 24:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 25:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 26:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 27:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 28:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);

            elseif ($searchForm->stepParam == SearchForm::GET_FIELDS) {
                if ($searchForm->type == SearchForm::NEW_AD)
                    $this->renderPartial($searchForm->fieldFolder.'/_clothing_fields', array('searchForm'=>$searchForm), false, true);
                elseif ($searchForm->type == SearchForm::EDIT_AD)
                    $this->renderPartial($searchForm->fieldFolder.'/_clothing_fields', array('searchForm'=>$searchForm,'ad'=>$ad), false, true);
                elseif ($searchForm->type == SearchForm::VIEW_AD)
                    $this->renderPartial($searchForm->fieldFolder.'/_clothing_fields', array('searchForm'=>$searchForm,'ad'=>$ad), false, true);
            }

            elseif ($searchForm->stepParam == SearchForm::GET_SUBTYPE_AND_FIELDS) {
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
                if ($searchForm->type == SearchForm::EDIT_AD)
                    $this->renderPartial($searchForm->fieldFolder.'/_clothing_fields', array('searchForm'=>$searchForm), false, true);
                elseif ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial($searchForm->fieldFolder.'/_clothing_fields', array('searchForm'=>$searchForm), false, true);
            }
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 29:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 30:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 31:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 32:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 33:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 34:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;

    case 35:
        $searchForm->subtypeParam = SearchForm::SALE_WANTED;
        if (($searchForm->st==Ad::SALE) or ($searchForm->st==Ad::WANTED)){
            if ($searchForm->stepParam == SearchForm::GET_SUBTYPE)
                if ($searchForm->type == SearchForm::SEARCH)
                    $this->renderPartial('/_subtypes', array('searchForm'=>$searchForm), false, true);
                else
                    $this->renderPartial($searchForm->fieldFolder.'/_subtypes', array('searchForm'=>$searchForm), false, true);
        }
        elseif ($searchForm->st==Ad::RENT) {}
        break;



}