<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dia = null;

    #[ORM\Column]
    private ?\DateInterval $periodicidad = null;

    #[ORM\Column(length: 255)]
    private ?string $categoria = null;

    #[ORM\Column(length: 100)]
    private ?string $tipo = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'evento')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDia(): ?\DateTimeInterface
    {
        return $this->dia;
    }

    public function setDia(\DateTimeInterface $dia): self
    {
        $this->dia = $dia;

        return $this;
    }

    public function getPeriodicidad(): ?\DateInterval
    {
        return $this->periodicidad;
    }

    public function setPeriodicidad(\DateInterval $periodicidad): self
    {
        $this->periodicidad = $periodicidad;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

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
