<?php

declare(strict_types=1);

namespace App\Packaging\Form\Extension;

use App\Packaging\Entity\Packaging;
use Sylius\Bundle\ShopBundle\Form\Type\CartItemType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CartItemTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            if (!$event->getData()->getProduct()->isPackable()) {
                return;
            }

            $event->getForm()->add('packaging', EntityType::class, [
                'label' => 'Package',
                'class' => Packaging::class,
                'choice_label' => 'name',
                'placeholder' => 'Select packaging',
                'required' => false,
            ]);
        });
    }

    public static function getExtendedTypes(): iterable
    {
        yield CartItemType::class;
    }

}
