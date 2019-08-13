<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 21.05.2019
 * Time: 11:48
 */

namespace api\common\models;

/**
 * Class JudRequestModel
 * @package api\common\models
 *
 * @property int $id
 * @property int $slvsex_id
 * @property int $slvst_id
 * @property int $slvst24_id
 * @property int $heavy
 * @property int $soft
 * @property int $age
 * @property string $judment
 * @property string $ip_address
 * @property string $crime_date
 * @property string $create_date
 */
class JudRequestModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jud_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slvsex_id', 'id', 'slvst_id', 'slvst24_id', 'heavy', 'soft', 'age'], 'integer'],
            [['judment', 'ip_address','crime_date','create_date'], 'string'],
        ];
    }
}