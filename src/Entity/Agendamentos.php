<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgendamentosRepository")
 */
class Agendamentos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lancamento", mappedBy="agendamentos")
     */
    private $itens;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tipo;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    public function __construct()
    {
        $this->itens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * @return Collection|Lancamento[]
     */
    public function getItens(): Collection
    {
        return $this->itens;
    }

    public function addIten(Lancamento $iten): self
    {
        if (!$this->itens->contains($iten)) {
            $this->itens[] = $iten;
            $iten->setAgendamentos($this);
        }

        return $this;
    }

    public function removeIten(Lancamento $iten): self
    {
        if ($this->itens->contains($iten)) {
            $this->itens->removeElement($iten);
            // set the owning side to null (unless already changed)
            if ($iten->getAgendamentos() === $this) {
                $iten->setAgendamentos(null);
            }
        }

        return $this;
    }

    public function getTipo(): ?bool
    {
        return $this->tipo;
    }

    public function setTipo(bool $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
