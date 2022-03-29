<?php

namespace App\Entity;

use App\Entity\Inscription;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Seance;
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

    #[ORM\ManyToOne(targetEntity: Seance::class, inversedBy: 'participationEntrainements')]
    private $seance;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'participationEntrainements')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

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

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): self
    {
        $this->seance = $seance;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
