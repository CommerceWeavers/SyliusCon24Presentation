<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\Handler;

use App\Feed\Entity\FeedGeneration;
use App\Feed\Entity\SingleFeedMemento;
use App\Feed\PhaseEight\Command\GenerateFeed;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Resource\Doctrine\Persistence\RepositoryInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class GenerateFeedHandler
{
    const FILE_PATH = '/private/phase-eight.txt';

    public function __construct(
        #[Autowire(param: 'kernel.project_dir')]
        private string $projectDir,
        private EntityManagerInterface $entityManager,
        private RepositoryInterface $feedGenerationRepository,
    ) {
    }

    public function __invoke(GenerateFeed $feedForProductsGenerated): void
    {
        /** @var FeedGeneration $feedGeneration */
        $feedGeneration = $this->feedGenerationRepository->find($feedForProductsGenerated->generationId);

        $feedMementoRepository = $this->entityManager->getRepository(SingleFeedMemento::class);

        $feedMementos = $feedMementoRepository->findBy(['generationId' => $feedForProductsGenerated->generationId]);
        $elements = [];

        foreach ($feedMementos as $feedMemento) {
            foreach ($feedMemento->processedChunks as $processedChunk) {
                $elements[] = $processedChunk;
            }
        }

        file_put_contents($this->projectDir . self::FILE_PATH, json_encode($elements));

        $feedGeneration->status = FeedGeneration::GENERATED;
        $feedGeneration->generationPath = self::FILE_PATH;
    }
}
