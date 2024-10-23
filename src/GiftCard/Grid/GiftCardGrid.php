<?php

namespace App\GiftCard\Grid;

use App\GiftCard\Entity\GiftCard;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\ApplyTransitionAction;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class GiftCardGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_gift_card';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            // see https://github.com/Sylius/SyliusGridBundle/blob/master/docs/field_types.md
            ->addField(
                StringField::create('code')
                    ->setLabel('Code')
                    ->setSortable(true)
            )
            ->addField(
                TwigField::create('amount', 'admin/gift_card/grid/_amount.html.twig')
                    ->setLabel('Amount')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('state')
                    ->setLabel('State')
                    ->setSortable(true)
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    UpdateAction::create(),
                    DeleteAction::create(),
                    ApplyTransitionAction::create(
                        'deactivate',
                        'app_admin_gift_card_deactivate',
                        ['id' => 'resource.id'],
                        [
                            'graph' => 'gift_card',
                            'transition' => 'deactivate',
                            'class' => 'btn btn-icon text-danger',
                        ]
                    )
                        ->setIcon('x')
                        ->setLabel('Deactivate')
                    ,
                )
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create()
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return GiftCard::class;
    }
}
