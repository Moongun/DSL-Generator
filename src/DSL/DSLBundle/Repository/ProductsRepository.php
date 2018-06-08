<?php

namespace DSL\DSLBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DSL\DSLBundle\Entity\Product;

class ProductsRepository extends EntityRepository
{
    public function findProductIds()
    {
        $query = $this->getEntityManager()
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('p.id')
            ->getQuery();
        
        $result = $query->getResult();
        $ids = array_column($result, 'id');
        
        return $ids;
 
    }
}
