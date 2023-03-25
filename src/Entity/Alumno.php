<?php

namespace App\Entity;

use App\Repository\AlumnoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlumnoRepository::class)]
#[ORM\Table(name : 'alumno')]

class Alumno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CursoAsignatura $cursoAsignatura = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable : true)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255, nullable : true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255, nullable : true)]
    private ?string $rut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable : true)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaActualizacion = null;

    #[ORM\ManyToOne(inversedBy: 'alumnos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Curso $curso = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCursoAsignatura(): ?CursoAsignatura
    {
        return $this->cursoAsignatura;
    }

    public function setCursoAsignatura(?CursoAsignatura $cursoAsignatura): self
    {
        $this->cursoAsignatura = $cursoAsignatura;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getRut(): ?string
    {
        return $this->rut;
    }

    public function setRut(string $rut): self
    {
        $this->rut = $rut;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getFechaActualizacion(): ?\DateTimeInterface
    {
        return $this->fechaActualizacion;
    }

    public function setFechaActualizacion(?\DateTimeInterface $fechaActualizacion): self
    {
        $this->fechaActualizacion = $fechaActualizacion;

        return $this;
    }

    public function __toString()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }

}
