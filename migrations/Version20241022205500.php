<?php

declare(strict_types=1);

namespace App;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241022205500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add generatedGiftCardValue to ProductVariant';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product_variant ADD generatedGiftCardValue INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE sylius_product_variant DROP generatedGiftCardValue');
    }
}
