<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241022200141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add gift card entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE GiftCard (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE GiftCard');
    }
}
