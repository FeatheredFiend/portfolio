<?php

namespace App\Repository;

use App\Entity\EmploymentEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmploymentEntry>
 */
class EmploymentEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmploymentEntry::class);
    }

    /** @return list<EmploymentEntry> */
    public function findAllOrdered(): array
    {
        return $this->findBy([], ['position' => 'ASC']);
    }
}
