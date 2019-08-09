<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContaCorrenteRepository")
 */
class ContaCorrente implements \JsonSerializable 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $ag;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $cc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gerente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lancamento", mappedBy="idconta")
     */
    private $lancamentos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $endereco;

    public function __construct()
    {
        $this->lancamentos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAg(): ?string
    {
        return $this->ag;
    }

    public function setAg(string $ag): self
    {
        $this->ag = $ag;

        return $this;
    }

    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function setCc(string $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getGerente(): ?string
    {
        return $this->gerente;
    }

    public function setGerente(?string $gerente): self
    {
        $this->gerente = $gerente;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
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
            $lancamento->setIdconta($this);
        }

        return $this;
    }

    public function removeLancamento(Lancamento $lancamento): self
    {
        if ($this->lancamentos->contains($lancamento)) {
            $this->lancamentos->removeElement($lancamento);
            // set the owning side to null (unless already changed)
            if ($lancamento->getIdconta() === $this) {
                $lancamento->setIdconta(null);
            }
        }

        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(?string $endereco): self
    {
        $this->endereco = $endereco;

        return $this; 
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'ag' => $this->getAg(),
            'cc' => $this->getCc(),
            'gerente' => $this->getGerente(),
            'descricao' => $this->getDescricao(),
            'nome' => $this->getNome(),
            'endereco' => $this->getEndereco(),
            
        ];
    }
}
