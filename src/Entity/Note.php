<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom de l'étudiant est obligatoire.")]
    private ?string $nomEtudiant = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "La matière est obligatoire.")]
    private ?string $matiere = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La note est obligatoire.")]
    #[Assert\Range(
    min: 0,
    max: 20,
    notInRangeMessage: 'La note doit être comprise entre {{ min }} et {{ max }}.'
    )]    
    private ?float $note = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEtudiant(): ?string
    {
        return $this->nomEtudiant;
    }

    public function setNomEtudiant(string $nomEtudiant): static
    {
        $this->nomEtudiant = $nomEtudiant;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): static
    {
        $this->note = $note;

        return $this;
    }
}