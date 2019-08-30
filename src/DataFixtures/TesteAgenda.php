<?php

namespace App\DataFixtures;

use App\Entity\Agendamentos;
use App\Entity\Lancamento;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\LancamentoRepository;
use App\Repository\AgendamentosRepository;

class TesteAgenda extends Fixture
{
    public function __construct(
        LancamentoRepository $lancamentoRepository,
        AgendamentosRepository $agendamentosRepository 
        )
    {
        $this->LancamentoRepository = $lancamentoRepository;
        $this->AgendamentosRepository = $agendamentosRepository;
        
    }



    public function load(ObjectManager $manager)
    {
        $iten = $this->LancamentoRepository->find('1721');
        //$data = \DateTime::createFromFormat('Y-m-d', '2019-08-14');
        // $product = new Product();
        // $manager->persist($product);
        $agenda = $this->AgendamentosRepository->find('4');
        
        
        $agenda->removeIten($iten);

        $manager->persist($agenda);

        $manager->flush(); 
    }
}
