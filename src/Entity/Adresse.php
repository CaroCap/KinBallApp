<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $rue;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $numero;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $codePostal;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $ville;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $pays;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $nomLieu;

    #[ORM\Column(type: 'string', length: 50)]
    private $typeAdresse;

    #[ORM\OneToMany(mappedBy: 'adresse', targetEntity: SeanceEntrainement::class)]
    private $seanceEntrainements;

    //HYDRATE CONSTRUCT + ArrayCollection ManyToOne
    public function __construct(array $init = [])
    {
        $this->hydrate($init);
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getNomLieu(): ?string
    {
        return $this->nomLieu;
    }

    public function setNomLieu(?string $nomLieu): self
    {
        $this->nomLieu = $nomLieu;

        return $this;
    }

    public function getTypeAdresse(): ?string
    {
        return $this->typeAdresse;
    }

    public function setTypeAdresse(string $typeAdresse): self
    {
        $this->typeAdresse = $typeAdresse;

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
            $seanceEntrainement->setAdresse($this);
        }

        return $this;
    }

    public function removeSeanceEntrainement(SeanceEntrainement $seanceEntrainement): self
    {
        if ($this->seanceEntrainements->removeElement($seanceEntrainement)) {
            // set the owning side to null (unless already changed)
            if ($seanceEntrainement->getAdresse() === $this) {
                $seanceEntrainement->setAdresse(null);
            }
        }

        return $this;
    }
}
