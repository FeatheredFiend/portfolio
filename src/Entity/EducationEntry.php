<?php

namespace App\Entity;

use App\Repository\EducationEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EducationEntryRepository::class)]
class EducationEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'date_immutable')]
    #[Assert\NotNull]
    private ?\DateTimeImmutable $startDate = null;

    /** Null means "current". */
    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    private string $university = '';

    #[ORM\Column(length: 160)]
    #[Assert\NotBlank]
    private string $qualification = '';

    #[ORM\Column]
    private int $position = 0;

    /** @var Collection<int, EducationCourse> */
    #[ORM\OneToMany(targetEntity: EducationCourse::class, mappedBy: 'educationEntry', orphanRemoval: true, cascade: ['persist'])]
    #[ORM\OrderBy(['position' => 'ASC'])]
    private Collection $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUniversity(): string
    {
        return $this->university;
    }

    public function setUniversity(string $university): static
    {
        $this->university = $university;

        return $this;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): static
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /** @return Collection<int, EducationCourse> */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(EducationCourse $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setEducationEntry($this);
        }

        return $this;
    }

    public function removeCourse(EducationCourse $course): static
    {
        $this->courses->removeElement($course);

        return $this;
    }
}
