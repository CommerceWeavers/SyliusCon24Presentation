<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241022192433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change price column type to integer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE Packaging CHANGE price price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE Packaging CHANGE price price VARCHAR(255) NOT NULL');
    }
}
