<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreatePasswordResetsTable extends Migrator
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
    public function up()
    {
        $table = $this->table('password_resets');
        $table
            ->addColumn('email', 'string',array('comment'=>'用户邮箱'))
            ->addColumn('token', 'string',array('limit' => 15,'comment'=>'用户名，登陆使用'))
            ->addColumn('created_at', 'datetime',array('null'=>true,'comment'=>'更新时间'))
            ->addIndex(array('email'))
            ->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
