<?php

namespace App\Controllers;
use App\Models\Convite;

use PHPMailer\PHPMailer\Exception;
use Illuminate\Database\Capsule\Manager as DB;

class ConviteController extends Controller
{
	
	public function validarChave($request, $response){

		$retorno = "ok";
		$mensagem = '';
		$token = $request->getAttribute('token');

		$convite = DB::table('convites')
					->select('CONVITEID', 'DATACADASTRO')
					->where('TOKEN', $token)
					->first();

		if(!$convite){
			$mensagem = "Não existe";
			$retorno = "erro";
		}else if($convite->DATACADASTRO <> ""){
			$mensagem = "Já cadastrado";
			$retorno = "erro";
		}
		
		return $response->withHeader('Content-type', 'application/json')
						->withJSON(array('retorno' => $retorno,
										 'mensagem' => $mensagem));
	}

	public function postSalvar($request, $response)
	{	
		$retorno = "";	
		$nome = $request->getParam('nome');
		$email = $request->getParam('email');
		$mensagem = $request->getParam('mensagem');

		$config = DB::table('configglobal')
						->select('nomesite', 'url')
						->first();
		

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
										
						$link = $config->url . "/" . $token;
						$assunto = "Convite de Cadastro para o " . $config->nomesite;
						$mensagem =  "Olá $nome, <br>";
						$mensagem .= "Segue o link de cadastro para o Mustache Members Club <br>";
						$mensagem .= "<a href=".$link.">Link</a>";
						
						try{
							$retEmail = $this->modMain->EnviarEmail($email, $mensagem, $assunto, true);	
						} catch (Exception $e) {
							
						}
						
						
					}else{
						$retorno = "Erro ao salvar no banco de dados. Tente novamente!";
					}				
				}
			}
		}
		return $response->withHeader('Content-type', 'application/json')->withJSON(array("retorno" => $retorno));			
	}

	public function listarTodos($request, $response){
		$convites = Convite::orderBy('CONVITEID', 'DESC')->get();
		return $response->withHeader('Content-type', 'application/json')->withJSON($convites);
	}

	

	
}