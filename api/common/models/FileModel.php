<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 14.06.2019
 * Time: 0:42
 */

namespace api\common\models;

/**
 * Class FileModel
 * @package api\common\models
 * @property string $id
 * @property string $name
 * @property string $body
 */
class FileModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_doc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'body'], 'string'],
        ];
    }
}