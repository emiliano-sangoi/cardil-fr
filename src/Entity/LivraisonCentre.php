<?php

namespace App\Entity;

use App\Repository\LivraisonCentreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LivraisonCentreRepository::class)]
#[ORM\Table(name: "livraison_centres")]
#[ORM\UniqueConstraint(name: 'uk_livraison_centres', columns: ['fournisseur_id', 'nom'])]
class LivraisonCentre implements \JsonSerializable
{
    const ETAT_OUI = 1;
    const ETAT_NON = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $altitude = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\Column(nullable: true)]
    private ?float $cout = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonCenters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fournisseur $fournisseur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $placeId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $internationalPhoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mapUrl = null;

    public function __construct()
    {
        $this->etat = self::ETAT_OUI;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'altitude' => $this->altitude,
            'cout' => $this->cout,
            'etat' => $this->etat,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nom', new Assert\NotBlank());

        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'nom' ]
        ]));

        $metadata->addPropertyConstraint('etat', new Assert\NotBlank());
        $metadata->addPropertyConstraint('etat', new Assert\Choice([
            'choices' => [self::ETAT_OUI, self::ETAT_NON]
        ]));
    }

    public function __toString(): string
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }

    public function setAltitude(float $altitude): self
    {
        $this->altitude = $altitude;

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

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function setCout(?float $cout): self
    {
        $this->cout = $cout;

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPlaceId(): ?string
    {
        return $this->placeId;
    }

    public function setPlaceId(?string $placeId): self
    {
        $this->placeId = $placeId;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getInternationalPhoneNumber(): ?string
    {
        return $this->internationalPhoneNumber;
    }

    public function setInternationalPhoneNumber(?string $internationalPhoneNumber): self
    {
        $this->internationalPhoneNumber = $internationalPhoneNumber;

        return $this;
    }

    public function getMapUrl(): ?string
    {
        return $this->mapUrl;
    }

    public function setMapUrl(?string $mapUrl): self
    {
        $this->mapUrl = $mapUrl;

        return $this;
    }
}
