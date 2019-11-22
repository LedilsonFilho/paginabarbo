<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FluxoRepository")
 */
class Fluxo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var datetime
     */
    private $data;

    /**
     * @var boolean
     */
    private $credito;

    /**
     * @var boolean
     */
    private $debito;

    /**
     * @var boolean
     */
    private $saldo;

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

    public function getCredito(): ?bool
    {
        return $this->credito;
    }

    public function setCredito(bool $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getDebito(): ?bool
    {
        return $this->debito;
    }

    public function setDebito(bool $debito): self
    {
        $this->debito = $debito;

        return $this;
    }

    public function getSaldo(): ?bool
    {
        return $this->saldo;
    }

    public function setSaldo(bool $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }
}
