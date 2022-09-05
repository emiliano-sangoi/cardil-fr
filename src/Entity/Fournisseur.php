<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
#[ORM\Table(name: "fournisseurs")]
class Fournisseur implements \JsonSerializable
{
    const ETAT_OUI = 1;
    const ETAT_NON = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomCommercial = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $raisonSociale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse2 = null;

    #[ORM\Column(length: 24, nullable: true)]
    private ?string $codePostale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\ManyToOne(inversedBy: 'fournisseurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pays $pays = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $tel = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $fax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $tvaIntraComm = null;

    #[ORM\Column]
    private ?float $tva = null;

    #[ORM\Column]
    private ?int $etat = 1;

    #[ORM\OneToMany(mappedBy: 'fournisseur', targetEntity: LivraisonCentre::class)]
    private Collection $livraisonCenters;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $supressionDate = null;

    public function __construct()
    {
        $this->livraisonCenters = new ArrayCollection();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nomCommercial' => $this->nomCommercial,
            'raisonSociale' => $this->raisonSociale,
            'adresse1' => $this->adresse1,
            'adresse2' => $this->adresse2,
            'codePostale' => $this->codePostale,
            'ville' => $this->ville,
            'pays' => $this->pays,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'email' => $this->email,
            'siret' => $this->siret,
            'tvaIntraComm' => $this->tvaIntraComm,
            'tva' => $this->tva,
            'etat' => $this->etat,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nomCommercial', new Assert\NotBlank());
        $metadata->addPropertyConstraint('raisonSociale', new Assert\NotBlank());
        $metadata->addPropertyConstraint('adresse1', new Assert\NotBlank());
        $metadata->addPropertyConstraint('codePostale', new Assert\NotBlank());
        $metadata->addPropertyConstraint('ville', new Assert\NotBlank());
        $metadata->addPropertyConstraint('codePostale', new Assert\NotBlank());
        $metadata->addPropertyConstraint('tel', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Email());

        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'raisonSociale' ]
        ]));

        $metadata->addPropertyConstraint('etat', new Assert\NotBlank());
        $metadata->addPropertyConstraint('etat', new Assert\Choice([
            'choices' => [1, 2],
            'message' => 'Choose a valid genre.',
        ]));
    }

    public function __toString(): string
    {
        return $this->nomCommercial;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCommercial(): ?string
    {
        return $this->nomCommercial;
    }

    public function setNomCommercial(string $nomCommercial): self
    {
        $this->nomCommercial = $nomCommercial;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(?string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCodePostale(): ?string
    {
        return $this->codePostale;
    }

    public function setCodePostale(?string $codePostale): self
    {
        $this->codePostale = $codePostale;

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

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getTvaIntraComm(): ?string
    {
        return $this->tvaIntraComm;
    }

    public function setTvaIntraComm(?string $tvaIntraComm): self
    {
        $this->tvaIntraComm = $tvaIntraComm;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return array
     */
    public function getLivraisonCentersCount(): array
    {
        $res = [
            'total' => 0,
            'activos' => 0
        ];
        foreach ($this->livraisonCenters as $l){
            $res['total']++;
            if($l->getEtat() == LivraisonCentre::ETAT_OUI){
                $res['activos']++;
            }
        }

        return $res;
    }


    /**
     * @return Collection<int, LivraisonCentre>
     */
    public function getLivraisonCenters(): Collection
    {
        return $this->livraisonCenters;
    }

    public function addLivraisonCenter(LivraisonCentre $livraisonCenter): self
    {
        if (!$this->livraisonCenters->contains($livraisonCenter)) {
            $this->livraisonCenters->add($livraisonCenter);
            $livraisonCenter->setFournisseur($this);
        }

        return $this;
    }

    public function removeLivraisonCenter(LivraisonCentre $livraisonCenter): self
    {
        if ($this->livraisonCenters->removeElement($livraisonCenter)) {
            // set the owning side to null (unless already changed)
            if ($livraisonCenter->getFournisseur() === $this) {
                $livraisonCenter->setFournisseur(null);
            }
        }

        return $this;
    }

    public function getSupressionDate(): ?\DateTimeInterface
    {
        return $this->supressionDate;
    }

    public function setSupressionDate(?\DateTimeInterface $supressionDate): self
    {
        $this->supressionDate = $supressionDate;

        return $this;
    }
}
