<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LancamentoRepository")
 */
class Lancamento implements \JsonSerializable 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descricao;     

    /**
     * @ORM\Column(type="boolean")
     */
    private $previsao;

    /**
     * @ORM\Column(type="float")
     */
    private $valor;    

    /**
     * @ORM\Column(type="date")
     */
    private $dataedicao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContaCorrente", inversedBy="lancamentos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idconta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CentroDeCusto", inversedBy="lancamentos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $iccentrodecusto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="lancamentos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $debito;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $notafiscal;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datapag;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $valorpago;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agendamentos", inversedBy="itens")
     */
    private $agendamentos;

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

    public function getPrevisao(): ?bool
    {
        return $this->previsao;
    }

    public function setPrevisao(bool $previsao): self
    {
        $this->previsao = $previsao;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getDataedicao(): ?\DateTimeInterface
    {
        return $this->dataedicao;
    }

    public function setDataedicao(\DateTimeInterface $dataedicao): self
    {
        $this->dataedicao = $dataedicao;

        return $this;
    }

    public function getIdconta(): ?ContaCorrente
    {
        return $this->idconta;
    }

    public function setIdconta(?ContaCorrente $idconta): self
    {
        $this->idconta = $idconta;

        return $this;
    }

    public function getIccentrodecusto(): ?CentroDeCusto
    {
        return $this->iccentrodecusto;
    }

    public function setIccentrodecusto(?CentroDeCusto $iccentrodecusto): self
    {
        $this->iccentrodecusto = $iccentrodecusto;

        return $this;
    }

    public function getUserid(): ?User
    {
        return $this->userid;
    }

    public function setUserid(?User $userid): self
    {
        $this->userid = $userid;

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

    public function jsonSerialize()
    {
        return [
            'Id' => $this->getId(),
            'data' => $this->getData(),
            'descricao' => $this->getDescricao(),
            'previsao' => $this->getPrevisao(),
            'valor' => $this->getValor(),
            'dataedicao' => $this->getDataedicao(),
            'idconta' => $this->getIdconta()->getId(),
            'idcentrodecusto' => $this->getIccentrodecusto()->getId(),
            'userid_id' => $this->getUserid()->getId(),
            'debito' =>$this->getDebito(),   
            'notafiscal' => $this->getNotafiscal(),
            'datapag' => $this->getDatapag(),
            'valorpago' => $this->getValorpago(),       
           
        ];
    }

    public function getNotafiscal(): ?string
    {
        return $this->notafiscal;
    }

    public function setNotafiscal(?string $notafiscal): self
    {
        $this->notafiscal = $notafiscal;

        return $this;
    }

    public function getDatapag(): ?\DateTimeInterface
    {
        return $this->datapag;
    }

    public function setDatapag(?\DateTimeInterface $datapag): self
    {
        $this->datapag = $datapag;

        return $this;
    }

    public function getValorpago(): ?float
    {
        return $this->valorpago;
    }

    public function setValorpago(?float $valorpago): self
    {
        $this->valorpago = $valorpago;

        return $this;
    }

    public function getAgendamentos(): ?Agendamentos
    {
        return $this->agendamentos;
    }

    public function setAgendamentos(?Agendamentos $agendamentos): self
    {
        $this->agendamentos = $agendamentos;

        return $this;
    }
}
