<?php

namespace App\Controllers;

use App\Models\Produto;
use Illuminate\Database\Capsule\Manager as DB;


class ProdutoController extends Controller
{
	public function postSalvar($request, $response)
	{	
		$retorno = "";
		
		$descricao = $request->getParam('nome');
		$email = $request->getParam('email');
		$mensagem = $request
		->getParam('mensagem');

		if (rtrim(ltrim($nome)) == "") {
			$retorno = "Informe o nome!";
		}else if (rtrim(ltrim($email)) == "") {
			$retorno = "Informe o e-mail!";
		}

		if ($retorno == ""){
			// Verificar se  e-mail já está cadastrado na base.
			/// senao estiver
			///// verificar se foi enviado algum convite ja
			$checkEmail = Convite::where('EMAIL' , $email)->first();
			if ($checkEmail){
				$retorno = "Já foi enviado um convite para o e-mail " . $email;
			}else{

				// gerar o token
				GerarToken:
				$token =  md5(uniqid(rand(), true));
				

				// verificar se o token exist
				$tokenExiste = Convite::where('TOKEN' , $token)->first();
				
				if ($tokenExiste) //se token existe faz loop até achar um que não existe
				{
					goto GerarToken;
				}else{
					$convite = Convite::create([
						'NOME' => $nome,
						'EMAIL' => $email,
						'MENSAGEM' => $mensagem,
						'TOKEN' => $token
					]);		

					if ($convite){
						$retorno = "Ok";
						//EnviarPorEmail();

					}else{
						$retorno = "Erro ao salvar no banco de dados. Tente novamente!";
					}				
				}
			}
		}
		return $response->withHeader('Content-type', 'application/json')->withJSON(array("retorno" => $retorno));			
	}

	public function listarTodos($request, $response){

		$start = (int) $request->getQueryParam("start");
		$length = (int) $request->getQueryParam("length");
		$draw = (int) $request->getQueryParam("draw");
		$search_value = $request->getQueryParams()["search"]["value"];
		$quant_filtro = 0;
		$quant_prod = 0;

		$produtos = null;

		$quant_prod = DB::table('produtos')
		->join('classes', 'classes.classeid', '=', 'produtos.classeid')	
		->count();


		if ($search_value == ""){
			$produtos = DB::table('produtos')
			->join('classes', 'classes.classeid', '=', 'produtos.classeid')
			->select('id', 'base', 'especificacao', 'classes.descricao as classe' )
			->skip($start)->take(10)
			->get();

			$quant_filtro = $quant_prod;

		}else{
			$produtos = DB::table('produtos')
			->join('classes', 'classes.classeid', '=', 'produtos.classeid')
			->select('id', 'base', 'especificacao', 'classes.descricao as classe' )
			->where("especificacao", 'like', '%' . $search_value . "%")
			->orwhere("classes.descricao", 'like', '%' . $search_value . "%")
			->orwhere("base", 'like', '%' . $search_value . "%")
			->skip($start)->take(10)
			->get();

			$quant_filtro = DB::table('produtos')
			->join('classes', 'classes.classeid', '=', 'produtos.classeid')
			->where("especificacao", 'like', '%' . $search_value . "%")
			->orwhere("classes.descricao", 'like', '%' . $search_value . "%")
			->orwhere("base", 'like', '%' . $search_value . "%")
			->count();

		}		

		$retorno = array("draw" =>$draw,
						 "recordsTotal" => $quant_prod,
						 "recordsFiltered" => $quant_filtro,
						 "data" => $produtos);

		return $response->withHeader('Content-type', 'application/json')->withJSON($retorno);
	}

	public function carregarClasses($request, $response){
		$classes = DB::table('classes')
		->select('classeid', 'descricao')
		->get();
		return $response->withHeader('Content-type', 'application/json')->withJSON($classes);
	}

	public function carregarProduto($request, $response){

		$produtos = DB::table('produtos')
		->select('id', 'classeid', 'especificacao', 'base', 'tipo')
		->where("id", $request->getQueryParam("id"))
		->get();

		$retorno = array("ok"=> count($produtos) > 0, "registros" => $produtos);

		return $response->withHeader('Content-type', 'application/json')->withJSON($retorno);
	}
	
}