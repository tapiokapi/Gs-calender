<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>calender</title>
  <style>
    .sunday {
      color: red;
    }
    .saturday {
      color: blue;
    }
  </style>
</head>
<body>
  <!-- 任意の年月を選べるフォームの作成 -->
  <form action="index.php" method="get">
    <!-- 年 -->
    <select name="year">
      <?php
      $year = 1990;
      while($year<2021) {
        echo "<option>$year</option>";
        $year++;
      }
      ?>
    </select>
    <!-- 月 -->
    <select name="month">
      <?php
      $month = 1;
      while($month<13) {
        echo "<option>$month</option>";
        $month++;
      }
      ?>
    </select>
    <!-- 送信ボタン -->
    <input type="submit" value="送信">
  </form>
  
  <?php
    $ym_now = date("Ym"); // Yだと年４桁の数字、mだと月を2桁の数字で返してくれる
    // substrメソッドは、対象の文字列を抽出して値を返す。
    // substr(対象の文字列, 何文字目から, 何文字分抽出するか)
    $y = substr($ym_now, 0, 4); 
    $m = substr($ym_now, 4, 2);

    // 現在の年月を表示する
    // issetメソッドは引数に与えられた変数に値があるときはtrue, ないときはfalseを返す。
    if(isset($_GET['year'])) {
      $y = $_GET['year'];
      $m = $_GET['month'];
      echo "<p>$y 年$m 月</p>";
    } else {
      echo "<p>$y 年$m 月</p>";
    }

    // 曜日を表示する
    echo "
      <table border=\"1\">
        <tr>
          <th>日</th>
          <th>月</th>
          <th>火</th>
          <th>水</th>
          <th>木</th>
          <th>金</th>
          <th>土</th>
          </tr>
          <tr>";

    // 1日目の前に空白を入れる処理
    // mktimeメソッドはUnix epoch(1970年1月1日00:00:00 GMT)から指定された時刻までの通算秒を返すメソッド。dateメソッドと一緒に使うと、指定した時間を値として返すことができる。（引数は、時, 分, 秒, 月, 日, 年）
    $wd = date("w", mktime(0, 0, 0, $m, 1, $y));
    for($i=1; $i<=$wd; $i++) {
      echo "<td> </td>";
    }
    
    // 日付を表示する
    $d = 1;
    // checkdateメソッドはその日付が存在するかを確認するメソッド(引数は月、日、年)
    while(checkdate($m, $d, $y)) {
      // mktimeメソッドはUnix epoch(1970年1月1日00:00:00 GMT)から指定された時刻までの通算秒を返すメソッド。dateメソッドと一緒に使うと、指定した時間を値として返すことができる。（引数は、時, 分, 秒, 月, 日, 年）
      // dateメソッドのフォーマットの一つ「w」は、指定された日付に対応した曜日を数字で返す。０が日曜日で６が土曜日。
      if(date("w", mktime(0,0,0,$m, $d, $y)) ==6) {
        echo "<td class=\"saturday\">$d</td>";
        echo "</tr>";
        if(checkdate($m, $d+1, $y)) {
          echo "</tr>";
        }
      } elseif(date("w", mktime(0,0,0,$m, $d, $y)) ==0) {
        echo "<td class=\"sunday\">$d</td>";
      } else {
        echo "<td>$d</td>";
      }
      $d++;
    }

    // 最終日後の空白を埋める処理
    // 以下、mktimeメソッドの仕様
    // 日が0だと、前月の末日を表す
    // 月が12より大きいと,その翌年以降の該当する月を表す
    $wdx = date("w", mktime(0, 0, 0, $m+1, 0, $y));
    for($i=1; $i<7-$wdx; $i++) {
      echo "<td> </td>";
    }

    echo "</tr></table>";

  ?>
</body>
</html