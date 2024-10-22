<?php

declare(strict_types=1);

namespace App\ProductCatalog\Form\Extension;

use Sylius\Bundle\AdminBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('packable');
    }

    public static function getExtendedTypes(): iterable
    {
        yield ProductType::class;
    }

}
