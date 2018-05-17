<?php
class ObaController extends BaseController
{
    public function action()
    {
        // 任意のテンプレートを置換して読み込み
        $this->view('obachan', 'おばと叔母');

    }
}
