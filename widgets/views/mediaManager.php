<?php

use artsoft\helpers\Html;
use kartik\sortable\Sortable;
use kartik\sortinput\SortableInput;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use artsoft\mediamanager\models\MediaManager;

?>
                    
<?php
    $modelClass = str_replace("\\","\\\\", $model->className());

    $JSInsertLink = <<<EOF
        function(e, data) {      
            
            // console.log(data);            
             var eventData;
            
             eventData = {
                id: '{$model->id}',
                class: '{$modelClass}',          
                media: data.id,
                sortList: $("#carousel-sort").val(),
            };

        $.ajax({
               url: '/admin/mediamanager/default/add-media',
               type: 'POST',
               data: {eventData : eventData},
//               success: function (res) {
//            
//                    $.pjax.reload({
//                          container: "#pjax-carousel-container" 
//                    });
//            
//                   console.log(res);
//               },
//               error: function () {
//                   alert('Error!!!');
//               }
           });
       }
EOF;
?>                    
                    
<?php
//Pjax::begin([
//    'id' => 'pjax-carousel-container',
//    'enablePushState' => false,
//]);
?>
       
        <div class="form-group clearfix">
            <label class="control-label" style="float: left; padding-right: 5px;"><?= Yii::t('yee/media', 'Album') ?></label>               
        </div>
        <?php
        echo SortableInput::widget([
            'name' => 'sort_list',
            'sortableOptions' => ['type' => Sortable::TYPE_GRID],
            'items' => MediaManager::getMediaThumbList($model->className(), $model->id),
            'hideInput' => true,
            'options' => ['id' => 'carousel-sort', 'class' => 'form-control', 'readonly' => false]
        ]);
        //echo '<pre>' . print_r(backend\modules\mediamanager\models\MediaManager::getMediaThumbList('Carousel','1'), true) . '</pre>';
        ?>
<?//php Pjax::end(); ?>

<div class="form-group">

    <?= artsoft\media\widgets\FileInput::widget([
        'name' => 'image',
        'buttonOptions' => ['class' => 'btn btn-primary'],
        'options' => ['class' => 'hidden'],
        'template' => '{input}{button}',
        'thumb' => 'medium',
        'callbackBeforeInsert' => new JsExpression($JSInsertLink),
    ])
    ?>

    <?= Html::a(Yii::t('yee/media', 'To keep order'), ['#'], [
        'class' => 'btn btn-info save-sort',
        
    ]);
    ?>

</div> 

<?php
$js = <<<JS

$('.save-sort').on('click', function (e) {

    e.preventDefault();
   
    $.ajax({
        url: '/artsoft/mediamanager/default/sort-media',
        data: {sortList: $("#carousel-sort").val()},
        type: 'POST',
    });
});

$('.remove-media-item').on('click', function (e) {

    e.preventDefault();
    
    var id = $(this).data('id');

    $.ajax({
        url: '/artsoft/mediamanager/default/remove-media',
        data: {id: id},
        type: 'POST',
    });
});

JS;

$this->registerJs($js);
?>
<?php $this->registerCss('
/**
 * Carousel Kartik SortableInput
 */
.sortable.grid {    
    min-height: 156px !important;
}
.sortable.grid li {   
    min-width: 146px !important;
    min-height: 180px !important;    
}
.sortable li.sortable-placeholder {
    min-width: 146px !important;
    min-height: 180px !important;
}
 #media-base {  
   position: absolute;    
 }
 #media-remove {  
    position: relative; 
    float: center;
    top: 135px; 
 }
');
?>

