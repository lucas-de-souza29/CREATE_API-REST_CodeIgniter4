<?php 

namespace App\Controllers;

//Cria uma API
use CodeIgniter\RESTful\ResourceController;

class Produtos extends ResourceController{

	private $produtoModel;
    //Como se fosse a chave 
    private $token = "123456789abcdefghi";


	public function __construct(){

		$this->produtoModel = new \App\Models\ProdutosModel();
	}

    private function _validaToken(){
    	
    	//Verificar se tem permissão para adicionar o produto ou não

    	return $this->request->getHeaderLine('token')== $this->token;
    }

	//Serviço para retornar todos os produtos (GET)
	public function list(){

		$data = $this->produtoModel->findAll();

	    return $this->response->setJSON($data);
	}

	//Serviço para inserir um novo produto (POST)
    public function create(){

    	$response = [];

    	//Validar o token
    	if($this->_validaToken() == true){
    		//Buscam os dados que vieram no body da requisição

    		$newProduto['nome'] = $this->request->getPost('nome');
    		$newProduto['valor'] = $this->request->getPost('valor');
    		
    		try {
    		     if($this->produtoModel->insert($newProduto)){
    		     	//Deu certo!
    		     	$response = [
    		     		'response' => 'success',
    		     		'msg'      => 'Produto adicionado com sucesso',
    		     	];

    		     }else{
    		     	//Em caso de falha
    		     	$response = [
 						'response'  => 'error',
 						'msg'       => 'Erro ao adicionar o produto',
 						'errors'    => $this->produtoModel->errors()
    		     	];
    		     }	  
    		} catch (Exception $e) {

  					$response = [
  						'response' => 'error',
  						'msg'      => 'Erro ao adicionar o produto',
  						'errors'   => [
  							'exception' => $e->getMessage()
  						]
  					];
    		}
    	}else{

    		$response = [
    			'response' => 'error',
    			'msg' 	   => 'Token inválido',
    		];
    	}

    	return $this->response->setJSON($response);
    }
}