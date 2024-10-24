<?php

declare(strict_types=1);

namespace App\Feed\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

final class ProductRepository extends BaseProductRepository
{
    /**
     * @return array<array{'code': string}>
     */
    public function getCodesOfAllProducts(): array
    {
        return $this->createQueryBuilder('o')
            ->select('o.code')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
