<?php

namespace WebPay\Data;

use WebPay\InvalidRequestException;
use WebPay\AbstractData;
use WebPay\Data\ErrorBody;

class ErrorData extends AbstractData {

    public function __construct(array $params)
    {
        $this->fields = array('error');
        $params = $this->normalize($this->fields, $params);
        $params['error'] = is_array($params['error']) ? new ErrorBody($params['error']) : $params['error'];
        $this->attributes = $params;
    }

    public function __set($key, $value)
    {
        throw new \Exception('This class is immutable');
    }

    public function requestBody()
    {
        $result = array();

        $this->copyIfExists($this->attributes, $result, 'error', 'requestBody');
        return $result;
    }

    public function queryParams()
    {
        $result = array();
        return $result;
    }
}
