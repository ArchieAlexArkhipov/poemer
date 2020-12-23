<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

/**
 * Site controller
 */
class GamesController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionArcanoid()
  {
    return $this->render('arcanoid');
  }

  public function actionTetris()
  {
    return $this->render('tetris');
  }

  public function actionPong()
  {
    return $this->render('pong');
  }

  public function actionSnake()
  {
    return $this->render('snake');
  }

}
