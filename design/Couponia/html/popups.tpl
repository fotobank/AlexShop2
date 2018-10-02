        <!-- LOGIN REGISTER LINKS CONTENT -->
        <div id="login-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="fa fa-sign-in dialog-icon"></i>
            <h3>Вход на сайт</h3>
            <h5>Здравствуйте. Войдите, чтобы начать покупки.</h5>
            <form class="dialog-form" method="post" action="user/login">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" placeholder="email@domain.com" class="form-control" name="email" data-format="email" data-notice="Введите email" value="{$email|escape}" maxlength="255">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" placeholder="Ваш пароль"  name="password" data-format=".+" data-notice="Введите пароль" class="form-control">
                </div>

                <input type="submit" value="Войти" class="btn btn-primary"  name="login">
            </form>
            <ul class="dialog-alt-links">
                <li><a class="popup-text" href="#register-dialog" data-effect="mfp-zoom-out">Регистрация</a>
                </li>
                <li><a class="popup-text" href="#password-recover-dialog" data-effect="mfp-zoom-out">Забыли пароль?</a>
                </li>
            </ul>
        </div>


        <div id="register-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="fa fa-edit dialog-icon"></i>
            <h3>регистрация</h3>
            <h5>Зарегистрируйтесь для получения скидки!</h5>
            <form class="dialog-form" method="post" action="user/register">
                 <div class="form-group">
                    <label>Имя</label>
                    <input type="text" placeholder="Ваше имя"name="name" data-format=".+" data-notice="Введите имя" value="{$name|escape}" maxlength="255" class="form-control">
                </div>           
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" placeholder="email@domain.com"  name="email" data-format="email" data-notice="Введите email" value="{$email|escape}" maxlength="255" class="form-control">
                </div>
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" placeholder="Ваш пароль"  name="password" data-format=".+" data-notice="Введите пароль" value="" class="form-control">
                </div>
 	<div class="captcha"><img src="captcha/image.php?{math equation='rand(10,10000)'}"/></div> 
	<input  class="form-control input_captcha" id="comment_captcha" type="text" name="captcha_code" value="" data-format="\d\d\d\d" data-notice="Введите капчу"/>
<div class="gap gap-mini"></div>         
                <input type="submit" value="Зарегистрироваться"  name="register"  class="btn btn-primary">
            </form>
            <ul class="dialog-alt-links">
                <li><a class="popup-text" href="#login-dialog" data-effect="mfp-zoom-out">Уже зарегистрированы?</a>
                </li>
            </ul>
        </div>


        <div id="password-recover-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
            <i class="icon-retweet dialog-icon"></i>
            <h3>Восстановление пароля</h3>
            <h5>Забыли пароль? Мы вам его напомним!</h5>
            <form class="dialog-form" action="user/password_remind" method="post">
                <label>E-mail</label>
                <input type="text" placeholder="email@domain.com"  name="email" data-format="email" data-notice="Введите email" value="{$email|escape}"  maxlength="255"  class="form-control">
                <input type="submit" value="Вспомнить" class="btn btn-primary">
            </form>
        </div>
        <!-- END LOGIN REGISTER LINKS CONTENT -->