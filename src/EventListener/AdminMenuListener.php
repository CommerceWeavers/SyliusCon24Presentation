<?php

declare(strict_types=1);

namespace App\EventListener;

use Sylius\Bundle\AdminBundle\Menu\MainMenuBuilder;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class AdminMenuListener
{
    #[AsEventListener(event: MainMenuBuilder::EVENT_NAME)]
    public function onPackagingsMenu(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();
        $catalogSubmenu = $menu->getChild('catalog');

        $catalogSubmenu
            ->addChild('packagings', ['route' => 'app_admin_packaging_index'])
            ->setLabel('app.ui.packagings')
            ->setLabelAttribute('icon', 'box')
        ;

    }
}
