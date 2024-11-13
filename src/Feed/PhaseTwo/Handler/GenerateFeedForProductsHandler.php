<?php

declare(strict_types=1);

namespace App\Feed\PhaseTwo\Handler;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Model\Element;
use App\Feed\PhaseTwo\Command\GenerateFeedForProducts;
use App\Feed\Repository\ProductRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GenerateFeedForProductsHandler
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,)
    {
    }

    public function __invoke(GenerateFeedForProducts $generateFeedForProducts): void
    {
        $elements = [];

        $products = $this->productRepository->findBy(['code' => $generateFeedForProducts->productCodes]);

        /** @var Product $product */
        foreach ($products as $product) {
            /** @var ProductVariant $productVariant */
            $productVariant = $product->getVariants()->first();
            /** @var ChannelPricing|false $first */
            $first = $productVariant->getChannelPricings()->first();

            if ($first === false) {
                continue;
            }

            $elements[] = new Element($product->getName(), $first->getPrice());
        }

        file_put_contents($this->projectDir . '/private/phase-two.txt', json_encode($elements));
    }
}