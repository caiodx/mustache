<?php

namespace App\Controllers;

use App\Models\EmailParametro;
//use Illuminate\Database\Capsule\Manager as DB;

class ParamEmailController extends Controller
{
	
	public function listarTodos($request, $response){
		/*
		$users = DB::table('convites')
					->select('nome', 'email')
					->where('email','like','%mateus%')
					->get();
		*/
		
		


		$parametro = EmailParametro::where("ID", 1)->get();
		return $response->withHeader('Content-type', 'application/json')->withJSON($parametro);
	}

	public function postSalvar($request, $response)
	{	
		$txtSMTP = $request->getParam('txtSMTP');
		$txtPORTA = $request->getParam('txtPORTA');
		$txtEMAIL = $request->getParam('txtEMAIL');
		$txtSENHA = $request->getParam('txtSENHA');
		$cboTIPOSEGURANCA = $request->getParam('cboTIPOSEGURANCA');
		$txtNOMEEXIBICAO = $request->getParam('txtNOMEEXIBICAO');
		$txtEMAILEXIBICAO = $request->getParam('txtEMAILEXIBICAO');
		$chkREQUER_AUTENTICACAO = $request->getParam('chkREQUER_AUTENTICACAO');
		$chkENVIAHTML = $request->getParam('chkENVIAHTML');
		
		if (rtrim(ltrim($txtSMTP)) == "") {
			$retorno = "Informe o servidor SMTP!";
		}else if (rtrim(ltrim($txtPORTA)) == "") {
			$retorno = "Informe a porta!";
		}else if (rtrim(ltrim($txtEMAIL)) == "") {
			$retorno = "Informe o e-mail de autenticação!";
		}else if (rtrim(ltrim($txtSENHA)) == "") {
			$retorno = "Informe a senha!";
		}else if (rtrim(ltrim($cboTIPOSEGURANCA)) == "") {
			$retorno = "Informe o tipo de segurança!";
		}else if (rtrim(ltrim($txtNOMEEXIBICAO)) == "") {
			$retorno = "Informe o nome de exibição!";
		}else if (rtrim(ltrim($txtEMAILEXIBICAO)) == "") {
			$retorno = "Informe o e-mail de exibição!";
		}

		
		if($chkREQUER_AUTENTICACAO == ""){
			$chkREQUER_AUTENTICACAO = false;
		}else{
			$chkREQUER_AUTENTICACAO = true;
		}
		
		if($chkENVIAHTML == ""){
			$chkENVIAHTML = false;
		}else{
			$chkENVIAHTML = true;
		}
		
		
		$parametro = EmailParametro::where("ID", 1)->get()->first();
		if ($parametro){
			$parametro->SMTP = $txtSMTP;
			$parametro->PORTA = $txtPORTA;
			$parametro->EMAIL = $txtEMAIL;
			$parametro->SENHA = $txtSENHA;
			$parametro->TIPOSEGURANCA = $cboTIPOSEGURANCA;
			$parametro->NOMEEXIBICAO = $txtNOMEEXIBICAO;
			$parametro->EMAILEXIBICAO = $txtEMAILEXIBICAO;
			$parametro->REQUER_AUTENTICACAO = $chkREQUER_AUTENTICACAO;
			$parametro->ENVIAHTML = $chkENVIAHTML;
			$parametro->save();
		}else{
			$parametro = EmailParametro::create([
				'ID' => 1,	
				'SMTP' => $txtSMTP,
				'PORTA' => $txtPORTA,
				'EMAIL' => $txtEMAIL,
				'SENHA' => $txtSENHA,
				'TIPOSEGURANCA' => $cboTIPOSEGURANCA,
				'NOMEEXIBICAO' => $txtNOMEEXIBICAO,
				'EMAILEXIBICAO' => $txtEMAILEXIBICAO,
				'REQUER_AUTENTICACAO' => $chkREQUER_AUTENTICACAO,
				'ENVIAHTML' => $chkENVIAHTML
			]);	
		}

		

		if ($parametro){
			$retorno = "Ok";
		}else{
			$retorno = "Erro ao salvar no banco de dados. Tente novamente!";
		}	
		return $response->withHeader('Content-type', 'application/json')->withJSON(array("retorno"=>$retorno));		
	}


}