<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241023200959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add state to GiftCard';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE GiftCard ADD state VARCHAR(255) DEFAULT \'active\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE GiftCard DROP state');
    }
}
