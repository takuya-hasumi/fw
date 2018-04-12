<?php
class HasuController extends BaseController
{
    /**
     * 実行される処理
     * @param
     * @return
     */
    public function Action()
    {
        // 任意のテンプレートの呼び出し
        $file = $this->getTemplate("hasumin");

        // 呼び出したテンプレートを置換
        $file = $this->regParams($file, "置換したで");

        // HTMLに出力
        $this->viewHtml($file);
    }
}
