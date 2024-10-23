<?php

declare(strict_types=1);

namespace App\GiftCard\EventListener;

use App\Entity\Order\Order;
use App\Entity\Order\OrderItem;
use App\Entity\Product\ProductVariant;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Workflow\Event\Event;
use Webmozart\Assert\Assert;

final class GenerateGiftCardListener
{
    public function __construct(
        private readonly FactoryInterface $giftCardFactory,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[AsEventListener(event: 'workflow.sylius_order.transition.create')]
    public function onGiftCardsMenu(Event $event): void
    {
        /** @var Order|mixed $order */
        $order = $event->getSubject();

        Assert::isInstanceOf($order, Order::class);

        /** @var OrderItem $item */
        foreach ($order->getItems() as $item) {
            /** @var ProductVariant $variant */
            $variant = $item->getVariant();
            if ($variant->getGeneratedGiftCardValue() === null || $variant->getGeneratedGiftCardValue() === 0) {
                continue;
            }

            $giftCard = $this->giftCardFactory->createNew();
            $giftCard->setCode(Uuid::v7()->toRfc4122());
            $giftCard->setAmount($variant->getGeneratedGiftCardValue() * 100);

            $this->entityManager->persist($giftCard);
        }
    }
}
