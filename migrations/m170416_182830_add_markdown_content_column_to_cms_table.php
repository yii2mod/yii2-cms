<?php

use yii\db\Migration;

/**
 * Handles adding markdown_content to table `cms`.
 */
class m170416_182830_add_markdown_content_column_to_cms_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%cms}}', 'markdown_content', $this->text()->after('content'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%cms}}', 'markdown_content');
    }
}
