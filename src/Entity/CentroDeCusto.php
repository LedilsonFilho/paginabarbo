<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CentroDeCustoRepository")
 */
class CentroDeCusto implements \JsonSerializable 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lancamento", mappedBy="iccentrodecusto")
     */
    private $lancamentos;

    public function __construct()
    {
        $this->lancamentos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

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
    public function getLancamentos(): Collection
    {
        return $this->lancamentos;
    }

    public function addLancamento(Lancamento $lancamento): self
    {
        if (!$this->lancamentos->contains($lancamento)) {
            $this->lancamentos[] = $lancamento;
            $lancamento->setIccentrodecusto($this);
        }

        return $this;
    }

    public function removeLancamento(Lancamento $lancamento): self
    {
        if ($this->lancamentos->contains($lancamento)) {
            $this->lancamentos->removeElement($lancamento);
            // set the owning side to null (unless already changed)
            if ($lancamento->getIccentrodecusto() === $this) {
                $lancamento->setIccentrodecusto(null);
            }
        }

        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'Id' => $this->getId(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
        ];
    }
}
