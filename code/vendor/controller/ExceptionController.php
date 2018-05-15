<?php
class ExceptionController extends BaseController
{
    /**
    * 実行される処理
    * @param
    * @return
    */
    public function action()
    {
        $file = file_get_contents("./views/404.html");
        $this->viewHtml($file);
    }

}
