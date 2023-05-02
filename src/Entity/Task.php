<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="relationTask")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEtat;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="relationTask")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_affectation;

    /**
     * @ORM\ManyToOne(targetEntity=TypeTask::class, inversedBy="relationTask")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=SubTask::class, mappedBy="idTask")
     */
    private $subTasks;

    public function __construct()
    {
        $this->subTasks = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdEtat(): ?State
    {
        return $this->idEtat;
    }

    public function setIdEtat(?State $idEtat): self
    {
        $this->idEtat = $idEtat;

        return $this;
    }

    public function getIdAffectation(): ?Utilisateur
    {
        return $this->id_affectation;
    }

    public function setIdAffectation(?Utilisateur $id_affectation): self
    {
        $this->id_affectation = $id_affectation;

        return $this;
    }

    public function getType(): ?TypeTask
    {
        return $this->type;
    }

    public function setType(?TypeTask $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, SubTask>
     */
    public function getSubTasks(): Collection
    {
        return $this->subTasks;
    }

    public function addSubTask(SubTask $subTask): self
    {
        if (!$this->subTasks->contains($subTask)) {
            $this->subTasks[] = $subTask;
            $subTask->setIdTask($this);
        }

        return $this;
    }

    public function removeSubTask(SubTask $subTask): self
    {
        if ($this->subTasks->removeElement($subTask)) {
            // set the owning side to null (unless already changed)
            if ($subTask->getIdTask() === $this) {
                $subTask->setIdTask(null);
            }
        }

        return $this;
    }
}
