<?php

namespace App\Entity;

use App\Repository\AsignaturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AsignaturaRepository::class)]
class Asignatura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\OneToMany(mappedBy: 'asignatura', targetEntity: CursoAsignatura::class, cascade : ['persist'])]
    private Collection $cursoAsignaturas;

    public function __construct()
    {
        $this->cursoAsignaturas = new ArrayCollection();
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

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

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
            $cursoAsignatura->setAsignatura($this);
        }

        return $this;
    }

    public function removeCursoAsignatura(CursoAsignatura $cursoAsignatura): self
    {
        if ($this->cursoAsignaturas->removeElement($cursoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($cursoAsignatura->getAsignatura() === $this) {
                $cursoAsignatura->setAsignatura(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nombre;
    }
}
