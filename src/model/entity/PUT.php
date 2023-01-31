<?php

namespace api\model\entity;

use api\conf\Parameters;

class PUT extends BaseMethod
{
    public function __construct()
    {
        parent::__construct();
        $this->method_type = Parameters::REQUEST_METHOD_PUT;
    }

    protected function extractParameter()
    {
        switch ($this->content_type) {
            case Parameters::REQUEST_CONTENT_TYPE_JSON:
                $this->url_parameters_array = json_decode(file_get_contents('php://input'), true);
                break;

            case Parameters::REQUEST_CONTENT_TYPE_FORM:
                $this->url_parameters_array = $_POST;
                break;
        }
    }
}

?>