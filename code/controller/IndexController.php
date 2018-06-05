<?php
class IndexController extends BaseController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('index', 'INDEX');

        $condition = [
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
        
        if ($_POST || $_GET) {
            $result = $this->checkValidate($condition);
            if (!$result) {
                echo "送信に成功しました！";
            } else {
                foreach ($result as $value) {
                    echo $value . '<br>';
                }
            }
        }
    }
}
