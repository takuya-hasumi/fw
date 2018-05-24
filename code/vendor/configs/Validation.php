<?php
class Validation
{
    protected $errors;

    /**
     * 各バリデーション条件をチェックする
     * @param  
     * @return bool
     */
    public function validate($form_condition, $request)
    {
        foreach ($request as $request_key => $request_val) {
            // リクエストの各項目がバリデーション項目にあったらその条件を取り出す
            if (array_key_exists($request_key, $form_condition)) {
                $condition = $form_condition[$request_key];
            }
            // 各条件毎に失敗したらそれぞれエラーログを吐く
            foreach ($condition as $key => $value) {
                // 型のチェック
                if ($key == 'type') {
                    if ($value == 'string' && !is_string($request_val)) {
                        $this->errors[] = $request_key . "は文字列で入力してください";
                    }
                    if ($value == 'number' && !ctype_digit($request_val)) {
                        $this->errors[] = $request_key . "は数字で入力してください";
                    }
                }
                // 文字数のチェック
                if ($key == 'min' && mb_strlen($request_val) < $value) {
                    $this->errors[] = $request_key . "は" . $value . "文字以上で入力してください";
                }
                if ($key == 'max' && mb_strlen($request_val) > $value) {
                    $this->errors[] = $request_key . "は" . $value . "文字以下で入力してください";
                }
                // 必須キーのチェック
                if ($key == 'require' && empty($request_val)) {
                    $this->errors[] = $request_key . "の入力は必須です";
                }
            }
        };

        return $this->errors;

    }

}