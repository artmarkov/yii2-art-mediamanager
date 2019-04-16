<?php

namespace artsoft\mediamanager\models;

use Yii;
use artsoft\media\models\Media;
use artsoft\helpers\Html;

/**
 * This is the model class for table "{{%media_manager}}".
 *
 * @property int $id
 * @property int $media_id
 * @property string $class
 * @property int $item_id
 * @property int $sort
 *
 * @property Media $media
 */
class MediaManager extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%media_manager}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['media_id', 'class', 'item_id', 'sort'], 'safe'],
            [['media_id', 'item_id', 'sort'], 'integer'],
            [['class'], 'string', 'max' => 256],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::className(), 'targetAttribute' => ['media_id' => 'id']],
            ['sort', 'default', 'value' => function($model) {
                $count = MediaManager::find()->andWhere(['class' => $model->class, 'item_id' => $model->item_id])->count();
                return ($count > 0) ? $count++ : 0;
            }],
        ];
    }

    public function getModelForm()
    {
       return $this->formName();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Media::className(), ['id' => 'media_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMediaList($class, $item_id)
    {
        return self::find()
                ->innerJoin('media', 'media.id = media_manager.media_id')                
                ->where(['class' => $class, 'item_id' => $item_id])                
                ->indexBy('id')
                ->orderBy('sort')
                ->asArray()->all();    
    } 
    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMediaFirst($class, $item_id)
    {
        return self::find()                
                ->innerJoin('media', 'media.id = media_manager.media_id')                
                ->where(['class' => $class, 'item_id' => $item_id])                  
                ->indexBy('id')
                ->orderBy('sort')
                ->asArray()->one();    
    }
    /**
     * 
     * @param type $sortList
     * @return boolean
     */
    public static function sort($sortList) 
    {
        $ret = true;
        
         foreach (explode(',', $sortList) as $sort => $id) :
           $model =  self::findOne($id);
           $model->sort = $sort;
           if(!$model->save()) {
               $ret = false;  
               break;
           }
         endforeach;
//         echo '<pre>' . print_r($sort_new, true) . '</pre>';
        return $ret;
    }
    /**
     * 
     * @return type array
     */
     public static function getMediaThumbList($class, $item_id)
    {
         $data = array();
         
         $items = self::getMediaList($class, $item_id);      
       // echo '<pre>' . print_r($items, true) . '</pre>';
        
        foreach ($items as $key => $item) :
          $content = '';
          $content .= Html::beginTag('div', ['id' => 'media-base']);
          $content .= Html::img(Media::findById($item['media_id'])->getDefaultThumbUrl());
          $content .= Html::endTag('div');
          $content .= Html::beginTag('div', ['id' => 'media-remove']);
          $content .= Html::tag('a','<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>', 
                                    [
                                        'class' => 'btn btn-sm btn-default remove-media-item', 
                                        'data-id' => $item['id'], 
                                        'href' => '#', 
                                        'alt' => '', 
                                        'title' => Yii::t('yee', 'Delete')
                                    ]);
          $content .= Html::endTag('div');
          $data[$key] = ['content' => $content];
            
        endforeach;
        
        return $data;
    } 
}
