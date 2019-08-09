<?php


namespace App\Helper;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory implements EntidadeFactoryInterface
{
    

    public function __construct(        
        UserRepository $userrepository,
        UserPasswordEncoderInterface $encoder)
    {        
        $this->userrepository = $userrepository;
        $this->encoder = $encoder;
    }
    public function criarEntidade($request)
    {

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')){
            $json = $request->getContent();
        }else{
            $entidade = array(
                'username' => $request->request->get('username'),
                'nome'=> $request->request->get('nome'),
                'email'=> $request->request->get('email'),
                'password'=> $request->request->get('password'),
                'tipo'=> $request->request->get('tipo'),
                
            );

            $json =  json_encode($entidade); 
        
        };

        $dadosEmJson = json_decode($json);
        $roles[] = $dadosEmJson->tipo;        
        $usuario = new User();
        $encoded = $this->encoder->encodePassword($usuario, $dadosEmJson->password);
        $usuario
            ->setUsername($dadosEmJson->username)
            ->setNome($dadosEmJson->nome)
            ->setEmail($dadosEmJson->email)            
            ->setPassword($encoded)
            ->setRoles($roles);

        return $usuario;
    }
}