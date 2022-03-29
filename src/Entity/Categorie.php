<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $typeCategorie;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Inscription::class)]
    private $inscriptions;

    #[ORM\ManyToMany(targetEntity: SeanceEntrainement::class, mappedBy: 'categorie')]
    private $seanceEntrainements;

    //HYDRATE CONSTRUCT + ArrayCollection ManyToOne
    public function __construct(array $init = [])
    {
        $this->hydrate($init);
        $this->inscriptions = new ArrayCollection();
        $this->seanceEntrainements = new ArrayCollection();
    }

    // HYDRATE pour mettre à jour les attributs des entités
    public function hydrate(array $vals)
    {
        foreach ($vals as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this,$method)){
                $this->$method($value);
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeCategorie(): ?string
    {
        return $this->typeCategorie;
    }

    public function setTypeCategorie(string $typeCategorie): self
    {
        $this->typeCategorie = $typeCategorie;

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
            $inscription->setCategorie($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getCategorie() === $this) {
                $inscription->setCategorie(null);
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
            $seanceEntrainement->addCategorie($this);
        }

        return $this;
    }

    public function removeSeanceEntrainement(SeanceEntrainement $seanceEntrainement): self
    {
        if ($this->seanceEntrainements->removeElement($seanceEntrainement)) {
            $seanceEntrainement->removeCategorie($this);
        }

        return $this;
    }
}
