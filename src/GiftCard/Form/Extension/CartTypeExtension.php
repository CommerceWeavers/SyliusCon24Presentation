<?php

declare(strict_types=1);

namespace App\GiftCard\Form\Extension;

use Sylius\Bundle\OrderBundle\Form\Type\CartType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class CartTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('giftCardCode', null, [
            'label' => 'app.form.cart.gift_card_code',
        ]);
    }

    public static function getExtendedTypes(): iterable
    {
        yield CartType::class;
    }
}
