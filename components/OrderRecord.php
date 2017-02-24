<?php
class OrderRecord extends CActiveRecord {
    public $orderID;
    public $maxOrderID;
    public $deletedRecordOrderID;

    public function beforeSave() {
     if ($this->isNewRecord)
     {
         $this->orderID = $this->get_orderID(); 
     }

        return parent::beforeSave();
    } 

    private function get_orderID(){
        $criteria=new CDbCriteria;
        $criteria->select='max(orderID) AS maxOrderID';
        $row = $this->find($criteria);
        $orderID = $row['maxOrderID'] + 1;
        return  $orderID;
    }

    public function beforeDelete(){ 
        $this->deletedRecordOrderID = $this->orderID;
        return parent::beforeDelete();
    }

    public function afterDelete(){
        $records = $this->findAll('orderID > :orderID',array(':orderID'=>$this->deletedRecordOrderID));
        $i=$this->deletedRecordOrderID; 
        foreach ($records as $record)
        {
            $record->orderID = $i;
            $record->save(false); 
            $i++;
        }
        return parent::afterDelete();
    }
}

