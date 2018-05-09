## 第1回　php、ソート
PHPの閉じ記号入れないのはなぜ？
→閉じ以降書いたものが出力されてしまうため

manコマンド：Linuxコマンドの内容を教えてくれる(manual)
cat : concatenate and print files
標準出力をするだけでなく、ファイルを結合するコマンど
＞ : リダイレクト

EOF：Crtl + d　end of file

phpだけ打つと、interactive mode として起動する
printやechoで出力された際にcommandはshellが表示されているだけ
php ~~ 引数
$argv：どの言語にもある。コマンドラインから引数を与えられる。特別な変数。引数を与えられる。
→　引数を配列として返す
http://php.net/manual/ja/reserved.variables.argv.php

課題：ソートを作ろう！
並び替え
仕様
・ソートアルゴリズムなんでもよい
・入力はPHPコマンドラインから
・昇順
・argvの0番目でデフォルト出力されるものは取り除く

よくあるアルゴリズム、隣同士を比較（バブルソートとは逆）

--------------------------------------------------------------------------------
課題にあたって学んだこと
・改行

\n
br
nl2br


・シングルクォートとダブルクォートの違い

・"ダブルでは変数展開されるが、‘シングルではされない

シングルのが早いらしい

→　基本的にはシングルを使う？ダブルを使う？

・シングルとダブルでは、扱えるエスケープ文字列が異なる

→　エスケープ文字列：特殊文字や機能、エスケープシーケンス：「\n」など



・echoとprintの違い

→　echoはカンマ（.）区切りで文字列を指定できるのに対し、printはできない

→　printは結果を返す。echoは返さない。（戻り値問題）

→　違いは式かどうか。printは式だが、echoは式ではない。

　→　printはif文で評価できるが、echoはできない

→　どちらも言語構成である。



・リダイレクト

→　入出力の方向を任意に変更することが出来る。画面（ターミナル上）ではなく、ファイルにしているする時などに多く用いられる。

→　A > B ： Aの結果をBに出力する

→　＞：上書き、＞＞：追記、＜：入力のリダイレクト、＜＜：入力終端文字列を指定する

<トピックス>割り振り番号

　標準入力：0

　標準出力：1

　標準エラー出力：2
<疑問点>

・パイプとリダイレクトの違い、共通点