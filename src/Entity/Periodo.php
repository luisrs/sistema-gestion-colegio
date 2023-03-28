<?php

namespace App\Entity;

use App\Repository\PeriodoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeriodoRepository::class)]
class Periodo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'periodo', targetEntity: Nota::class)]
    private Collection $notas;

    #[ORM\OneToMany(mappedBy: 'periodo', targetEntity: NotaAlumno::class)]
    private Collection $notasAlumnos;

    public function __construct()
    {
        $this->notas = new ArrayCollection();
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
     * @return Collection<int, Nota>
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(Nota $nota): self
    {
        if (!$this->notas->contains($nota)) {
            $this->notas->add($nota);
            $nota->setPeriodo($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getPeriodo() === $this) {
                $nota->setPeriodo(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
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
            $notasAlumno->setPeriodo($this);
        }

        return $this;
    }

    public function removeNotasAlumno(NotaAlumno $notasAlumno): self
    {
        if ($this->notasAlumnos->removeElement($notasAlumno)) {
            // set the owning side to null (unless already changed)
            if ($notasAlumno->getPeriodo() === $this) {
                $notasAlumno->setPeriodo(null);
            }
        }

        return $this;
    }
}
