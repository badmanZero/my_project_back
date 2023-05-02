<?php

namespace App\Entity;

use App\Repository\TypeTaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeTaskRepository::class)
 */
class TypeTask
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="type")
     */
    private $relationTask;

    public function __construct()
    {
        $this->relationTask = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getRelationTask(): Collection
    {
        return $this->relationTask;
    }

    public function addRelationTask(Task $relationTask): self
    {
        if (!$this->relationTask->contains($relationTask)) {
            $this->relationTask[] = $relationTask;
            $relationTask->setType($this);
        }

        return $this;
    }

    public function removeRelationTask(Task $relationTask): self
    {
        if ($this->relationTask->removeElement($relationTask)) {
            // set the owning side to null (unless already changed)
            if ($relationTask->getType() === $this) {
                $relationTask->setType(null);
            }
        }

        return $this;
    }
}
