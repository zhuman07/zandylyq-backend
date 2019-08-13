<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 21.05.2019
 * Time: 12:17
 */

namespace api\common\traits;

trait SetGetErrorTrait
{
    private $_errors = [];

    /**
     * @param $msg
     */
    public function setError($msg)
    {
        $this->_errors[] = $msg;
    }

    /**
     * @return array
     */
    public function getArrErrors()
    {
        return $this->_errors;
    }

    /**
     * @param string $delimeter
     * @return string
     */
    public function getImplodeErrors($delimeter = "<br>")
    {
        return implode($delimeter, $this->_errors);
    }

    /**
     * @return bool
     */
    public function isEmptyErrors()
    {
        return empty($this->_errors);
    }
}