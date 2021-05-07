<?php

namespace App\Entity;

use App\Repository\RepportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepportRepository::class)
 */
class Repport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $message;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private ?User $patient;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }
}
