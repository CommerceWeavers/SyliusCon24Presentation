<?php

declare(strict_types=1);

namespace App\Packaging\OrderProcessor;

use App\Entity\Order\OrderItem;
use Sylius\Bundle\OrderBundle\Attribute\AsOrderProcessor;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

#[AsOrderProcessor]
final class PackagingOrderProcessor implements OrderProcessorInterface
{
    public const ADJUSTMENT_TYPE = 'packaging_fee';

    public function __construct(private readonly AdjustmentFactoryInterface $adjustmentFactory)
    {
    }

    public function process(OrderInterface $order): void
    {
        $order->removeAdjustmentsRecursively(self::ADJUSTMENT_TYPE);

        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            $packaging = $item->getPackaging();
            if (null === $packaging) {
                continue;
            }

            $item->addAdjustment(
                $this->adjustmentFactory->createWithData(
                    self::ADJUSTMENT_TYPE,
                    $packaging->getName(),
                    $packaging->getPrice()
                )
            );
        }
    }
}
