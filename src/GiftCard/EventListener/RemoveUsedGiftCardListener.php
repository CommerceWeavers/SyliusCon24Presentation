<?php

declare(strict_types=1);

namespace App\GiftCard\EventListener;

use App\Entity\Order\Order;
use App\GiftCard\Entity\GiftCard;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Workflow\Event\Event;
use Webmozart\Assert\Assert;

final class RemoveUsedGiftCardListener
{
    public function __construct(private readonly RepositoryInterface $giftCardRepository)
    {
    }

    #[AsEventListener(event: 'workflow.sylius_order.transition.create')]
    public function onGiftCardsMenu(Event $event): void
    {
        /** @var Order|mixed $order */
        $order = $event->getSubject();

        Assert::isInstanceOf($order, Order::class);

        if ($order->getGiftCardCode() === null) {
            return;
        }

        /** @var GiftCard|null $giftCard */
        $giftCard = $this->giftCardRepository->findOneBy(['code' => $order->getGiftCardCode()]);

        if ($giftCard === null) {
            return;
        }

        $this->giftCardRepository->remove($giftCard);
    }
}
