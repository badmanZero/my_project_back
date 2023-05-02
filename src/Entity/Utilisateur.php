<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="id_affectation")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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
            $relationTask->setIdEtat($this);
        }

        return $this;
    }

    public function removeRelationTask(Task $relationTask): self
    {
        if ($this->relationTask->removeElement($relationTask)) {
            // set the owning side to null (unless already changed)
            if ($relationTask->getIdEtat() === $this) {
                $relationTask->setIdEtat(null);
            }
        }

        return $this;
    }
}
