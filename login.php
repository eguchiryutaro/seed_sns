<?php
  require('dbconnect.php');
//post送信されていたら、emailとパスワードの入力チェックを行い、どちらかが（あるいは両方）未入力の場合、「メールアドレスとパスワードをご記入ください」とパスワード入力欄の下に表示してください
//$error['login']にもblankという文字をセットして判別できるようにすること
if(!empty($_POST)){
  $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
  $password = htmlspecialchars($_POST['password'],ENT_QUOTES,'UTF-8');

  if (empty($_POST['email'])){
    $error['login'] = 'blank';
  }

  if (empty($_POST['password'])){
    $error['login'] = 'blank';
  }

  if (empty($error)){
    //ログイン処理
    //入力されたemail,パスワードで会員情報を取得できたら、正常ログイン、取得できなかったら、$error['login']にfailedを代入して、パシワードの下に、「ログインに失敗しました。正しくご記入ください」とエラーメッセージを表示してください
    $sql = sprintf('SELECT * FROM `members` WHERE `email` = "%s" AND `password` = "%s"',
  mysqli_real_escape_string($db,$_POST['email']),
  mysqli_real_escape_string($db,sha1($_POST['password']))
  );
    //SQL実行
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
      if ($table = mysqli_fetch_assoc($record)){
        //ログイン成功
      
        //SESSION変数に、会員IDを保存
        $_SESSION['login_member_id'] = $table['member_id'];
        //SESSION変数に、ログイン時間を記録
        $_SESSION['time'] = time();
        //ログイン後のindex.php（トップページ）に遷移
        header("Location: index.php");
        exit();
      }else{
        //ログイン失敗
        $error['login'] = 'faild';

    }
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>ログイン</legend>
        <form method="post" action="" class="form-horizontal" role="form">
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if(isset($error['login']) && $error['login'] == 'blank'): ?>
                <p class="error">*
                メールドレスとパスワードをご記入してください。
                </p>
              <?php endif; ?>
              <?php if(isset($error['login']) && $error['login'] == 'faild'): ?>
                <p class="error">*
                ログインに失敗しました、正しくご記入ください。</p>
              <?php endif; ?>
          </div>
          </div>
          <input type="submit" class="btn btn-default" value="ログイン">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
