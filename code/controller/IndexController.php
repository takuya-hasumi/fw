<?php
class IndexController extends BaseController
{
    public function Action()
    {
        // 任意のテンプレートの呼び出し
        $file = $this->getTemplate("index");

        // 呼び出したテンプレートを置換
        $file = $this->regParams($file, "This is INDEXだZ");

        // HTMLに出力
        $this->viewHtml($file);
    }
}
