<?php

declare(strict_types=1);

namespace App\ProductCatalog\AttributeType;

use App\ProductCatalog\Form\Type\RangeAttributeTypeType;
use Sylius\Component\Attribute\AttributeType\AttributeTypeInterface;
use Sylius\Component\Attribute\Model\AttributeValueInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[AutoconfigureTag(name: 'sylius.attribute.type', attributes: ['attribute_type' => self::TYPE, 'form_type' => RangeAttributeTypeType::class, 'label' => 'app.ui.range'])]
final class RangeAttributeType implements AttributeTypeInterface
{
    public const TYPE = 'range';

    public function getStorageType(): string
    {
        return AttributeValueInterface::STORAGE_JSON;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function validate(AttributeValueInterface $attributeValue, ExecutionContextInterface $context, array $configuration): void
    {
        return;
    }
}
