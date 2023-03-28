<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'curso', targetEntity: CursoAsignatura::class)]
    private Collection $cursoAsignaturas;

    #[ORM\OneToMany(mappedBy: 'curso', targetEntity: Alumno::class, orphanRemoval: true)]
    private Collection $alumnos;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable:true)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\OneToMany(mappedBy: 'curso', targetEntity: NotaAlumno::class)]
    private Collection $notasAlumnos;

    public function __construct()
    {
        $this->cursoAsignaturas = new ArrayCollection();
        $this->alumnos = new ArrayCollection();
        $this->notasAlumnos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, CursoAsignatura>
     */
    public function getCursoAsignaturas(): Collection
    {
        return $this->cursoAsignaturas;
    }

    public function addCursoAsignatura(CursoAsignatura $cursoAsignatura): self
    {
        if (!$this->cursoAsignaturas->contains($cursoAsignatura)) {
            $this->cursoAsignaturas->add($cursoAsignatura);
            $cursoAsignatura->setCurso($this);
        }

        return $this;
    }

    public function removeCursoAsignatura(CursoAsignatura $cursoAsignatura): self
    {
        if ($this->cursoAsignaturas->removeElement($cursoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($cursoAsignatura->getCurso() === $this) {
                $cursoAsignatura->setCurso(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * @return Collection<int, Alumno>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setCurso($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getCurso() === $this) {
                $alumno->setCurso(null);
            }
        }

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

    public function toArray(){
        return  [
            'id' => $this->getId(),
            'nombre' => $this->getNombre()
        ];
    }

    /**
     * @return Collection<int, NotaAlumno>
     */
    public function getNotasAlumnos(): Collection
    {
        return $this->notasAlumnos;
    }

    public function addNotasAlumno(NotaAlumno $notasAlumno): self
    {
        if (!$this->notasAlumnos->contains($notasAlumno)) {
            $this->notasAlumnos->add($notasAlumno);
            $notasAlumno->setCurso($this);
        }

        return $this;
    }

    public function removeNotasAlumno(NotaAlumno $notasAlumno): self
    {
        if ($this->notasAlumnos->removeElement($notasAlumno)) {
            // set the owning side to null (unless already changed)
            if ($notasAlumno->getCurso() === $this) {
                $notasAlumno->setCurso(null);
            }
        }

        return $this;
    }
}
