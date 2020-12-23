<?php
namespace backend\controllers;

use Yii;
use yii\console\Controller;

// Создает информацию о правах доступа
class RbacController extends Controller
{
    public function actionInit()
    {
      $auth = Yii::$app->authManager;

      // // добавляем разрешение "createPost"
      // $createPost = $auth->createPermission('createPost');
      // $createPost->description = 'Create a post';
      // $auth->add($createPost);
      //
      // // добавляем разрешение "updatePost"
      // $updatePost = $auth->createPermission('updatePost');
      // $updatePost->description = 'Update post';
      // $auth->add($updatePost);

      // добавляем роль "user"
      $user = $auth->createRole('user');
      $auth->add($user);
      // $auth->addChild($user, $createPost);

      // добавляем роль "admin"
      $admin = $auth->createRole('admin');
      $auth->add($admin);
      // $auth->addChild($admin, $updatePost);
      // $auth->addChild($admin, $author);

      // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
      // обычно реализуемый в модели User.
      // $auth->assign($user, 2);
      $auth->assign($admin, 1);
    }
}
