<?php

declare(strict_types=1);

namespace App\GiftCard\OrderProcessor;

use App\Entity\Order\Order;
use Sylius\Bundle\OrderBundle\Attribute\AsOrderProcessor;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

#[AsOrderProcessor(priority: 25)]
final class GiftCardOrderProcessor implements OrderProcessorInterface
{
    const ADJUSTMENT_TYPE = 'gift_card';

    public function __construct(
        private readonly RepositoryInterface $giftCardRepository,
        private readonly AdjustmentFactoryInterface $adjustmentFactory,
    ) {
    }

    /**
     * @param Order $order
     */
    public function process(OrderInterface $order): void
    {
        $giftCardCode = $order->getGiftCardCode();

        if ($giftCardCode === null) {
            return;
        }

        $giftCard = $this->giftCardRepository->findOneBy(['code' => $giftCardCode]);

        if ($giftCard === null) {
            return;
        }

        $order->removeAdjustmentsRecursively(GiftCardOrderProcessor::ADJUSTMENT_TYPE);
        $order->addAdjustment($this->adjustmentFactory->createWithData(
            GiftCardOrderProcessor::ADJUSTMENT_TYPE,
            'Gift card',
            -$giftCard->getAmount()
        ));
    }
}
