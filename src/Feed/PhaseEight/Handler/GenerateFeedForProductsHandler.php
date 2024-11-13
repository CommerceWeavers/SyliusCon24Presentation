<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Handler;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Entity\SingleFeedMemento;
use App\Feed\Model\Element;
use App\Feed\PhaseEight\Command\GenerateFeedForProducts;
use App\Feed\PhaseEight\Event\FeedForProductsGenerated;
use App\Feed\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class GenerateFeedForProductsHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private MessageBusInterface $eventBus,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(GenerateFeedForProducts $generateFeedForProducts): void
    {
        $elements = [];

        /** @var Product $product */
        foreach ($this->productRepository->findBy(['code' => $generateFeedForProducts->productCodes]) as $product) {
            /** @var ProductVariant $productVariant */
            $productVariant = $product->getVariants()->first();
            /** @var ChannelPricing|false $first */
            $first = $productVariant->getChannelPricings()->first();

            if ($first === false) {
                continue;
            }

            $elements[] = new Element($product->getName(), $first->getPrice());
        }

        $feedMemento = new SingleFeedMemento(
            Uuid::v4()->toRfc4122(),
            $generateFeedForProducts->id,
            $elements
        );

        $this->entityManager->persist($feedMemento);

        $this->eventBus->dispatch(new FeedForProductsGenerated($generateFeedForProducts->id));
    }
}
