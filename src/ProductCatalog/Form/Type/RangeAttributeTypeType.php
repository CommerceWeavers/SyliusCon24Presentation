<?php

declare(strict_types=1);

namespace App\ProductCatalog\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RangeAttributeTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('min', NumberType::class, [
                'label' => 'app.ui.min',
            ])
            ->add('max', NumberType::class, [
                'label' => 'app.ui.max',
            ])
            ->add('unit', TextType::class, [
                'label' => 'app.ui.unit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'label' => false,
            ])
            ->setRequired('configuration')
            ->setDefined('locale_code')
        ;
    }
}
