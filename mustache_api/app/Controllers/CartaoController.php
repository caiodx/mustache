<?php

namespace App\Controllers;

use Illuminate\Database\Capsule\Manager as DB;

class CartaoController extends Controller    	
{
	public function CriarCliente($request, $response)
	{   
		$clienteid = "";
		$pagamento_id = "";

		$token = $request->getParam("token");
		$auth = "Basic " . base64_encode('89ace6b00636f6d3e4e92d5806c6b85a') . ":";
		// $token = $request->getParam('token');

		//cadastra cliente
		$data = array('email' => 'jose@gmail.com', 'name' => 'Jose');
		$resposta = \Requests::post('https://api.iugu.com/v1/customers', array('Authorization' => $auth), $data);
			
		$retorno = json_decode($resposta->body);

		$clienteid = $retorno->id;

		///insere na tabela de cliente
		//aqui

		//cadastra forma de pagamento
		$data = array('description' => 'Cartão de Crédito', 'token' => $token, 'set_as_default' => true);
		$resposta = \Requests::post('https://api.iugu.com/v1/customers/' . $clienteid  . '/payment_methods', array('Authorization' => $auth), $data);

		$retorno = json_decode($resposta->body);

		$pagamento_id = $retorno->id;

		//cria a assinatura		
		$data = array('customer_id' => $clienteid, 'only_on_charge_success' => true, 'credits_based' => true, 'price_cents' => 1.00 * 100, 'credits_cycle' => 100 * 100, 'credits_min' => 10 * 100);
		$resposta = \Requests::post('https://api.iugu.com/v1/subscriptions', array('Authorization' => $auth), $data);
				
		$retorno = json_decode($resposta->body);

		if (isset($retorno->errors)){
			//nao conseguiu fazer a cobrança do cartão
			//ira excluir o cliente			
			$resposta = \Requests::delete('https://api.iugu.com/v1/customers/' . $clienteid, array('Authorization' => $auth), array());
			$retorno = json_decode($resposta->body);
			$retorno = Array("tipo" => 1, "retorno" => $retorno);

		}else{

			$retorno = array("aqui" => 'asdasd');
			$retorno = Array("tipo" => 2, "retorno" => $retorno);

		}

		return $response->withHeader('Content-type', 'application/json')->withJSON($retorno);			
	}
	
}