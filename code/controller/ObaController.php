<?php
class ObaController extends BaseController
{
    public function Action()
    {
        // 任意のテンプレートの呼び出し
        if (!$file = $this->getTemplate("obachan")) {
            throw new Exception('テンプレートの呼び出しに失敗しました。');
        }

        // 呼び出したテンプレートを置換
        if (!$file = $this->replaceParams($file, "おばと叔母")) {
            throw new Exception('テンプレートの置換に失敗しました。');
        }

        // HTMLに出力
        if (!$this->viewHtml($file)) {
            throw new Exception('HTMLの出力に失敗しました。');
        }

    }
}
