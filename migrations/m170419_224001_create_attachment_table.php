<?php

use yii\db\Migration;

/**
 * Handles the creation of table `attachment`.
 * Has foreign keys to the tables:
 *
 * - `cms`
 */
class m170419_224001_create_attachment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%attachment}}', [
            'id' => $this->primaryKey(),
            'file_extension' => $this->string(),
            'file_version' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%attachment}}');
    }
}
