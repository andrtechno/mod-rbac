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


class m999999_004914_create_role_admin extends Migration
{

    public function up()
    {
        $this->createRole('admin', 'Администратор имеет все доступные разрешения.');
        $this->assign('admin',1);
        $this->createPermission('/admin/*');
        //$this->addChild();
        $this->createRule('user', \panix\mod\rbac\rules\UserRule::class);
    }

    public function down()
    {
        $this->removeRole('admin');
        $this->removeRule('admin');
        //$this->removePermission('');
    }

}
