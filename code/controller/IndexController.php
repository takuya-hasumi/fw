<?php
class IndexController extends BaseController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('index', 'This is INDEXだZ');

    }
}
