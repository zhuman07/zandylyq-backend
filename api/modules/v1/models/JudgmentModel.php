<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 21.05.2019
 * Time: 0:41
 */

namespace api\modules\v1\models;

use api\common\models\JudRequestModel;
use api\common\traits\SetGetErrorTrait;
use Yii;

/**
 * Class JudgmentModel
 * @package api\common\models
 */
class JudgmentModel extends \yii\base\Model
{
    use SetGetErrorTrait;

    protected $article_id;
    /**
     * @var \DateTime
     */
    protected $crime_date;
    protected $article24_id;
    protected $gender;
    protected $age;
    protected $soft;
    protected $heavy;

    /**
     * @param $params
     * @return bool
     */
    public function setParams($params)
    {
        $params = $this->clearXssParams($params);

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
            $this->setError('Пустое значение age');
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

        if (!isset($params['crime_date']) || empty($params['crime_date'])) {
            $this->setError('Пустое значение crime_date');
        }else {
            $this->crime_date = \DateTime::createFromFormat('Y.m.d', $params['crime_date']);
            if (!$this->crime_date)
                $this->setError('Неверный формат crime_date');
        }

        return $this->isEmptyErrors();
    }

    /**
     * @return bool
     */
    public function getResult()
    {
        try {
            $judment_text = $this->findJudment();

            if ($judment_text === false)
                throw new \Exception('Не удалось вычислить ответ');

            if (!$this->saveRequest($judment_text))
                throw new \Exception('Не удалось сохранить результат запроса');

            return $judment_text;

        }catch (\Exception $e){
            $this->setError($e->getMessage());
        }

        return false;
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    protected function findJudment()
    {
        $crime_date = $this->crime_date->format('Y.m.d');

        $sql = <<<EOL
CALL srok_v2(
    '$this->article_id', 
    '$this->article24_id', 
    '$this->gender', 
    '$this->age', 
    $this->soft, 
    $this->heavy, 
    '$crime_date', 
    @outPar1_res, 
    @outPar2_text,
    @outPar3_text,
    @outPar4_text,
    @outPar5_text,
    @outPar6_text,
    @outPar7_text,
    @outPar8_text
)
EOL;

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();

        $sql = 'SELECT @outPar1_res as status, 
                    @outPar2_text as txt, 
                    @outPar3_text as txt2,
                    @outPar4_text as txt3,
                    @outPar5_text as txt4,
                    @outPar6_text as txt5,
                    @outPar7_text as txt6,
                    @outPar8_text as txt7';
        $command = Yii::$app->db->createCommand($sql);
        $result = $command->queryOne();
        if($result) {
            if ($result['status'] == 1) {
                $result_text = '';
                $result_array = [
                    'text_1'=>$result['txt'],
                    'text_2'=>$result['tx2'],
                    'text_3'=>$result['tx3'],
                    'text_4'=>$result['tx4'],
                    'text_5'=>$result['tx5'],
                    'text_6'=>$result['tx6'],
                    'text_7'=>$result['tx7'],
                ];
                foreach ($result_array as $key => $val){
                    $result_text .= $val."<br>";
                }
                return $result_text;
            }
        }else
            $this->setError('Результат не найден');

        return false;
    }

    /**
     * @return JudRequestModel|bool
     */
    protected function saveRequest($result_txt)
    {
        $request = new JudRequestModel();
        $request->slvsex_id = $this->gender;
        $request->slvst_id = $this->article_id;
        $request->slvst24_id = $this->article24_id;
        $request->heavy = $this->heavy;
        $request->soft = $this->soft;
        $request->crime_date = $this->crime_date->format('Y-m-d');
        $request->age = $this->age;
        $request->create_date = (new \DateTime())->format('Y-m-d H:i:s');
        $request->ip_address = Yii::$app->request->userIP;
        $request->judment = $result_txt;
        if (!$request->save())
        {
            $this->setError(implode('. ',$request->getErrorSummary(true)));
            return false;
        }

        return $request;
    }

    /**
     * @param JudRequestModel $request
     * @param $result
     * @return bool
     */
    protected function saveResult(JudRequestModel $request, $result)
    {
        $request->judment = $result;
        if (!$request->save())
        {
            $this->setError(implode('. ',$request->getErrorSummary(true)));
            return false;
        }

        return true;
    }

    /**
     * @param $params
     * @return array
     */
    protected function clearXssParams($params)
    {
        $result = [];
        foreach ($params as $key=>$value)
        {
            $result[$key] = $value;
        }

        return $result;
    }
}