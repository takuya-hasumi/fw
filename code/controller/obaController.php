<?php
class ObaController extends BaseController
{
  /**
   * 実行される処理
   * @param  
   * @return 
   */
  public function Action($param)
  {
    $file = file_get_contents("./views/hasumin.html");
    return $file;
  }

}
