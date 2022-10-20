<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "videos".
 *
 * @property int $id_videos
 * @property string|null $alias_video
 * @property string|null $text_video
 * @property string|null $scriptvideo
 * @property string|null $dateload
 * @property int|null $sessions_id
 *
 * @property Events[] $events
 * @property Sessions $sessions
 */
class Videos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'videos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_video', 'dateload'], 'safe'],
            [['sessions_id'], 'default', 'value' => null],
            [['sessions_id'], 'integer'],
            [['alias_video', 'scriptvideo'], 'string', 'max' => 255],
            [['sessions_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sessions::className(), 'targetAttribute' => ['sessions_id' => 'id_session']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_videos' => 'Id Videos',
            'alias_video' => 'Alias Video',
            'text_video' => 'Text Video',
            'scriptvideo' => 'Scriptvideo',
            'dateload' => 'Dateload',
            'sessions_id' => 'Sessions ID',
        ];
    }

    /**
     * Gets query for [[Events]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['video_id' => 'id_videos']);
    }

    /**
     * Gets query for [[Sessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasOne(Sessions::className(), ['id_session' => 'sessions_id']);
    }
}
