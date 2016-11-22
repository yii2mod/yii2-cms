<?php

use yii\db\Migration;

/**
 * Class m150212_182851_init_cms
 */
class m150212_182851_init_cms extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%Cms}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'commentAvailable' => $this->smallInteger()->notNull()->defaultValue(0),
            'metaTitle' => $this->text()->notNull(),
            'metaDescription' => $this->text(),
            'metaKeywords' => $this->text(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%Cms}}');
    }
}
