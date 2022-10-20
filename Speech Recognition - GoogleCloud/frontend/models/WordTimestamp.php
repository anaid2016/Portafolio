<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "word_timestamp".
 *
 * @property int $id_word
 * @property string|null $word
 * @property float|null $start
 * @property float|null $end
 * @property int|null $video_id
 *
 * @property Videos $video
 */
class WordTimestamp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word_timestamp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id'], 'default', 'value' => null],
            [['video_id'], 'integer'],
            [['start', 'end'], 'number'],
            [['word'], 'string', 'max' => 255],
            [['video_id'], 'exist', 'skipOnError' => true, 'targetClass' => Videos::className(), 'targetAttribute' => ['video_id' => 'id_videos']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_word' => 'Id Word',
            'word' => 'Word',
            'start' => 'Start',
            'end' => 'End',
            'video_id' => 'Video ID',
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
