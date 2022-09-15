<?php

namespace App\Entity;

use App\Repository\BoiteDeVitesseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: BoiteDeVitesseRepository::class)]
#[ORM\Table(name: "boite_de_vitesses")]
#[ORM\UniqueConstraint(name: 'uk1_boite_de_vitesses', columns: ['nom'])]
class BoiteDeVitesse implements \JsonSerializable
{
    const ETAT_OUI = 1;
    const ETAT_NON = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?int $ordre = null;

    #[ORM\Column(nullable: true)]
    private ?int $etat = null;

    public function __construct()
    {
        $this->etat = self::ETAT_OUI;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'ordre' => $this->ordre,
            'etat' => $this->etat,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nom', new Assert\NotBlank());
        $metadata->addPropertyConstraint('ordre', new Assert\Type('numeric'));
        $metadata->addPropertyConstraint('etat', new Assert\Type('numeric'));
        $metadata->addPropertyConstraint('etat', new Assert\Choice([self::ETAT_OUI, self::ETAT_NON]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'nom' ]
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

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(?int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(?int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
