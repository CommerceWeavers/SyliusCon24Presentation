<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\ProcessManager;

use App\Feed\Entity\FeedGeneration;
use App\Feed\Entity\SingleFeedMemento;
use App\Feed\PhaseEight\Command\GenerateFeed;
use App\Feed\PhaseEight\Event\FeedForProductsGenerated;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class FeedForProductsGeneratedProcessManager
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private EntityManagerInterface $entityManager,
        private RepositoryInterface $feedGenerationRepository,
    ) {
    }

    public function __invoke(FeedForProductsGenerated $feedForProductsGenerated): void
    {
        $singleFeedMementoRepository = $this->entityManager->getRepository(SingleFeedMemento::class);

        $generationId = $feedForProductsGenerated->generationId;

        $feedMementosCount = $singleFeedMementoRepository->countFeedsForGivenGeneration($generationId);
        /** @var FeedGeneration $feedGeneration */
        $feedGeneration = $this->feedGenerationRepository->find($generationId);

        if ($feedGeneration->amountOfChunksToProcess === $feedMementosCount) {
            $this->commandBus->dispatch(new GenerateFeed($generationId));
        }
    }
}
