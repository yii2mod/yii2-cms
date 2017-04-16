<?php

use yii\db\Migration;

class m170416_182141_rename_fields extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%cms}}', 'commentAvailable', 'comment_available');
        $this->renameColumn('{{%cms}}', 'metaTitle', 'meta_title');
        $this->renameColumn('{{%cms}}', 'metaDescription', 'meta_description');
        $this->renameColumn('{{%cms}}', 'metaKeywords', 'meta_keywords');
        $this->renameColumn('{{%cms}}', 'createdAt', 'created_at');
        $this->renameColumn('{{%cms}}', 'updatedAt', 'updated_at');
    }

    public function down()
    {
        $this->renameColumn('{{%cms}}', 'comment_available', 'commentAvailable');
        $this->renameColumn('{{%cms}}', 'meta_title', 'metaTitle');
        $this->renameColumn('{{%cms}}', 'meta_description', 'metaDescription');
        $this->renameColumn('{{%cms}}', 'meta_keywords', 'metaKeywords');
        $this->renameColumn('{{%cms}}', 'created_at', 'createdAt');
        $this->renameColumn('{{%cms}}', 'updated_at', 'updatedAt');
    }
}
