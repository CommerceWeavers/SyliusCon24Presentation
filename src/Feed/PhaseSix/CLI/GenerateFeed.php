<?php

declare(strict_types=1);

namespace App\Feed\PhaseSix\CLI;

use App\Feed\PhaseSix\Command\GenerateFeedForProducts;
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
            ->setName('app:generare-feed:six')
            ->setDescription('Lists available fixtures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $codesOfAllProducts = $this->productRepository->getCodesOfAllProducts();

        $codesOfAllProducts = array_map(fn (array $singleProductArrayWithCode) => $singleProductArrayWithCode['code'], $codesOfAllProducts);

        $chunks = array_chunk($codesOfAllProducts, 1);
        foreach ($chunks as $chunk) {
            $this->commandBus->dispatch(new GenerateFeedForProducts($chunk, count($chunks)));
        }

        return 0;
    }
}
