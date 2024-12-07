<HTML>
<HEAD>
  <title>Администрирование</title>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</HEAD>
<BODY>

<main>
  <div class='auth_form'>
    <h1>Авторизация</h1>
    <form action="" method="post">
      <div class="table">
        <label>
          <b>Имя</b>
          <input type="text" name="login" placeholder="Имя пользователя" value="<?=@$_POST['login'] ?>">
        </label>
        <label>
          <b>Пароль</b>
          <input type="password" name="pass" placeholder="Пароль">
        </label>
      </div>
      <input type="submit" value="Войти" class="form_button">
    </form>
  </div>
</main>