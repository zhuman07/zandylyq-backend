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
     * @apiSuccess {Object} result        Result object
     * @apiSuccess {String} result.text_1 Result param 1
     * @apiSuccess {String} result.text_2 Result param 2
     * @apiSuccess {String} result.text_3 Result param 3
     * @apiSuccess {String} result.text_4 Result param 4
     * @apiSuccess {String} result.text_5 Result param 5
     * @apiSuccess {String} result.text_6 Result param 6
     * @apiSuccess {String} result.text_7 Result param 7
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "status": 1,
     *       "error_message": "",
     *       "result": {
     *          "text_1": "some text...",
     *          "text_2": "some text...",
     *          "text_3": "some text...",
     *          "text_4": "some text...",
     *          "text_5": "some text...",
     *          "text_6": "some text...",
     *          "text_7": "some text..."
     *       }
     *     }
     *
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 400 Bad Request
     *     {
     *       "status": 0,
     *       "result": {
     *          "text_1": "",
     *          "text_2": "",
     *          "text_3": "",
     *          "text_4": "",
     *          "text_5": "",
     *          "text_6": "",
     *          "text_7": ""
     *       },
     *       "error_message": "Пустое значение article_id. Пустое значение article24. Пустое значение gender. Пустое значение age. Ошибка значения soft. Ошибка значение heavy. Пустое значение crime_date"
     *     }
     */
    public function actionRequest()
    {
        $result = [];
        $result['status'] = 0;
        $result['result'] = [
            "text_1" => "",
            "text_2" => "",
            "text_3" => "",
            "text_4" => "",
            "text_5" => "",
            "text_6" => "",
            "text_7" => "",
        ];
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

        if(!empty($result['error_message'])){
            Yii::$app->getResponse()->setStatusCode(400);
        }

        return $result;
    }

}