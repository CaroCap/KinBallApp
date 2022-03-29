<?php

namespace App\Entity;

use App\Repository\SaisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaisonRepository::class)]
class Saison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $debut;

    #[ORM\Column(type: 'datetime')]
    private $fin;

    #[ORM\OneToMany(mappedBy: 'saison', targetEntity: Inscription::class, orphanRemoval: true)]
    private $inscriptions;

    #[ORM\OneToMany(mappedBy: 'saison', targetEntity: SeanceEntrainement::class, orphanRemoval: true)]
    private $seanceEntrainements;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->seanceEntrainements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setSaison($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSaison() === $this) {
                $inscription->setSaison(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SeanceEntrainement>
     */
    public function getSeanceEntrainements(): Collection
    {
        return $this->seanceEntrainements;
    }

    public function addSeanceEntrainement(SeanceEntrainement $seanceEntrainement): self
    {
        if (!$this->seanceEntrainements->contains($seanceEntrainement)) {
            $this->seanceEntrainements[] = $seanceEntrainement;
            $seanceEntrainement->setSaison($this);
        }

        return $this;
    }

    public function removeSeanceEntrainement(SeanceEntrainement $seanceEntrainement): self
    {
        if ($this->seanceEntrainements->removeElement($seanceEntrainement)) {
            // set the owning side to null (unless already changed)
            if ($seanceEntrainement->getSaison() === $this) {
                $seanceEntrainement->setSaison(null);
            }
        }

        return $this;
    }
}
