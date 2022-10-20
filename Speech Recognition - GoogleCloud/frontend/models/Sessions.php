<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sessions".
 *
 * @property int $id_session
 * @property string|null $alias_sesion
 * @property string|null $datetimecreate
 *
 * @property Videos[] $videos
 */
class Sessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sessions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetimecreate'], 'safe'],
            [['alias_sesion'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_session' => 'Id Session',
            'alias_sesion' => 'Alias Sesion',
            'datetimecreate' => 'Datetimecreate',
        ];
    }

    /**
     * Gets query for [[Videos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['sessions_id' => 'id_session']);
    }
}
