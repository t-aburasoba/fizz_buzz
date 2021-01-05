​<?php

/*
|--------------------------------------------------------------------------
| Fizz Buzz
|--------------------------------------------------------------------------
|
| 勉強用のCLI（Command Line Interface）アプリ
| 3の倍数のときは「Fizz」, 5の倍数の時は「Buzz」, 15の倍数の時は「FizzBuzz」と入力しましょう。
|
*/

// アプリケーション本体の「インスタンス」を生成

$app = new Game();

// アプリケーション実行

$app->execute();

class Game
{
    /**
     * アプリケーション実行メソッド
     * アプリケーション独自の処理を記述する
     *
     * @return void
     */
    public function execute()
    {
        echo <<<EOM
        --------------------------------------------------------------------------
        ゲームFizzBuz
        --------------------------------------------------------------------------
        勉強用のCLI（Command Line Interface）アプリ
        3の倍数のときは「Fizz」, 5の倍数の時は「Buzz」, 15の倍数の時は「FizzBuzz」と入力しましょう。
        対戦する人数を入力してください。
        --------------------------------------------------------------------------
        \n
        EOM;
        $number = $this->listen();

        $count = 0;
        while($count <= 4){
            $opponent = $this->opponent($count, $number);
            $answer = $this->answer();
            $fizzBuzz = $this->fizzBuzz($opponent);
            if($answer == $fizzBuzz){
                $count ++;
                echo'正解';
                echo "\n";
            }else{
                echo'負け';
            break;
            }
        }        
    }

    //対戦相手の人数の入力を処理する
    public function listen()
    {
        $input = $this->ask('対戦相手の人数（1〜4人）を入力してください：');

        // 全角数値が入力されたら、半角数値に変換。
        // https://www.php.net/manual/ja/function.mb-convert-kana.php
        $value = mb_convert_kana($input, 'n');

        // 数値として扱えない文字列
        if (!is_numeric($value)) {
            return false;
        }
        // is_numeric()は小数もOKしてしまうので整数にする。
        $number = (int)$value;

        if (5 < $number) {
            // 4人以上であったらfalseを返す
            return false;
        }
        // 入力された人数を返す。
        return $number;
    }
    
    public function ask(string $message)
    {
        // メッセージを表示し、「標準入力」を待つ。
        // 前後のスペースなど、入力ミスと思われるものを除外（trim）する。
        echo escapeshellcmd($message);
        return trim(fgets(STDIN));
        //stdinはstandard inputの略
    }

    public function fizzBuzz(int $i)
    {
        if ($i % 15 === 0) {
            return 'FizzBuzz';
        } elseif ($i % 3 === 0) {
            return 'Fizz';
        } elseif ($i % 5 === 0) {
            return 'Buzz';
        } else {
            return $i;
        }
    }

    public function answer()
    {
        $input = $this->ask('あなたの番です：');
        // 入力された人数を返す。
        $answer = $input;
        return $answer;
    }

    public function opponent(int $number, int $count)
    {
        for ($i =  1; $i <= ($number+1)*($count+1)-1; $i++) {
            if($i <= $number*($count+1)){
                continue;
            }
            $fizzBuzz = $this->fizzBuzz($i);
            echo $fizzBuzz;
            echo "\n";
            sleep(1);
        }
        return $i;
    }

}
