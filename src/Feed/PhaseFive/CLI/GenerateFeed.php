<?php

declare(strict_types=1);

namespace App\Feed\PhaseFive\CLI;

use App\Feed\PhaseFive\Command\GenerateFeedForProducts;
use App\Feed\Repository\ProductRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class GenerateFeed extends Command
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:generare-feed:five')
            ->setDescription('Lists available fixtures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $codesOfAllProducts = $this->productRepository->getCodesOfAllProducts();

        $codesOfAllProducts = array_map(fn (array $singleProductArrayWithCode) => $singleProductArrayWithCode['code'], $codesOfAllProducts);

        foreach (array_chunk($codesOfAllProducts, 5) as $chunk) {
            $this->commandBus->dispatch(new GenerateFeedForProducts($chunk));
        }

        return 0;
    }
}
