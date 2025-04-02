<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Student;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $totalGrade = null;

    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: "projects")]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudents(Student $students): self
    {
        if (!$this->students->contains($students)) {
            $this->students[] = $students;
        }
        return $this;
    }

    public function removeStudents(Student $students): self
    {
        $this->students->removeElement($students);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTotalGrade(): ?int
    {
        return $this->totalGrade;
    }

    public function setTotalGrade(?int $totalGrade): static
    {
        $this->totalGrade = $totalGrade;

        return $this;
    }
}
