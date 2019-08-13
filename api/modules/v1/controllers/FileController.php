<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 14.06.2019
 * Time: 0:43
 */

namespace api\modules\v1\controllers;
use api\common\models\FileModel;
use api\common\traits\SetGetErrorTrait;
use Yii;

/**
 * Class FileController
 * @package api\modules\v1\controllers
 */
class FileController extends ApiController
{
    use SetGetErrorTrait;

    public function actionDownload($file_id = '')
    {
        $response = [];
        $response['status'] = 0;

        if (empty($file_id)) {
            $this->setError('Пустой идентификатор файла');
        }

        $findFile = FileModel::findOne(['id' => $file_id]);
        if ($findFile === null) {
            $this->setError('Файл не найден в базе');
        }

        if (!$this->isEmptyErrors())
        {
            $response['message'] = $this->getImplodeErrors('. ');
            return $response;
        }

        return Yii::$app->response->sendContentAsFile($findFile->body,$findFile->name);
    }
}