<?php

use yii\db\Migration;

class m170104_015438_create_table_notifications extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'message' => $this->string(255)->notNull(),
            'time' => $this->string(5)->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'url' => $this->text(),
            'created_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer(11),
            'updated_at' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP',
            'updated_by' => $this->integer(11)
        ], $tableOptions);

        $this->addForeignKey('fk_notification_user_on_created_by', 'notification', 'created_by', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_notification_user_on_updated_by', 'notification', 'updated_by', 'user', 'id', 'CASCADE', 'CASCADE');
    }


    public function down()
    {
        $this->dropTable('{{%notification}}');
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
