<?php

declare(strict_types=1);

namespace App\Feed\PhaseFive\Handler;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Model\Element;
use App\Feed\PhaseFive\Command\GenerateFeedForProducts;
use App\Feed\PhaseFive\Event\FeedForProductsGenerated;
use App\Feed\Repository\ProductRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FeedForProductsGeneratedHandler
{
    public function __construct(
        #[Autowire(param: 'kernel.project_dir')]
        private string $projectDir,
    ) {
    }

    public function __invoke(FeedForProductsGenerated $feedForProductsGenerated): void
    {
        file_put_contents(
            $this->projectDir . '/private/phase-five.txt',
            json_encode($feedForProductsGenerated->productFeeds)
        );
    }
}
