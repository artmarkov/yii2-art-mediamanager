<?php

namespace artsoft\mediamanager\controllers;

use Yii;


/**
 * DefaultController implements the CRUD actions for backend\modules\mediamanager\models\MediaManager model.
 */
class DefaultController extends \backend\controllers\DefaultController
{
    public $modelClass  = 'artsoft\mediamanager\models\MediaManager';
     
    /**
     * 
     * @return type
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionAddMedia() {

        if (!Yii::$app->request->isAjax) {
             throw new NotFoundHttpException(Yii::t('art', 'Requires a parameter with AJAX.'));
        }

        $eventData = Yii::$app->request->post('eventData');

        if (empty($eventData)) {
            throw new NotFoundHttpException(Yii::t('art/media', 'Photo not found.'));
        }

        $model = new $this->modelClass;
        $model->item_id = $eventData['id'];
        $model->media_id = $eventData['media'];
        $model->class = $eventData['class'];

//         echo '<pre>' . print_r($model, true) . '</pre>';
        if ($model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('art/media', 'Your photo was successfully added.'));
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            throw new HttpException(404, 'Page not found');
        }
    }
    /**
     * 
     * @return boolean
     * @throws NotFoundHttpException
     */
     public function actionSortMedia() {

        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException(Yii::t('art', 'Requires a parameter with AJAX.'));
        }

        $sortList = Yii::$app->request->post('sortList');

        if (empty($sortList)) {
            throw new NotFoundHttpException(Yii::t('art/media', 'Photo not found.'));
        }
      
        // echo '<pre>' . print_r($eventData, true) . '</pre>';
        if ($this->modelClass::sort($sortList)) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('art/media', 'Sort data saved.'));
            return $this->redirect(Yii::$app->request->referrer);
            //return true;
        } else {
            return false;
        }
    }
    /**
     * 
     * @return type
     * @throws NotFoundHttpException
     * @throws HttpException
     */
     public function actionRemoveMedia() {

        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException(Yii::t('art/media', 'Photo not found.'));
        }

        $id = Yii::$app->request->post('id');

        if (empty($id)) {
           throw new HttpException(404, 'Page not found');
        }
        $model = $this->findModel($id);
       
         //echo '<pre>' . print_r($model, true) . '</pre>';
        if ($model->delete()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('art/media', 'Your photo has been removed.'));
            return $this->redirect(Yii::$app->request->referrer); 
        } else {
           throw new NotFoundHttpException(Yii::t('art/media', 'Photo not found.'));
        }
    }

}