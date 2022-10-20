<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id_events
 * @property string|null $type_event 1->Load Video, 2-> Answer api , 3-> Find Word
 * @property string|null $description
 * @property string|null $dateevent
 * @property int|null $video_id
 *
 * @property Videos $video
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dateevent'], 'safe'],
            [['video_id'], 'default', 'value' => null],
            [['video_id'], 'integer'],
            [['type_event'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 255],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Videos::className(), 'targetAttribute' => ['video_id' => 'id_videos']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_events' => '#',
            'type_event' => 'Type Event',
            'description' => 'Description',
            'dateevent' => 'Time Event',
            'video_id' => 'Identifier Video on BD',
        ];
    }

    /**
     * Gets query for [[Video]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Videos::className(), ['id_videos' => 'video_id']);
    }
}
