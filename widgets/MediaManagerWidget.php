<?php
namespace artsoft\mediamanager\widgets;

use yii\base\Widget;

/**
 * Description of ItemProgrammWidget
 *
 * @author artmarkov
 */
class MediaManagerWidget extends Widget {
    
    public $model;

    public function run() {
  
        return $this->render('mediaManager', [
                    'model' => $this->model
                    
        ]);
    }

}
