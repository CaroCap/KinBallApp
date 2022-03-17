<?php

namespace App\Entity;

use App\Repository\ParticipationEntrainementRepository;
use Doctrine\ORM\Mapping as ORM;

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
