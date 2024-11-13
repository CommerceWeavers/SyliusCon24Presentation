<?php

namespace App\Feed\PhaseEight\Grid;

use App\Feed\Entity\FeedGeneration;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class FeedGenerationGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_feed_generation';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->addField(
                StringField::create('id')
                    ->setLabel('Id')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('amountOfChunksToProcess')
                    ->setLabel('Amount of chunks to process')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('status')
                    ->setLabel('Status')
            )
            ->addField(
                StringField::create('generationPath')
                    ->setLabel('Generation path')
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    DeleteAction::create(),
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
        return FeedGeneration::class;
    }
}
