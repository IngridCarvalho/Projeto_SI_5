<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ordensmodel extends CI_Model {

    public function get_ordem() {
        $this->db->order_by('codigo','CRESC');
		$result = $this->db->get('ordemproducao')->result();
        return $result;
    }

    public function get_status() {
		$result = $this->db->get('status_ordem')->result();
		return $result;
	}
        
    public function get_ordens($codigo){
        $this->db->where('codigo',$codigo);
        $result = $this->db->get('ordemproducao')->result();
        return $result;
    }

    public function get_codigo($codigo){
        $this->db->where('codigo',$codigo);
        $result = $this->db->get('ordemproducao')->result();
        return $result;
    }

    public function get_produtos(){
        $this->db->order_by('nome','CRESC');
        $this->db->where('tipo_produto = 1');
        $produto = $this->db->get('produtos')->result();
        return $produto;
    }

    public function get_produtos_incluidos($codigo){
        $this->db->select('produtos.nome');
        $this->db->select('itensordemproducao.codigo');
        $this->db->select('itensordemproducao.codigo_item');
        $this->db->select('itensordemproducao.quantidade_produzida');
        $this->db->select('itensordemproducao.custo_unitario');
        $this->db->order_by('itensordemproducao.codigo_item','CRESC');
        $this->db->join('produtos',' itensordemproducao.codigo_item = produtos.codigo','inner');
        $this->db->where('itensordemproducao.numero_ordem =', $codigo);
        $produtos = $this->db->get('itensordemproducao')->result();
        return $produtos;
    }

    public function custo_uni_composicao($codigo_composicao){
        $this->db->select('sum(composicao.quantidade_componente * produtos.preco_custo) as custo_componente');
        $this->db->join('produtos', 'produtos.codigo = composicao.codigo_produto');
        $this->db->where('composicao.codigo_composicao', $codigo_composicao);
        $result = $this->db->get('composicao')->result_array();

        foreach ($result as $key => $value) {
            $custo_unitario = $value["custo_componente"];
        }

        return $custo_unitario;
    }
 }