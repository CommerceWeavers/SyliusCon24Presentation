<?php

declare(strict_types=1);

namespace App\Feed\PhaseSeven\Handler;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Model\Element;
use App\Feed\PhaseSeven\Command\GenerateFeedForProducts;
use App\Feed\PhaseSeven\Event\FeedForProductsGenerated;
use App\Feed\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

#[AsMessageHandler]
final readonly class GenerateFeedForProductsHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private MessageBusInterface $eventBus,
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

        $this->eventBus->dispatch(new FeedForProductsGenerated($elements, $generateFeedForProducts->totalChunks));
    }
}
