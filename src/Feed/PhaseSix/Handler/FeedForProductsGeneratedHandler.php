<?php

declare(strict_types=1);

namespace App\Feed\PhaseSix\Handler;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Model\Element;
use App\Feed\PhaseSix\Command\GenerateFeedForProducts;
use App\Feed\PhaseSix\Entity\FeedMemento;
use App\Feed\PhaseSix\Event\FeedForProductsGenerated;
use App\Feed\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final readonly class FeedForProductsGeneratedHandler
{
    public function __construct(
        #[Autowire(param: 'kernel.project_dir')]
        private string $projectDir,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(FeedForProductsGenerated $feedForProductsGenerated): void
    {
        $feedMementoRepository = $this->entityManager->getRepository(FeedMemento::class);

        $feedMemento = $feedMementoRepository->findOneBy([]);

        if ($feedMemento === null) {
            $feedMemento = new FeedMemento(Uuid::v4()->toRfc4122());
            $this->entityManager->persist($feedMemento);
        }

        $feedMemento->amountOfProcessedChunks += 1;

        foreach ($feedForProductsGenerated->productFeeds as $productFeed) {
            $feedMemento->processedChunks[] = json_encode($productFeed);
        }

        if ($feedMemento->amountOfProcessedChunks === $feedForProductsGenerated->totalChunks) {
            file_put_contents($this->projectDir . '/private/phase-six.txt', json_encode($feedMemento->processedChunks));
            $this->entityManager->remove($feedMemento);
        }

        $this->entityManager->flush();
    }
}
