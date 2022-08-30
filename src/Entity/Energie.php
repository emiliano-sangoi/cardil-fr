<?php

namespace App\Entity;

use App\Repository\EnergieRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: EnergieRepository::class)]
#[ORM\Table(name: "energies")]
class Energie implements \JsonSerializable
{
    const ETAT_OUI = 1;
    const ETAT_NON = 2;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\Column]
    private ?int $ordre = 0;

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

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'etat' => $this->etat,
            'ordre' => $this->ordre,
        ];
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('nom', new Assert\NotBlank([
            'message' => 'Required field.',
        ]));

        $metadata->addConstraint(new UniqueEntity([
            'fields' => 'nom'
        ]));


        $metadata->addPropertyConstraint('etat', new Assert\NotBlank([
            'message' => 'Required field.',
        ]));

        $metadata->addPropertyConstraint('etat', new Assert\Choice([
            'choices' => [1, 2],
            'message' => 'Choose a valid genre.',
        ]));
    }
}
