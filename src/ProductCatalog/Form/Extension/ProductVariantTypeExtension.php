<?php

declare(strict_types=1);

namespace App\ProductCatalog\Form\Extension;

use Sylius\Bundle\AdminBundle\Form\Type\ProductType;
use Sylius\Bundle\AdminBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('generatedGiftCardValue', MoneyType::class, [
            'label' => 'app.ui.generated_gift_card_value',
            'currency' => 'USD',
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        yield ProductVariantType::class;
    }

}
