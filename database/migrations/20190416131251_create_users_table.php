<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUsersTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(){

        $table = $this->table('users');
        $table
            ->addColumn('name', 'string',array('limit' => 15,'comment'=>'用户名，登陆使用'))
            ->addColumn('email', 'string',array('comment'=>'用户邮箱'))
            ->addColumn('email_verified_at', 'datetime',array('comment'=>'是否通过email验证','null'=>true))
            ->addColumn('password', 'string',array('limit' => 32,'default'=>md5('123456'),'comment'=>'用户密码'))
            ->addColumn('rememberToken', 'boolean',array('limit' => 1,'default'=>0,'comment'=>'登陆状态'))
            ->addColumn('create_at', 'datetime',array('comment'=>'创建时间'))
            ->addColumn('update_at', 'datetime',array('comment'=>'更新时间'))
            ->addIndex(array('email'), array('unique' => true))
            ->setId('id')
            ->create();
    }

    /**
     * 提供回滚的删除用户表方法
     */
    public function down(){
        $this->dropTable('users');
    }
}
