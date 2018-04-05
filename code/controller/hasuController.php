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
    $file = getTemplate("hasumin");

    // 呼び出したテンプレートを置換
    $file = regParams($file, "置換したで");

    // HTMLに出力
    viewHtml($file);
  }

}
