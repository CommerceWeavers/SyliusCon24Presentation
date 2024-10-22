<?php

declare(strict_types=1);

namespace App\Packaging\Fixture;

use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class PackagingFixture extends AbstractFixture
{
    public function __construct(private EntityManagerInterface $entityManager, private FactoryInterface $packagingFactory)
    {
        $this->faker = Factory::create();
    }

    public function load(array $options): void
    {
        for ($i = 0; $i < $options['amount']; ++$i) {
            $packaging = $this->packagingFactory->createNew();
            $packaging->setName($this->faker->unique()->word);
            $packaging->setCode('PACKAGE_' . $i);
            $packaging->setPrice($this->faker->numberBetween(100, 1000));

            $this->entityManager->persist($packaging);
        }

        $this->entityManager->flush();
    }

    public function getName(): string
    {
        return 'packaging';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->integerNode('amount')->isRequired()->min(1)->end()
            ->end()
        ;
    }
}
