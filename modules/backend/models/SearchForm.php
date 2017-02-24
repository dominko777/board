<?php

class SearchForm extends CFormModel
{
    public $ca; //category
    public $c; //city
    public $st; //search type
    public $mc; //main category
    public $condition;
    public $photos; //how many photos

    public $pm; //vehicle price min
    public $pma; //vehicle price max
    public $q; //query
    public $f; //property
    public $t; //type or subsubcategory
    public $view;

    public $s; //sex

    public $type;

    const ALL_PAGE =1;
    const PARTIAL_PAGE =2;


    const SEARCH = 1;
    const DYNAMIC_SEARCH = 2;
    const NEW_AD = 3;
    const VIEW_AD = 4;
    const EDIT_AD = 5;

    public $stepParam;
    const GET_SUBTYPE = 1;
    const GET_FIELDS = 2;
    const GET_SUBTYPE_AND_FIELDS = 3;

    public $subtypeParam;
    const SALE_WANTED = 1;
    const SALE_RENT_WANTED = 2;

    public $fieldFolder;

    public $sex;
    const MALE = 1;
    const FEMALE = 2;


    public static function getField ($searchForm, $filterAbbr) {
        switch ($filterAbbr){
            case 'cb': return $searchForm->cb; break;
            case 'cm': return $searchForm->cm; break;
            case 'pm': return $searchForm->pm; break;
            case 'pma': return $searchForm->pma; break;
        }
    }
}
