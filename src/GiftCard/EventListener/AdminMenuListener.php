<?php

declare(strict_types=1);

namespace App\GiftCard\EventListener;

use Sylius\Bundle\AdminBundle\Menu\MainMenuBuilder;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class AdminMenuListener
{
    #[AsEventListener(event: MainMenuBuilder::EVENT_NAME)]
    public function onGiftCardsMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $salesSubmenu = $menu->getChild('sales');

        $salesSubmenu
            ->addChild('GiftCards', ['route' => 'app_admin_gift_card_index'])
            ->setLabel('app.ui.gift_cards')
            ->setLabelAttribute('icon', 'gift')
        ;

    }
}
