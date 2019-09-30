<?php

namespace panix\mod\rbac\migrations;


/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m999999_004914_create_role_admin
 */
use panix\mod\rbac\models\RouteModel;

class m999999_004914_create_role_admin extends Migration
{

    public function up()
    {

        $this->createRule('user', \panix\mod\rbac\rules\UserRule::class);


        $route = new RouteModel();
        $routes = $route->getAppRoutes();

        foreach (array_keys($routes) as $route) {
            $this->createPermission($route);
        }


        $this->createRole('admin', 'Администратор имеет все доступные разрешения.');
        $this->createRole('user', 'Authenticated user.', 'user');


        $this->assign('admin', 1);

        //$this->addChild();

    }

    public function down()
    {
        $this->removeRole('admin');
        $this->removeRole('user');
        $this->removeRule('admin');
        //$this->removePermission('');
    }

}
