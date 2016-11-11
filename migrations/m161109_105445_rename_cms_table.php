<?php

use yii\db\Migration;

class m161109_105445_rename_cms_table extends Migration
{
    public function up()
    {
        if (Yii::$app->db->schema->getTableSchema('cms') === null) {
            $this->renameTable('{{%Cms}}', '{{%cms}}');
        }
    }

    public function down()
    {
        if (Yii::$app->db->schema->getTableSchema('Cms') === null) {
            $this->renameTable('{{%cms}}', '{{%Cms}}');
        }
    }
}