<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Sortie::class, mappedBy="etat")
     */
    private $Etat;

    public function __construct()
    {
        $this->Etat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Sortie[]
     */
    public function getEtat(): Collection
    {
        return $this->Etat;
    }

    public function addEtat(Sortie $etat): self
    {
        if (!$this->Etat->contains($etat)) {
            $this->Etat[] = $etat;
            $etat->setEtats($this);
        }

        return $this;
    }

    public function removeEtat(Sortie $etat): self
    {
        if ($this->Etat->removeElement($etat)) {
            // set the owning side to null (unless already changed)
            if ($etat->getEtats() === $this) {
                $etat->setEtats(null);
            }
        }

        return $this;
    }
}
