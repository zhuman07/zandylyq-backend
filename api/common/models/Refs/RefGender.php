<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 20.05.2019
 * Time: 23:48
 */

namespace api\common\models\Refs;

/**
 * Class RefGender
 * @property integer $id
 * @property string $name_ru
 */
class RefGender extends RefBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_slvsex';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name_ru'], 'string'],
       ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ru' => 'Наименование',
        ];
    }
}