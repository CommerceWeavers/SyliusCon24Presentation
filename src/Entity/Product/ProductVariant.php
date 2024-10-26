<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductVariant as BaseProductVariant;
use Sylius\Component\Product\Model\ProductVariantTranslationInterface;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product_variant')]
class ProductVariant extends BaseProductVariant
{
    #[ORM\Column(nullable: true)]
    private ?int $generatedGiftCardValue = null;

    protected function createTranslation(): ProductVariantTranslationInterface
    {
        return new ProductVariantTranslation();
    }

    public function getGeneratedGiftCardValue(): ?int
    {
        return $this->generatedGiftCardValue;
    }

    public function setGeneratedGiftCardValue(int $generatedGiftCardValue): static
    {
        $this->generatedGiftCardValue = $generatedGiftCardValue;

        return $this;
    }
}
