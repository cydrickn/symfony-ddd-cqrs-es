<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190203093441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create Table for event_store and user';
    }

    public function up(Schema $schema) : void
    {
        $eventStore = $schema->createTable('event_store');
        $eventStore->addColumn('id', 'string', ['nullable' => false, 'unique' => true, 'length' => 255]);
        $eventStore->addColumn('aggregate_id', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('aggregate_type', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('playhead', 'integer', ['nullable' => false, 'unsigned' => true]);
        $eventStore->addColumn('payload', 'json', ['nullable' => false]);
        $eventStore->addColumn('metadata', 'json', ['nullable' => false]);
        $eventStore->addColumn('type', 'string', ['nullable' => false, 'length' => 255]);
        $eventStore->addColumn('recorded_on', 'datetime', ['nullable' => false]);
        $eventStore->setPrimaryKey(['id']);
        $eventStore->addUniqueIndex(['aggregate_id', 'playhead', 'aggregate_type']);
        $eventStore->addIndex(['recorded_on']);
        $eventStore->addIndex(['type']);

        $user = $schema->createTable('user');
        $user->addColumn('id', 'string', ['nullable' => false, 'unique' => true, 'length' => 255]);
        $user->addColumn('username', 'string', ['nullable' => false, 'length' => 255]);
        $user->addColumn('password', 'string', ['nullable' => false, 'length' => 255]);
        $user->addColumn('created_at', 'datetime', ['nullable' => false]);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('event_store');
        $schema->dropTable('user');
    }
}
