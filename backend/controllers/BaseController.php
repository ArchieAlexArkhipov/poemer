<?php

namespace backend\controllers;

use yii\web\Controller;

/**
 * BaseController
 *
 * Базовый контроллер административной панели,
 * остальные контроллеры административной панели
 * преимущественно наследуются от него
 */
class BaseController extends Controller
{
    public $baseUrl = '/admin/';

    public function __construct($id, $module, $config = [])
    {
        $this->view->params['baseUrl'] = $this->baseUrl;

        return parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
        } else {
            return false;
        }
    }
}
