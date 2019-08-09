<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServicoRepository")
 */
class Servico implements \JsonSerializable 
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
    private $projeto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(type="date")
     */
    private $data;

    /**
     * @ORM\Column(type="text")
     */
    private $foto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $local;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categoria;
    
    
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function getProjeto(): ?string
    {
        return $this->projeto;
    }

    public function setProjeto(string $projeto): self
    {
        $this->projeto = $projeto;

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

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): self
    {
        $this->data = $data;

        return $this;
    }
    

    public function jsonSerialize()
    {
        return [
            'Id' => $this->getId(),
            'data' => $this->getData(),
            'projeto' => $this->getProjeto(),
            'descricao' => $this->getDescricao(),
            'imagem' => $this->getFoto(),
        ];
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getCliente(): ?string
    {
        return $this->cliente;
    }

    public function setCliente(string $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getLocal(): ?string
    {
        return $this->local;
    }

    public function setLocal(string $local): self
    {
        $this->local = $local;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    
    
}
