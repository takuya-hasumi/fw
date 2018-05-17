<?php
class ExceptionController extends BaseController
{
    public function action()
    {
        $file = file_get_contents("./views/404.html");
        $this->viewHtml($file);
    }

}
