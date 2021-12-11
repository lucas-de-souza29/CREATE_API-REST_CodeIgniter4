<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model{
    //Nome da tabela é produtos
	protected $table = 'produtos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome','valor'];
    protected $validationRules = [
 		//isUnique não permite dois produtos com o mesmo nome
 		'nome' => 'required|min_length[3]|is_unique[produtos.nome]',
    ];
}


?>