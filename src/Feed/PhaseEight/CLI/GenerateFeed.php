<?php

declare(strict_types=1);

namespace App\Feed\PhaseEight\CLI;

use App\Feed\PhaseEight\Command\ScheduleFeedGeneration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class GenerateFeed extends Command
{
    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:generate-feed:eight')
            ->setDescription('Generate feed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new ScheduleFeedGeneration());

        return 0;
    }
}
