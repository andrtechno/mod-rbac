<?php
/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190930_004914_create_role_admin
 */


use panix\mod\rbac\migrations\Migration;

class m190930_004914_create_role_admin extends Migration
{

    public function up()
    {
        $this->createRole('admin', 'admin has all available permissions.');
        $this->assign('admin',1);
        //$this->createPermission('/admin/*');
        //$this->createRule('admin');
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
