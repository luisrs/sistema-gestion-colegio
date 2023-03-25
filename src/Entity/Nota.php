<?php

namespace App\Entity;

use App\Repository\NotaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotaRepository::class)]
class Nota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable : true)]
    private ?string $calificacion = null;

    #[ORM\ManyToOne(inversedBy: 'notas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CursoAsignatura $asignatura = null;

    #[ORM\ManyToOne(inversedBy: 'notas')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Alumno $alumno = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?bool $concepto = false;

    #[ORM\Column(length: 255, nullable : true)]
    private ?string $descripcion = null;

    #[ORM\Column(nullable: true)]
    private ?int $porcentaje = null;

    #[ORM\ManyToOne(inversedBy: 'notas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Periodo $periodo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalificacion(): ?string
    {
        return $this->calificacion;
    }

    public function setCalificacion(string $calificacion): self
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    public function getAsignatura(): ?CursoAsignatura
    {
        return $this->asignatura;
    }

    public function setAsignatura(?CursoAsignatura $asignatura): self
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }

    public function getnombre(): ?string
    {
        return $this->nombre;
    }

    public function setnombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function isConcepto(): ?bool
    {
        return $this->concepto;
    }

    public function setConcepto(bool $concepto): self
    {
        $this->concepto = $concepto;

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

    public function getPorcentaje(): ?int
    {
        return $this->porcentaje;
    }

    public function setPorcentaje(?int $porcentaje): self
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    public function __toString()
    {
        return $this->periodo . ' / ' . $this->nombre . ' / ' . $this->porcentaje . (!$this->isConcepto() ? '%' : '');
    }

    public function getPeriodo(): ?Periodo
    {
        return $this->periodo;
    }

    public function setPeriodo(?Periodo $periodo): self
    {
        $this->periodo = $periodo;

        return $this;
    }
}
