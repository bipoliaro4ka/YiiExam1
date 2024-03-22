<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%category}}`
 */
class m240322_141003_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'id_category' => $this->integer(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'photo_before' => $this->string(),
            'photo_after' => $this->string(),
            'status' => $this->integer(),
            'datetime' => $this->timestamp(),
            'description_denied' => $this->text(),
        ]);

        // creates index for column `id_user`
        $this->createIndex(
            '{{%idx-request-id_user}}',
            '{{%request}}',
            'id_user'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request-id_user}}',
            '{{%request}}',
            'id_user',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `id_category`
        $this->createIndex(
            '{{%idx-request-id_category}}',
            '{{%request}}',
            'id_category'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-request-id_category}}',
            '{{%request}}',
            'id_category',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-request-id_user}}',
            '{{%request}}'
        );

        // drops index for column `id_user`
        $this->dropIndex(
            '{{%idx-request-id_user}}',
            '{{%request}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-request-id_category}}',
            '{{%request}}'
        );

        // drops index for column `id_category`
        $this->dropIndex(
            '{{%idx-request-id_category}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}
