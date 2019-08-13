<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 05.06.2019
 * Time: 22:53
 */

namespace api\modules\v1\models\stats;

use api\common\traits\SetGetErrorTrait;
use Yii;

/**
 * Class VidNakazModel
 */
class VidNakazModel extends \yii\base\Model
{
    use SetGetErrorTrait;

    protected $article_id;
    /**
     * @var \DateTime
     */
    protected $crime_date;
    protected $article24_id;
    protected $gender;
    protected $age_from;
    protected $age_to;
    protected $age;
    protected $soft;
    protected $heavy;
    protected $vidNakaz;
    private $_group_by = false;

    /**
     * @param $params
     * @return bool
     */
    public function setParams($params)
    {
        if (!isset($params['article_id']) || strlen(trim($params['article_id']))<=0) {
            $this->setError('Пустое значение article_id');
        }else {
            $this->article_id = $params['article_id'];
        }

        if (!isset($params['article24_id']) || (int)$params['article24_id'] <=0) {
            $this->setError('Пустое значение article24');
        }else {
            $this->article24_id = $params['article24_id'];
        }

        if (!isset($params['gender']) || (int)$params['gender'] <=0)
        {
            $this->setError('Пустое значение gender');
        }else {
            $this->gender = $params['gender'];
        }

        if (!isset($params['age']) || (int)$params['age'] <=0)
        {
            $this->setError('Пустое значение age_from');
        }else {
            $this->age = $params['age'];
        }

        if (!isset($params['soft']) || (int)$params['soft'] < 0 || (int)$params['soft'] > 1) {
            $this->setError('Ошибка значения soft');
        }else {
            $this->soft = (int)$params['soft'];
        }

        if (!isset($params['heavy']) || (int)$params['heavy'] < 0 || (int)$params['heavy'] > 1) {
            $this->setError('Ошибка значение heavy');
        }else {
            $this->heavy = (int)$params['heavy'];
        }

        if (isset($params['VidNakaz']) && !empty($params['VidNakaz'])) {
            $this->vidNakaz = $params['VidNakaz'];
        }

        return $this->isEmptyErrors();
    }


    /**
     * @param $value
     * @return $this
     */
    public function setGroupBy($value)
    {
        if (is_bool($value))
            $this->_group_by = $value;

        return $this;
    }

    /**
     * @return array|void
     */
    public function getResult()
    {
        if ($this->_group_by === true) {
            $result = $this->getGroupByResult();
        }else {
            $result = $this->getResultList();
        }

        return $result;
    }


    /**
     * @return array
     */
    public function getGroupByResult()
    {
        $select_fields = ['VidNakaz', 'COUNT(*) AS cntLic'];

        $this->setAgeInterval($this->age);

        $result = (new \yii\db\Query())
            ->select($select_fields)
            ->from('v_tsn2')
            ->where(['kval' => $this->article_id, 'st24'=>$this->article24_id,'sex'=>$this->gender])
            ->andWhere(['between', 'year', $this->age_from, $this->age_to])
            ->groupBy(['OrdNakaz','VidNakaz']);

        if (!$this->soft)
            $result->andWhere(['soft'=>null]);
        else
            $result->andWhere(['not', ['soft' => null]]);

        if (!$this->heavy)
            $result->andWhere(['heavy'=>null]);
        else
            $result->andWhere(['not', ['heavy' => null]]);

        return $result->all();

    }

    public function getResultList()
    {
        $select_fields = ['dres', 'nsud', 'numsud', 'numud', 'family', 'name', 'lname', 'vidnakaz', 'id as file_id'];

        $this->setAgeInterval($this->age);

        $result = (new \yii\db\Query())
            ->select($select_fields)
            ->from('v_spis')
            ->where(['kval' => $this->article_id, 'st24'=>$this->article24_id,'sex'=>$this->gender])
            ->andWhere(['between', 'year', $this->age_from, $this->age_to]);

        if (!$this->soft)
            $result->andWhere(['soft'=>null]);
        else
            $result->andWhere(['not', ['soft' => null]]);

        if (!$this->heavy)
            $result->andWhere(['heavy'=>null]);
        else
            $result->andWhere(['not', ['heavy' => null]]);

        if (!empty($this->vidNakaz))
            $result->andWhere(['VidNakaz'=>$this->vidNakaz]);

        $resultList = $result->all();

        if (!empty($resultList))
        {
            foreach ($resultList as $key => $list)
            {
                $resultList[$key]['file_url'] = Yii::$app->request->hostInfo.'/v1/file/download/'.$list['file_id'];
            }
        }

        return $resultList;
    }

    public function setAgeInterval($age)
    {
        $age = (int)$age;

        if ($age < 18)
        {
            $this->age_from = 0;
            $this->age_to = 17;
        }
        elseif ($age >= 18 && $age <= 24)
        {
            $this->age_from = 18;
            $this->age_to = 24;
        }
        elseif ($age >= 25 && $age <= 36)
        {
            $this->age_from = 25;
            $this->age_to = 36;
        }
        elseif ($age >= 37 && $age <= 45)
        {
            $this->age_from = 37;
            $this->age_to = 45;
        }
        elseif ($age >= 46 && $age <= 62)
        {
            $this->age_from = 46;
            $this->age_to = 62;
        }
        else
        {
            $this->age_from = 63;
            $this->age_to = 150;
        }
    }


}