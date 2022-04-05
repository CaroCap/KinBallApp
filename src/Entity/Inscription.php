<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Seance;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $jourEntrainement;

    #[ORM\Column(type: 'datetime')]
    private $dateInscription;

    #[ORM\Column(type: 'boolean')]
    private $paiement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datePaiement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ficheMedicale;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $certifMedical;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $player;

    #[ORM\ManyToOne(targetEntity: Saison::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private $saison;

    //HYDRATE CONSTRUCT + ArrayCollection ManyToOne
    public function __construct(array $init = [])
    {
        $this->hydrate($init);
        $this->users = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
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

    public function getJourEntrainement(): ?string
    {
        return $this->jourEntrainement;
    }

    public function setJourEntrainement(string $jourEntrainement): self
    {
        $this->jourEntrainement = $jourEntrainement;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getPaiement(): ?bool
    {
        return $this->paiement;
    }

    public function setPaiement(bool $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?\DateTimeInterface $datePaiement): self
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    public function getFicheMedicale()
    {
        return $this->ficheMedicale;
    }

    public function setFicheMedicale($ficheMedicale)
    {
        $this->ficheMedicale = $ficheMedicale;

        return $this;
    }

    public function getCertifMedical()
    {
        return $this->certifMedical;
    }

    public function setCertifMedical($certifMedical)
    {
        $this->certifMedical = $certifMedical;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getPlayer(): ?User
    {
        return $this->player;
    }

    public function setPlayer(?User $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getSaison(): ?Saison
    {
        return $this->saison;
    }

    public function setSaison(?Saison $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

}
