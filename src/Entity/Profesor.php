<?php

namespace App\Entity;
use App\Repository\ProfesorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesorRepository::class)]
class Profesor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $correo = '';

    #[ORM\Column]
    private ?bool $profesorJefe = false;

    #[ORM\Column]
    private ?bool $profesorAsignatura = false;

    #[ORM\Column]
    private ?bool $director = false;

    #[ORM\OneToMany(mappedBy: 'profesor', targetEntity: CursoAsignatura::class)]
    private Collection $cursoAsignaturas;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellidos = null;

    #[ORM\Column(length: 255)]
    private ?string $telefono = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column(length: 255)]
    private ?string $rut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaActualizacion = null;

    public function __construct()
    {
        $this->cursoAsignaturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function isProfesorJefe(): ?bool
    {
        return $this->profesorJefe;
    }

    public function setProfesorJefe(bool $profesorJefe): self
    {
        $this->profesorJefe = $profesorJefe;

        return $this;
    }

    public function isProfesorAsignatura(): ?bool
    {
        return $this->profesorAsignatura;
    }

    public function setProfesorAsignatura(bool $profesorAsignatura): self
    {
        $this->profesorAsignatura = $profesorAsignatura;

        return $this;
    }

    public function isDirector(): ?bool
    {
        return $this->director;
    }

    public function setDirector(bool $director): self
    {
        $this->director = $director;

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
            $cursoAsignatura->setProfesor($this);
        }

        return $this;
    }

    public function removeCursoAsignatura(CursoAsignatura $cursoAsignatura): self
    {
        if ($this->cursoAsignaturas->removeElement($cursoAsignatura)) {
            // set the owning side to null (unless already changed)
            if ($cursoAsignatura->getProfesor() === $this) {
                $cursoAsignatura->setProfesor(null);
            }
        }

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): self
    {
        $this->fechaNacimiento = $fechaNacimiento;

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

}
