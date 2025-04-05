<?php

namespace App\Entity;

use App\Repository\ClassGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Student;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClassGroupRepository::class)]
class ClassGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank]
    #[Assert\Range(min: 1, max: 5)]
    private ?int $year = null;

    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'classGroup')]
    private Collection $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $students): self
    {
        if (!$this->students->contains($students)) {
            $this->students[] = $students;
            $students->setClassGroup($this);
        }
        return $this;
    }

    public function removeStudents(Student $students): self
    {
        if (!$this->students->contains($students)) {
            $this->students[] = $students;
            $students->setClassGroup($this);
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;
        return $this;
    }
}
