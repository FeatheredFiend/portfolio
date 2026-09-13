<?php

namespace App\Repository;

use App\Entity\EducationEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EducationEntry>
 */
class EducationEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EducationEntry::class);
    }

    /** @return list<EducationEntry> */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['position' => 'ASC']);
    }
}
