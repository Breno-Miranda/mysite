<?php 

class MY_Controller extends CI_Controller {

    private $conf = array(
        'prefixo_tb' => 'tb_'
    );
   
    public function __construct() {
      parent::__construct();
      date_default_timezone_set('America/Sao_Paulo');
      ini_set('date.timezone', 'America/Sao_Paulo');
      # LOAD BIBLIOTECAS 
      $this->load->library('library/Decodificar');
      $this->load->library('encrypt');
      # LOAD MODEL 
      $this->load->model('MY_Model');
  	}


      public function layout( Array $config){

        // echo '<pre>';
		// 	print_r($config);

  	    $this->pagination($config);
    
        $data['titulo']  = $this->config->item('titulo').' | '.$config['c_class'];
        $data['logo']    = $this->config->item('logo');

		$data['pagina'] = PaginaView(
			$config['c_class'], 
			$config['c_metodo'], 
			$config['c_diretorio_pagina'], 
            $config['c_layout']
        );

		$this->load->view($config['c_diretorio'], array_merge(
            $data, 
            $config,
            array('c_usuario' => $this->session->userdata('usuario'))
		));

  	}


  	public function pagination($config){


  		$config_pagination = array(
            "base_url" => '',
            "per_page" =>  $config['c_limit'],
            "num_links" => $config['c_limit'],
            "uri_segment" => 25,
            'page_query_string' => true,
            "total_rows" => $this->Modulos_Model->count_query(tabelasBD($config['c_class_pagination']['c_tabela'])),
            "full_tag_open" => "<div class='pagination'>",
            "full_tag_close" => "</div>",
            "first_link" => FALSE,
            "last_link" => FALSE,
            "first_tag_open" => "<a>",
            "first_tag_close" => "</a>",
            "prev_link" => "Anterior",
            "prev_tag_open" => "<a class='prev'>",
            "prev_tag_close" => "</a>",
            "next_link" => "Próxima",
            "next_tag_open" => "<a class='next'>",
            "next_tag_close" => "</a>",
            "last_tag_open" => "<a>",
            "last_tag_close" => "</a>",
            "cur_tag_open" => "<a class='active'>",
            "cur_tag_close" => "</a>",
            "num_tag_open" => "<a>",
            "num_tag_close" => "</a>"
        );


        $this->pagination->initialize($config_pagination);
    
  	}


    public function email()
    {
        
    }

    public function upload($nomeImagem = null)
    {
            $config['upload_path']          = 'uploads/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['encrypt_name']         = true;

            $this->upload->initialize($config);

            if ($this->upload->do_upload($nomeImagem)):

            $upload_data = $this->upload->data(); 

            return  array_merge($upload_data , $config);

            else:
                return false;
            endif;
    }

    public function permissao( $dados )
    {
        if( $dados )
        {   
            $result = $this->MY_Model->get_permissoes( $dados );

            $metodo = strval($dados['metodo']);

            switch($metodo)
            {
                case 'index':
                    if( (int) !$result->view):  $this->session->set_flashdata('msm', 'Você não tem PERMISSÃO ao modulo - '.$dados['modulo']); redirect(base_url('painel'));  endif;
                break;

                case 'salvar':
                    if( (int) !$result->$metodo):  $this->session->set_flashdata('msm', 'Você não tem PERMISSÃO ao modulo - '.$dados['modulo']); redirect(base_url('painel'));  endif;
                break;

                case 'editar':
                    if( (int) !$result->$metodo):  $this->session->set_flashdata('msm', 'Você não tem PERMISSÃO ao modulo - '.$dados['modulo']); redirect(base_url('painel'));  endif;
                break;

                case 'deletar':
                    if( (int) !$result->$metodo):  $this->session->set_flashdata('msm', 'Você não tem PERMISSÃO ao modulo - '.$dados['modulo']); redirect(base_url('painel'));  endif;
                break;

                default:
                    redirect(base_url('painel'));
                break;
            }
        } else {
            return false;
        }
    }
}