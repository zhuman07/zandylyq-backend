<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 21.05.2019
 * Time: 0:16
 */

namespace api\common\models\Refs;

/**
 * Class RefArticle24
 * @package api\common\models\Refs
 *
 * @property int $id
 * @property string $name_ru
 */
class RefArticle24 extends RefBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_slvst24';
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