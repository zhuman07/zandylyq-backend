<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 20.05.2019
 * Time: 21:38
 */

namespace api\modules\v1\controllers;

use api\modules\v1\models\JudgmentModel;
use api\common\models\Refs\RefArticle;
use api\common\models\Refs\RefArticle24;
use api\common\models\Refs\RefGender;
use Yii;

class JudgmentController extends ApiController
{
    public function actionIndex()
    {
        $result = [];
        $refGender = RefGender::find()->all();
        $refArticle24 = RefArticle24::find()->all();
        $articles = RefArticle::find()->all();

        $result['genders'] = $refGender;
        $result['article24'] = $refArticle24;
        $result['articles'] = $articles;

        return $result;
    }

    public function actionSearchQualifByStat()
    {
        $result = [];
        $params = Yii::$app->request->getBodyParams();

        if (!isset($params['qualif_name']) || empty($params['qualif_name']))
            return $result;

        $result['result'] = RefArticle::find()->where(['like', 'stat', $params['qualif_name']])->all();

        return $result;
    }

    /**
     * @return array
     */
    /**
     * @api {post} /judgment/request Уголвоный анализ
     *
     * @apiName judgementRequest
     * @apiGroup judgement
     *
     * @apiVersion 0.1.0
     *
     * @apiParam {Number} age Возраст
     * @apiParam {Number} article24_id
     * @apiParam {String} article_id
     * @apiParam {String} crime_date
     * @apiParam {Number} gender
     * @apiParam {Number} heavy
     * @apiParam {Number} soft
     *
     * @apiSuccess {Number} status        Status: 1=Success. 0=Error
     * @apiSuccess {String} error_message Error text
     * @apiSuccess {String} result        Result text
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": 1,
     *       "error_message": "",
     *       "result": "Some text..."
     *     }
     */
    public function actionRequest()
    {
        $result = [];
        $result['status'] = 0;
        $result['result'] = '';
        $result['error_message'] = '';
        try
        {
            $params = Yii::$app->request->getBodyParams();
            $judment = new JudgmentModel();

            if ($judment->setParams($params)) {
               $res = $judment->getResult();
                if (!$res) {
                    $result['error_message'] = $judment->getImplodeErrors('. ');
                }else {
                    $result['result'] = $res;
                    $result['status'] = 1;
                }
            }else
            {
                $result['error_message'] = $judment->getImplodeErrors('. ');
            }
            return $result;
        }
        catch(\Exception $e)
        {
            $result['error_message'] = 'Произошла ошибка при обработке';
        }

        return $result;
    }

}