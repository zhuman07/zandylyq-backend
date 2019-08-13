<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 05.06.2019
 * Time: 22:47
 */

namespace api\modules\v1\controllers;
use api\modules\v1\models\stats\VidNakazModel;
use Yii;

class StatController extends ApiController
{
    protected $group_by = true;

    public function actionVidNakaz()
    {
        $result = [];
        $result['status'] = 0;
        $result['result'] = '';
        $result['error_message'] = '';
        try
        {
            $params = Yii::$app->request->getBodyParams();
            $vidNakazModel = new VidNakazModel();
            $vidNakazModel->setGroupBy($this->group_by);

            if ($vidNakazModel->setParams($params)) {
                $res = $vidNakazModel->getResult();
                if (!$res) {
                    $result['error_message'] = $vidNakazModel->getImplodeErrors('. ');
                }else {
                    $result['result'] = $res;
                    $result['status'] = 1;
                }
            }else
            {
                $result['error_message'] = $vidNakazModel->getImplodeErrors('. ');
            }
            return $result;
        }
        catch(\Exception $e)
        {
            $result['error_message'] = $e->getMessage();//'Произошла ошибка при обработке';
        }

        return $result;
    }

    public function actionVidNakazList()
    {
        $this->group_by = false;
        return $this->actionVidNakaz();
    }


    public function getFileContent()
    {

    }
}