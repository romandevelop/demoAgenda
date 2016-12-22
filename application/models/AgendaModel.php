<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class AgendaModel extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    function insertarContacto($nombre, $apellido, $mail,$telefono){
        $datos = array("nombre"=>$nombre,
                        "apellido"=>$apellido,
                        "mail"=>$mail,
                    "telefono"=>$telefono);
        return $this->db->insert("contacto",$datos);        
    }
    
    function getContactos(){
        return $this->db->get("contacto")->result();
    }
    
    function eliminarContacto($id){
        $this->db->where("id",$id);
        $this->db->delete("contacto");
    }
    
    function actualizarContacto($id, $nombre, $apellido, $mail,$telefono){
        $this->db->where("id",$id);
        $datos = array("nombre"=>$nombre,
                        "apellido"=>$apellido,
                        "mail"=>$mail,
                    "telefono"=>$telefono);
        $this->db->update("contacto",$datos);
        
    }
    
    
    
    
}
