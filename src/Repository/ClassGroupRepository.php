<?php

namespace App\Repository;

use App\Entity\ClassGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassGroup>
 */
class ClassGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassGroup::class);
    }

    public function add(ClassGroup $classGroup): void
    {
        $this->getEntityManager()->persist($classGroup);
        $this->getEntityManager()->flush();
    }

    public function remove(ClassGroup $classGroup): void
    {
        $this->getEntityManager()->remove($classGroup);
        $this->getEntityManager()->flush();
    }
}
