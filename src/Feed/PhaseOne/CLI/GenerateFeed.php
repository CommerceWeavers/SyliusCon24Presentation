<?php

declare(strict_types=1);

namespace App\Feed\PhaseOne\CLI;

use App\Entity\Channel\ChannelPricing;
use App\Entity\Product\Product;
use App\Entity\Product\ProductVariant;
use App\Feed\Model\Element;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class GenerateFeed extends Command
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:generare-feed:one')
            ->setDescription('Lists available fixtures')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $elements = [];
        /** @var Product $product */
        foreach ($this->productRepository->findAll() as $product) {
            /** @var ProductVariant $productVariant */
            $productVariant = $product->getVariants()->first();
            /** @var ChannelPricing|false $first */
            $first = $productVariant->getChannelPricings()->first();

            if ($first === false) {
                continue;
            }

            $elements[] = new Element($product->getName(), $first->getPrice());
        }

        file_put_contents($this->projectDir . '/private/phase-one.txt',json_encode($elements));

        return 0;
    }
}
