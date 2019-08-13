<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 21.05.2019
 * Time: 0:16
 */

namespace api\common\models\Refs;

/**
 * Class RefArticle
 * @package api\common\models\Refs
 *
 * @property int $id
 * @property string $name_ru
 * @property string $stat
 */
class RefArticle extends RefBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_slvst';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['stat', 'name_ru'], 'string'],
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
            'stat' => 'Номер статьи'
        ];
    }
}