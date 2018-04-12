<?php
class ObaController extends BaseController
{
    /**
     * 実行される処理
     * @param
     * @return
     */
    public function Action()
    {
        // 任意のテンプレートの呼び出し
        $file = $this->getTemplate("obachan");

        // 呼び出したテンプレートを置換
        $file = $this->regParams($file, "おばと叔母");

        // HTMLに出力
        $this->viewHtml($file);
    }
}
