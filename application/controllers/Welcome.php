<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("agendaModel");
    }
    
	public function index()
	{
		$this->load->view('vista/welcome_message');
	}
        public function insertarContacto(){
            $nombre = $this->input->post("nombre");
            $apellido = $this->input->post("apellido");
            $mail = $this->input->post("mail");
            $telefono= $this->input->post("telefono");
            $this->agendaModel->insertarContacto($nombre,$apellido,
                    $mail,$telefono);
            echo json_encode(array("msg"=>"ok"));
        }
        public function getContactos(){
            echo json_encode($this->agendaModel->getContactos());
        }
        
        public function eliminarContacto(){
            $id = $this->input->post("id");
            $this->agendaModel->eliminarContacto($id);
            echo json_encode(array("msg"=>"eliminado!"));
        }
        
        public function actualizarContacto(){
            $id = $this->input->post("id");
            $nombre = $this->input->post("nombre");
            $apellido = $this->input->post("apellido");
            $mail = $this->input->post("mail");
            $telefono= $this->input->post("telefono");
            $this->agendaModel->actualizarContacto($id,
                    $nombre,$apellido,$mail,$telefono);
            echo json_encode(array("msg"=>"actualizado!"));
        }
        
        
        
}
