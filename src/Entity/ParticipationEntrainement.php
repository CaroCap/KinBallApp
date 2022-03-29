<?php

namespace App\Entity;

use App\Entity\Inscription;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\SeanceEntrainement;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\ParticipationEntrainementRepository;

#[ORM\Entity(repositoryClass: ParticipationEntrainementRepository::class)]
class ParticipationEntrainement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $typePresence;

    #[ORM\ManyToOne(targetEntity: Inscription::class, inversedBy: 'participationEntrainements')]
    #[ORM\JoinColumn(nullable: false)]
    private $inscription;

    #[ORM\ManyToOne(targetEntity: SeanceEntrainement::class, inversedBy: 'participationEntrainements')]
    private $seance;

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

    public function getTypePresence(): ?string
    {
        return $this->typePresence;
    }

    public function setTypePresence(?string $typePresence): self
    {
        $this->typePresence = $typePresence;

        return $this;
    }

    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getSeance(): ?SeanceEntrainement
    {
        return $this->seance;
    }

    public function setSeance(?SeanceEntrainement $seance): self
    {
        $this->seance = $seance;

        return $this;
    }
}
