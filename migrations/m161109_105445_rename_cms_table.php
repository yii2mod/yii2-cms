<?php

use yii\db\Migration;

class m161109_105445_rename_cms_table extends Migration
{
    public function up()
    {
        $this->renameTable('{{%Cms}}', '{{%cms}}');
    }

    public function down()
    {
        $this->renameTable('{{%cms}}', '{{%Cms}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
