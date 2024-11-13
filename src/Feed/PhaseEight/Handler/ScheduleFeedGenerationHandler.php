<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Handler;

use App\Feed\Entity\FeedGeneration;
use App\Feed\PhaseEight\Command\GenerateFeedForProducts;
use App\Feed\PhaseEight\Command\ScheduleFeedGeneration;
use App\Feed\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class ScheduleFeedGenerationHandler
{
    public function __construct(
        private ProductRepository $productRepository,
        private EntityManagerInterface $feedGenerationManager,
        private MessageBusInterface $commandBus,
    ) {
    }

    public function __invoke(ScheduleFeedGeneration $scheduleFeedGeneration): void
    {
        $codesOfAllProducts = $this->productRepository->getCodesOfAllProducts();
        $codesOfAllProducts = array_map(
            fn (array $singleProductArrayWithCode): string => $singleProductArrayWithCode['code'], $codesOfAllProducts
        );

        $chunks = array_chunk($codesOfAllProducts, 1);
        $totalChunks = count($chunks);

        $feedGeneration = new FeedGeneration(Uuid::v4()->toRfc4122(), $totalChunks);
        $this->feedGenerationManager->persist($feedGeneration);

        foreach ($chunks as $chunk) {
            $this->commandBus->dispatch(new GenerateFeedForProducts($chunk, $feedGeneration->id));
        }
    }
}
