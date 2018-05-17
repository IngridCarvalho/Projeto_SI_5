<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller{
    
    public function validar_sessao(){
        if(!$this->session->userdata('LOGADO')){
            redirect('usu/acesso');
        }
        return true;
    }

    public function index($alert=null){
        $this->validar_sessao();
        $this->load->model('bd/usuariosmodel');

        $dados['usuarios'] = $this->usuariosmodel->get_usuario();
        if($alert != null)
            $dados['alert'] = $this->msg($alert);

            $this->load->view('usu/includes/topo');
            $this->load->view('usu/includes/menu');
            $this->load->view('usu/usuarios/usuariosview',$dados);
            $this->load->view('usu/includes/rodape');
    }

    public function cadastro(){
        $this->validar_sessao();
        $this->load->model('bd/usuariosmodel','usuarios');
        $dados['nivelusuarios']=$this->usuarios->get_nivel();

        $this->load->view('usu/includes/topo');
        $this->load->view('usu/includes/menu');
        $this->load->view('usu/usuarios/novousuarioview',$dados);
        $this->load->view('usu/includes/rodape');
    }

    public function editar($nome){
        $this->validar_sessao();
        $this->load->model('bd/usuariosmodel','usuarios');
        $dados['usuarios'] = $this->usuarios->get_usuarios($nome);
        $dados['nivelusuarios']=$this->usuarios->get_nivel();

        $this->load->view('usu/includes/topo');
        $this->load->view('usu/includes/menu');
        $this->load->view('usu/usuarios/editarusuarioview',$dados);
        $this->load->view('usu/includes/rodape');
    }

    public function salvar(){
        $this->validar_sessao();
        $this->load->model('bd/bancomodel');
        $info['cpf'] = $this->input->post('cpf');
        $info['nome'] = $this->input->post('nome');
        $info['sobrenome'] = $this->input->post('sobrenome');
        $info['senha'] = md5($this->input->post('senha'));
        $info['fk_nivel'] = $this->input->post('nivel');

        $result = $this->bancomodel->insert('usuarios',$info);
        if($result){
            redirect('usu/usuarios/1');
        }else{
            redirect('usu/usuarios/2');
        }
        
    }

    public function atualizar(){
        $this->validar_sessao();
        $this->load->model('bd/bancomodel');
        $info['cpf'] = $this->input->post('cpf');
        $info['nome'] = $this->input->post('nome');
        $info['sobrenome'] = $this->input->post('sobrenome');
        $info['senha'] = md5($this->input->post('senha'));
        $info['fk_nivel'] = $this->input->post('nivel');

        $id = $this->input->post('id');

        $result = $this->bancomodel->update('usuarios',$info,$id);
        if($result){
            redirect('usu/usuarios/5');
        }else{
            redirect('usu/usuarios/6');
        }
        
    }

    public function deletar($id){
        $this->validar_sessao();
        $this->load->model('bd/bancomodel');

        $result = $this->bancomodel->delete('usuarios',$id);
        if($result){
            redirect('usu/usuarios/3');
        }else{
            redirect('usu/usuarios/4');
        }
    }

    public function msg($alert) {
		$str = '';
		if ($alert == 1)
                    $str = 'success- Usuário cadastrado com sucesso!';
		else if ($alert == 2)
                    $str = 'danger-Não foi possível cadastrar o usuário. Por favor, tente novamente!';
		else if ($alert == 3)
                    $str = 'success- Usuário removido com sucesso!';
		else if ($alert == 4)
                    $str = 'danger-Não foi possível remover a usuário. Por favor, tente novamente!';
		else if ($alert == 5)
                    $str = 'success- Usuário atualizado com sucesso!';
		else if ($alert == 6)
                    $str = 'danger-Não foi possível atualizar o usuário. Por favor, tente novamente!';
		else
                    $str = null;
		return $str;
	}
}