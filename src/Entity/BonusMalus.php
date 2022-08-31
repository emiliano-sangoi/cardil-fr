<?php

namespace App\Entity;

use App\Repository\BonusMalusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BonusMalusRepository::class)]
#[ORM\Table(name: "bonus_maluss")]
#[ORM\UniqueConstraint(name: 'uk_bonus_malus', columns: ['min_co2', 'max_co2'])]
class BonusMalus implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $minCO2 = null;

    #[ORM\Column]
    private ?float $maxCO2 = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $lettre = null;

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'minCO2' => $this->minCO2,
            'maxCO2' => $this->maxCO2,
            'montant' => $this->montant,
            'lettre' => $this->lettre,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('minCO2', new Assert\NotBlank());
        $metadata->addPropertyConstraint('maxCO2', new Assert\NotBlank());
        $metadata->addPropertyConstraint('montant', new Assert\NotBlank());

        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'minCO2', 'maxCO2' ]
        ]));

    }

    public function __toString(): string
    {
        return $this->minCO2 . ' - ' . $this->maxCO2 . ' -> ' . $this->montant;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinCO2(): ?float
    {
        return $this->minCO2;
    }

    public function setMinCO2(float $minCO2): self
    {
        $this->minCO2 = $minCO2;

        return $this;
    }

    public function getMaxCO2(): ?float
    {
        return $this->maxCO2;
    }

    public function setMaxCO2(float $maxCO2): self
    {
        $this->maxCO2 = $maxCO2;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getLettre(): ?string
    {
        return $this->lettre;
    }

    public function setLettre(?string $lettre): self
    {
        $this->lettre = $lettre;

        return $this;
    }
}
