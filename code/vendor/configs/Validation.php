<?php
class Validation
{
    protected $condition;
    protected $request;

    public function __construct($condition, $request)
    {
        $this->condition = $condition;
        $this->request   = $request;
    }

    /**
     * 各バリデーション条件をチェックする
     * @param  
     * @return bool
     */
    public function validate()
    {
        $errors = [];
        
        // フォームの各項目に対して入力項目をひとつひとつチェックする
        foreach ($this->request as $request_key => $request_val) {
            // リクエストがバリデーション項目にあったらその条件を取り出す
            if (array_key_exists($request_key, $this->condition)) {
                $condition = $this->condition[$request_key];
            }
            // 入力項目毎に失敗したらそれぞれエラーログを吐く
            foreach ($condition as $key => $value) {
                // 型のチェック
                if ($key == 'type') {
                    if ($value == 'string' && !is_string($request_val)) {
                        $errors[] = $request_key . "は文字列で入力してください";
                    }
                    if ($value == 'number' && !ctype_digit($request_val)) {
                        $errors[] = $request_key . "は数字で入力してください";
                    }
                }

                // 文字数のチェック
                if ($key == 'min' && mb_strlen($request_val) < $value) {
                    $errors[] = $request_key . "は" . $value . "文字以上で入力してください";
                }
                if ($key == 'max' && mb_strlen($request_val) > $value) {
                    $errors[] = $request_key . "は" . $value . "文字以下で入力してください";
                }
                
                // 必須キーのチェック
                if ($key == 'require' && empty($request_val)) {
                    $errors[] = $request_key . "の入力は必須です";
                }
            }
        };

        return $errors;

    }

}