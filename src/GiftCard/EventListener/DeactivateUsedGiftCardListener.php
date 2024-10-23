<?php

declare(strict_types=1);

namespace App\GiftCard\EventListener;

use App\Entity\Order\Order;
use App\GiftCard\Entity\GiftCard;
use Sylius\Abstraction\StateMachine\StateMachineInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Workflow;
use Webmozart\Assert\Assert;

final class DeactivateUsedGiftCardListener
{
    public function __construct(
        private readonly RepositoryInterface $giftCardRepository,
        private readonly StateMachineInterface $compositeStateMachine
    ) {
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

        $this->compositeStateMachine->apply($giftCard, 'gift_card', 'deactivate');
    }
}
