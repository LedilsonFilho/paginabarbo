<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\IpRedRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\IpRed;
use Symfony\Component\HttpFoundation\Response;
use \Datetime;
use \DateTimeZone;

class IpredirectController extends AbstractController
{
 
    public function __construct(            
        IpRedRepository $ipredrepository,
        EntityManagerInterface $entityManager                
    ) {             
        $this->ipredrepository = $ipredrepository;  
        $this->entityManager = $entityManager;      
    }

    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function criarEntidade($codigo)
    {         
        $ipaddress = $this->get_client_ip();
        $today = new DateTime();        
        $today->setTimezone(new DateTimeZone('Brazil/East')); 
        //$data = \DateTime::createFromFormat('Y-m-d H:i:s', $today);  
        $ipred = new IpRed();
        $ipred
            ->setCodigo($codigo)
            ->setIp($ipaddress)
            ->setData($today);

        return $ipred;
    }

    function atualizaEntidadeExistente($codigo, $entidade)
    {
        /** @var IpRed $entidadeExistente */
        $entidadeExistente = $this->ipredrepository->findOneBy(array('codigo' => $codigo));       
        if (is_null($entidadeExistente)) {
            $entidadeNova = new IpRed();
            $entidadeNova
            ->setCodigo($entidade->getCodigo())
            ->setIp($entidade->getIp())
            ->setData($entidade->getData());
            $this->entityManager->persist($entidadeNova);                     
        }else{
            $entidadeExistente
            ->setCodigo($entidade->getCodigo())
            ->setIp($entidade->getIp())
            ->setData($entidade->getData());

            return $entidadeExistente;
        }      
    }

    public function index(Request $request)
    {
        $codigo = $request->query->get('codigo');
        $tipo = $request->query->get('tipo');  

        if($tipo == "add"){ 
            $entidade = $this->criarEntidade($codigo); 
            $entidadeExistente = $this->atualizaEntidadeExistente($codigo, $entidade);
            $this->entityManager->flush(); 
            return new Response(
                '<html><body>Novo IP Setado<br>
                Código: '.$entidade->getCodigo().'<br>
                Ip: '.$entidade->getIp().'<br>
                Data: '.$entidade->getData()->format('d/m/Y H:i:s').'</body></html>'
            );
        }else{
            /** @var IpRed $entidadeExistente */
            $entidadeExistente = $this->ipredrepository->findOneBy(array('codigo' => $codigo));       
            if (is_null($entidadeExistente)) {
                return new Response(
                    '<html><body>Código: '.$codigo.'<br>
                    CÓDIGO NÃO ENCONTRADO'
                );
                                   
            }else{
                return new Response(
                    '<html><body>Código: '.$entidadeExistente->getCodigo().'<br>
                    Ip: '.$entidadeExistente->getIp().'<br>
                    Data: '.$entidadeExistente->getData()->format('d/m/Y H:i:s').'</body></html>'
                );
            }     
                
        }

        

    }
}
