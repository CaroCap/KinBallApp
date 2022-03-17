<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SeanceEntrainementRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SeanceEntrainementRepository::class)]
class SeanceEntrainement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $dateEntrainement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heureDebut;

    #[ORM\Column(type: 'time', nullable: true)]
    private $heureFin;

    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'seanceEntrainements')]
    private $adresse;

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

    public function getDateEntrainement(): ?\DateTimeInterface
    {
        return $this->dateEntrainement;
    }

    public function setDateEntrainement(\DateTimeInterface $dateEntrainement): self
    {
        $this->dateEntrainement = $dateEntrainement;

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

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(?\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(?\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

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
}
