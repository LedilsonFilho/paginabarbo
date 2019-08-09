<?php


namespace App\Helper;


use App\Entity\Servico;
use Symfony\Component\HttpFoundation\Request;



class ServicoFactory implements EntidadeFactoryInterface
{
        
    public function criarEntidade($request)
    {                   
        if (gettype($request) == 'string'){   
            $teste = json_decode($request);          
            $entidade = array(
                'data' => $teste->{'data'},
                'projeto' => $teste->{'projeto'},
                'descricao' => $teste->{'descricao'},
                'foto' => $teste->{'foto'},                
            );
            $json =  json_encode($entidade); 

        }elseif (gettype($request) == 'object'){               
            
            $entidade = array(
                'data' => $request->request->get('data'),
                'projeto' => $request->request->get('projeto'),
                'descricao' => $request->request->get('descricao'),                 
                'cliente' => $request->request->get('cliente'), 
                'local' => $request->request->get('local'),  
                'categoria' => $request->request->get('categoria'),           
            );
            $json =  json_encode($entidade);        
            
        }elseif(gettype($request) == 'array'){
            $json =  json_encode($request);
        }
    
        $dadosEmJson = json_decode($json);
        
        $base64 = "1";
        if (substr($request->request->get('foto'), 0, 10) == "data:image" ){
            $base64 = $request->request->get('foto');
        }else{
            
            if (isset($_FILES['foto']['tmp_name'])){
                $path = $_FILES['foto']['tmp_name'];
                $img = file_get_contents($path);               
                $data = base64_encode($img); 

                $foto = base64_decode($data);         
            
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        } 
        
        $data = \DateTime::createFromFormat('Y-m-d', $dadosEmJson->data);
       
        $servico = new Servico();
        $servico
            ->setData($data)
            ->setProjeto($dadosEmJson->projeto)
            ->setDescricao($dadosEmJson->descricao)            
            ->setFoto($base64)
            ->setCliente($dadosEmJson->cliente)
            ->setLocal($dadosEmJson->local)
            ->setCategoria($dadosEmJson->categoria);

       return $servico;
    }
}