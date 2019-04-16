<?php

use yii\db\Migration;

class m190416_081103_create_table_media_manager extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%media_manager}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string(),
            'item_id' => $this->integer(),
            'media_id' => $this->integer()->notNull(),
            'sort' => $this->smallInteger(),
        ], $tableOptions);

        $this->createIndex('media_id', '{{%media_manager}}', 'media_id');
        $this->addForeignKey('media_manager_ibfk_1', '{{%media_manager}}', 'media_id', '{{%media}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%media_manager}}');
    }
}
