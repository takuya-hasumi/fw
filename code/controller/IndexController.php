<?php
class IndexController extends BaseController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('index', 'This is INDEXだZ');

        $form_condition = [
            'name' => [
                'type' => 'string',
                'min' => 1,
                'max' => 20,
            ],
            'age' => [
                'type' => 'number',
                'min' => 0,
                'max' => 130,
            ],
            'address' => [
                'type' => 'string', 
                'require' => 'true'
            ]
        ];
        $result = $this->checkValidate($form_condition);

    }
}
