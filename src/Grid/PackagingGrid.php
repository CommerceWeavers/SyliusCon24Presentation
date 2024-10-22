<?php

namespace App\Grid;

use App\Entity\Packaging;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;

final class PackagingGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_packaging';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            // see https://github.com/Sylius/SyliusGridBundle/blob/master/docs/field_types.md
            ->addField(
                StringField::create('name')
                    ->setLabel('Name')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('code')
                    ->setLabel('Code')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('price')
                    ->setLabel('Price')
                    ->setSortable(true)
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                    UpdateAction::create(),
                    DeleteAction::create()
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
        return Packaging::class;
    }
}
