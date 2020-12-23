<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Login';
?>
<div class="auth-login row">

  <a href="/" class="logo" target="_blank">
    .poemer
  </a>

  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span id="auth-btn">Авторизация </span><span id="reg-btn">Регистрация</span></h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" <?= $isSignUp ? 'checked': '' ?>/>
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">Вход</h4>

                      <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <div class="form-group">
                          <?= $form->field($loginForm, 'email', ['template' => '{input}'])->textInput(['type' => 'email', 'autofocus' => true, 'class' => 'form-style', 'placeholder' => 'Ваш Email', 'required' => true]) ?>
                          <!-- <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off"> -->
                          <i class="input-icon fa fa-at" aria-hidden="true"></i>
                        </div>
                        <div class="form-group mt-2">
                          <?= $form->field($loginForm, 'password', ['template' => '{input}'])->passwordInput(['class' => 'form-style', 'placeholder' => 'Ваш пароль', 'required' => true]) ?>
                          <!-- <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off"> -->
                          <i class="input-icon fa fa-lock" aria-hidden="true"></i>
                        </div>
                        <div class="form-group mt-2">
                          <?= $form->field($loginForm, 'rememberMe')->checkbox(['label' => 'Запомнить меня']) ?>
                        </div>

                        <?php if (!empty($loginForm->errors)): ?>
                          <?php foreach ($loginForm->errors as $key => $error): ?>
                            <?php if (isset($error[0])): ?>
                              <span style="color:red"><?= $error[0] ?></span>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="form-group">
                            <?= Html::submitButton('Войти', ['class' => 'btn mt-4 btn-primary', 'name' => 'login-button']) ?>
                        </div>

                      <?php ActiveForm::end(); ?>

                      <!-- <p class="mb-0 mt-4 text-center"><a href="<?= Url::to(['auth/request-password-reset']) ?>" class="link">Забыли свой пароль?</a></p> -->
                    </div>
                  </div>
                </div>

                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">Регистрация</h4>
                      <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>

                        <div class="form-group">
                          <?= $form->field($signupForm, 'name', ['template' => '{input}'])->textInput(['autofocus' => true, 'class' => 'form-style', 'placeholder' => 'Ваше имя', 'required' => true]) ?>
                          <i class="input-icon fa fa-user" aria-hidden="true"></i>
                        </div>
                        <div class="form-group mt-2">
                          <?= $form->field($signupForm, 'surname', ['template' => '{input}'])->textInput(['autofocus' => true, 'class' => 'form-style', 'placeholder' => 'Ваша фамилия', 'required' => true]) ?>
                          <i class="input-icon fa fa-male" aria-hidden="true"></i>
                        </div>
                        <div class="form-group mt-2">
                          <?= $form->field($signupForm, 'email', ['template' => '{input}'])->textInput(['type' => 'email', 'autofocus' => true, 'class' => 'form-style', 'placeholder' => 'Ваш Email', 'required' => true]) ?>
                          <!-- <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off"> -->
                          <i class="input-icon fa fa-at" aria-hidden="true"></i>
                        </div>
                        <div class="form-group mt-2">
                          <?= $form->field($signupForm, 'password', ['template' => '{input}'])->passwordInput(['class' => 'form-style', 'placeholder' => 'Ваш пароль', 'required' => true]) ?>
                          <!-- <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off"> -->
                          <i class="input-icon fa fa-lock" aria-hidden="true"></i>
                        </div>

                        <?php if (!empty($signupForm->errors)): ?>
                          <?php foreach ($signupForm->errors as $key => $error): ?>
                            <?php if (isset($error[0])): ?>
                              <span style="color:red"><?= $error[0] ?></span>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="form-group">
                            <?= Html::submitButton('Дальше', ['class' => 'btn mt-4 btn-primary', 'name' => 'signup-button']) ?>
                        </div>

                      <?php ActiveForm::end(); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
