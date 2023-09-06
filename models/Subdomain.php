<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subdomain".
 *
 * @property int $id
 * @property int|null $id_member
 * @property string|null $name
 * @property string|null $url
 * @property string|null $date_created
 * @property string|null $date_udpated
 */
class Subdomain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subdomain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_member'], 'integer'],
            [['name', 'url'], 'string'],
            [['date_created', 'date_udpated'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_member' => 'Id Member',
            'name' => 'Name',
            'url' => 'Url',
            'date_created' => 'Date Created',
            'date_udpated' => 'Date Udpated',
        ];
    }
}
