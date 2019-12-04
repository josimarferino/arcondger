<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salas extends CI_Controller {
	
	public function __construct(){
			parent::__construct();
			
			//Carrega o Model de setor
			$this->load->model("Sala_model");

			#verifica se o usuário fez o login corretamente
			if (!isset($_SESSION["email"])){
				redirect("login/index/");
			}
	}
	
	
	//página principal
	public function index($id=null) {

		if (isset($_GET['page'])){
			$page = $_GET['page'];
		} else {
			$page = 1;
		}


		
		//busca todos os registros para a listagem
		$listaPaginada = $this->Sala_model->pagination($this->config->item("per_page"), $page, val($_GET,"busca"));

		//se for para abrir algum registro
		$dados = $this->Sala_model->get($id);
		
		
		$this->load->library("captura_dados");
		
		
		foreach($listaPaginada["data"] as $ln){
			$listaPaginada["data"][$ln->id]["captura_dados"] = $this->captura_dados->getDados($ln->ip);			
		}
		
		
		
		$this->load->view('salas', ["listaPaginada"=>$listaPaginada,
										"dados"=>$dados]);
		
	}
	
	public function ligarArCond($ip){
		@$txt = file_get_contents("http://$ip/ligar");
		redirect("Salas/index/" . $obj );

	}
	public function desligarArCond($ip){
		@$txt = file_get_contents("http://$ip/desligar");
		redirect("Salas/index/" . $obj );

	}
	
	public function salvar(){
		$this->form_validation->set_rules('ip', 'IP', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$obj = $this->Sala_model->save();

			#mensagem de confirmação
			if ($obj == ""){
				$this->session->set_flashdata("error","<div class='ui red message'>Falha ao salvar.</div>");
			} else {
				$this->session->set_flashdata("success","<div class='ui green message'>Salvo com sucesso.</div>");
			}

			
			redirect("Salas/index/" . $obj );
		}
	}
	
	
	
	
	public function deletar($id){
		$this->Sala_model->delete($id);

		$this->session->set_flashdata("warning","<div class='ui yellow message'>Registro deletado.</div>");
		
		redirect("Salas/index");
		
	}

}
