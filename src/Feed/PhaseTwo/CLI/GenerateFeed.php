<?php

declare(strict_types=1);

namespace App\Feed\PhaseTwo\CLI;

use App\Feed\PhaseTwo\Command\GenerateFeedForProducts;
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
            ->setName('app:generate-feed:two')
            ->setDescription('Generate feed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $codesOfAllProducts = $this->productRepository->getCodesOfAllProducts();

        $codesOfAllProducts = array_map(
            fn (array $singleProductArrayWithCode) => $singleProductArrayWithCode['code'],
            $codesOfAllProducts
        );

        $this->commandBus->dispatch(new GenerateFeedForProducts($codesOfAllProducts));

        return 0;
    }
}
