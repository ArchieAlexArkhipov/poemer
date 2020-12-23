<?php
/**
 * Created by PhpStorm.
 * User: Arseny Sysolyatin
 * Date: 29.06.15
 * Time: 11:47
 */

namespace console\controllers;


use common\components\TagDependency;
use common\models\Category;
use common\models\Order;
use common\models\Product;
use common\models\User;
use common\ucs\ConnectVars;
use common\ucs\get_by_order_period;
use common\ucs\statusv2;
use Yii;
use yii\console\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Console;


class ConsoleController extends Controller
{

    function actionGenerateHash($password)
    {
        echo Yii::$app->security->generatePasswordHash($password) . "\n";
        return 0;
    }

    function actionNewUser($userName = false, $password = false, $role = false)
    {
        $appManager = Yii::$app->authManager;

        $users = [
          /*
            [
                'username' => 'd.agafonkin',
                'pass' => '0ha6yX',
                'role' => 'admin',
            ],
            */
        ];

        foreach ($users as $u) {
            $user = new User;
            $user->username = $u[ 'username' ];
            $user->auth_key = false;
            $user->email = false;
            $user->password_hash = Yii::$app->security->generatePasswordHash($u[ 'pass' ]);
            $user->status = 10;
            $user->save();

            if (isset($u[ 'role' ]) and !empty($u[ 'role' ])) {
                //assign
                $userRole = $appManager->getRole($u[ 'role' ]);
                $appManager->assign($userRole, $user->id);
            }
        }

        if (!empty($userName) and !empty($password) and !empty($role)) {
            $user = new User;
            $user->username = $userName;
            $user->auth_key = false;
            $user->email = false;
            $user->password_hash = Yii::$app->security->generatePasswordHash($password);
            $user->status = 10;
            $user->save();

            if (isset($role) and !empty($role)) {
                //assign
                $userRole = $appManager->getRole($role);
                $appManager->assign($userRole, $user->id);
            }
            echo 'New user add success.';
        }

        return 0;
    }
}
