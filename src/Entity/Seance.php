<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $title;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime')]
    private $start;

    #[ORM\Column(type: 'datetime')]
    private $end;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $rue;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $numero;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $codePostal;

    #[ORM\Column(type: 'string', length: 150, nullable: true)]
    private $ville;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: ParticipationEntrainement::class)]
    private $participationEntrainements;


    //HYDRATE CONSTRUCT + ArrayCollection ManyToOne
    public function __construct(array $init = [])
    {
        $this->hydrate($init);
        $this->users = new ArrayCollection();
        $this->participationEntrainements = new ArrayCollection();
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

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, ParticipationEntrainement>
     */
    public function getParticipationEntrainements(): Collection
    {
        return $this->participationEntrainements;
    }

    public function addParticipationEntrainement(ParticipationEntrainement $participationEntrainement): self
    {
        if (!$this->participationEntrainements->contains($participationEntrainement)) {
            $this->participationEntrainements[] = $participationEntrainement;
            $participationEntrainement->setSeance($this);
        }

        return $this;
    }

    public function removeParticipationEntrainement(ParticipationEntrainement $participationEntrainement): self
    {
        if ($this->participationEntrainements->removeElement($participationEntrainement)) {
            // set the owning side to null (unless already changed)
            if ($participationEntrainement->getSeance() === $this) {
                $participationEntrainement->setSeance(null);
            }
        }

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

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

}
