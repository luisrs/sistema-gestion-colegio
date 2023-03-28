<?php

namespace App\Entity;

use App\Repository\CursoAsignaturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoAsignaturaRepository::class)]
class CursoAsignatura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cursoAsignaturas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Curso $curso = null;

    #[ORM\ManyToOne(inversedBy: 'cursoAsignaturas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Asignatura $asignatura = null;

    #[ORM\OneToMany(mappedBy: 'cursoAsignatura', targetEntity: Alumno::class)]
    private Collection $alumnos;

    #[ORM\OneToMany(mappedBy: 'asignatura', targetEntity: Nota::class, cascade : ['persist'])]
    private Collection $notas;

    #[ORM\ManyToOne(inversedBy: 'cursoAsignaturas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profesor $profesor = null;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAsignatura(): ?Asignatura
    {
        return $this->asignatura;
    }

    public function setAsignatura(?Asignatura $asignatura): self
    {
        $this->asignatura = $asignatura;

        return $this;
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
            $alumno->setCursoAsignatura($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getCursoAsignatura() === $this) {
                $alumno->setCursoAsignatura(null);
            }
        }

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
            $nota->setAsignatura($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getAsignatura() === $this) {
                $nota->setAsignatura(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->curso . ' - ' . $this->asignatura;
    }

    public function getProfesor(): ?Profesor
    {
        return $this->profesor;
    }

    public function setProfesor(?Profesor $profesor): self
    {
        $this->profesor = $profesor;

        return $this;
    }

    public function toArray(){

        $notas = [];
        foreach ($this->getNotas()->toArray() as $key => $nota) {
            if($nota && $nota->getPeriodo()->getNombre() == 'Primer Semestre'){
                $notas[] =  [
                    'id' => $nota->getId(),
                    'nombre' => $nota->getNombre(),
                    'calificacion' => $nota->getCalificacion(),
                    'porcentaje' => $nota->getPorcentaje(),
                    'periodo' => 'Primer Semestre'
                ];
            }
        }

        return  [
            'curso' => $this->getCurso()->toArray(),
            'asignatura' => $this->getAsignatura()->toArray(),
            'alumnos' => array_map(function($alumno){
                return [
                    'id' => $alumno->getId(),
                    'nombre' => $alumno->getNombre()
                ];
                }, $this->getCurso()->getAlumnos()->toArray()
            ),
            'notas' => $notas
        ];

    }
    
}
