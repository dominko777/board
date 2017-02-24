<h2>Статистика<h2>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> 
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<?php
Yii::app()->clientScript->registerScriptFile("/js/chartjs/Chart.min.js");  
?>
      
<div class="box box-default color-palette-box">
        <div class="box-body">
        <?php
        $fromDate = (isset($_GET['from'])) ? $_GET['from'] : date('d-m-Y',strtotime('-6 day',strtotime(date('d-m-Y'))));
        $toDate = (isset($_GET['to'])) ? $_GET['to'] : date('d-m-Y');
        $form=$this->beginWidget('CActiveForm', array(
        'id'=>'dateRangeForm',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-register form-center',
        ))); ?>
  
<input type="text"  id="daterangeId" name="daterange" class="pull-left">
<?php 
        /*    echo DateRangePicker::widget([
                'name'=>'date_range_1',
                'useWithAddon'=>true,
                'value'=>$fromDate.' - '.$toDate,
                'language'=>'ru',
                'hideInput'=>true,
                'presetDropdown'=>true,
                'pluginOptions'=>[
                    'locale'=>['format'=>'DD-MM-YYYY'], // from demo config
                    'separator'=>'-',       // from demo config
                    'opens'=>'right',
                  //  'startDate'=>'01-01-2016',
                  //  'endDate'=>'31-01-2016',
                ],
                'pluginEvents'=>[
                   "apply.daterangepicker" => "function() {
                      var rV = $('.range-value').text();
                      var arr = rV.split(' - ');
                      window.location.href = '".Yii::$app->urlManager->createUrl('chart/index')."?from='+arr[0]+'&to='+arr[1];
                   }",
                ]
            ]);*/
       $this->endWidget();  
            ?>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
      </div>

<div class="row">
    <div class="col-md-6">
       <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Новые пользователи<h3>
            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                </button>
                <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
              </div>
             <div class="box-body">
               <div class="chart">
                   <canvas id="userChart"  width="510" height="250"></canvas>
               </div>
             </div>
           </div>
        </div>
    </div>



    <div class="col-md-6">
       <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Новые обьявления<h3>
            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                </button>
                <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
              </div>
             <div class="box-body">
               <div class="chart">
                   <canvas id="scheduleChart"  width="510" height="250"></canvas>
               </div>
             </div>
           </div>
        </div>
    </div>
</div>
<?php

$jsDateArray = array();
$jsValuesArray = array();
foreach($countUsersDateArray as $day) {
    foreach ($day as $k=>$v)
    {
        array_push($jsDateArray,$k);
        array_push($jsValuesArray,$v);
    }

}

$jsScheduleDateArray = array();
$jsScheduleValuesArray = array();
foreach($countAdsArray as $day) {
    foreach ($day as $k=>$v)
    {
        array_push($jsScheduleDateArray,$k);
        array_push($jsScheduleValuesArray,$v);
    }

}  

Yii::app()->clientScript->registerScript('statscript','



var userCtx = document.getElementById("userChart").getContext("2d");

var options = {
   // responsive: true,
   // maintainAspectRatio: true
}

var userData = {
	labels : [\''.implode("','",$jsDateArray).'\'],
	datasets : [
		{
			fillColor : "rgba(172,194,132,0.4)",
			strokeColor : "#ACC26D",
			pointColor : "#fff",
			pointStrokeColor : "#9DB86D",
			data : ['.implode(",",$jsValuesArray).']
		}
	]
}

new Chart(userCtx).Line(userData, options);



var scheduleCtx = document.getElementById("scheduleChart").getContext("2d");

var options = {
   // responsive: true,
   // maintainAspectRatio: true
}

var scheduleData = {
	labels : [\''.implode("','",$jsScheduleDateArray).'\'],
	datasets : [
		{
			fillColor : "#FFE4C4",
			strokeColor : "#dd4b39",
			pointColor : "#fff",
			pointStrokeColor : "#9DB86D",
			data : ['.implode(",",$jsScheduleValuesArray).']
		}
	]
}

new Chart(scheduleCtx).Line(scheduleData, options);

$("input[name=\"daterange\"]").daterangepicker(
    {
    animation: false,
    tooltipTemplate: "<%= value %>", 
    locale: {
        format: "DD-MM-YYYY"
        },
    separator: " - ",
    language : "ru",
    "startDate": "05-01-2016",  
    "endDate": "25-01-2016"
    }
);

$("input[name=\"daterange\"]").on("apply.daterangepicker", function(ev, picker) {
  var rV = $("#daterangeId").val(); 
  var arr = rV.split(" - ");  
  window.location.href = "'.Yii::app()->createUrl('backend/stat/index').'/from/"+arr[0]+"/to/"+arr[1];
});  
',CClientScript::POS_READY);  


