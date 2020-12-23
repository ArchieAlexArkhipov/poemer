<?php
namespace frontend\components;

use Yii;
use yii\base\Component;


class DateFormater extends Component
{
  public static function format($date)
  {
    $date = new \DateTime($date);
    $months = array('нулября', 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря');
    return $date->format('d '.$months[date( 'n' )].' Y') . 'г.';
  }
}
