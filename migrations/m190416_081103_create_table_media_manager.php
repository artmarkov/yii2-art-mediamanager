<?php

use yii\db\Migration;

class m190416_081103_create_table_media_manager extends Migration
{
    const MEDIA_MANAGER_TABLE = '{{%media_manager}}';
    
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::MEDIA_MANAGER_TABLE, [
            'id' => $this->primaryKey(),
            'class' => $this->string(),
            'item_id' => $this->integer(),
            'media_id' => $this->integer()->notNull(),
            'sort' => $this->smallInteger(),
        ], $tableOptions);

        $this->createIndex('media_id', self::MEDIA_MANAGER_TABLE, 'media_id');
        $this->addForeignKey('media_manager_ibfk_1', self::MEDIA_MANAGER_TABLE, 'media_id', '{{%media}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable(self::MEDIA_MANAGER_TABLE);
    }
}
