<?php 
	
class Login extends MY_Controller{
		
	function construct()
	{
		parrent::Controller();
	}

	public function index()
	{	
		$this->layout(array(
            'c_diretorio' => 'layout/site/index',
            'c_class' => get_class(),
            'c_metodo' => get_class_methods(get_class())[1],
            'c_diretorio_pagina' => 'site/pagina/'.get_class(),
            'c_layout' => 'site',
            'c_pagination' => 'pagination_blogs',
            'c_limit' => 5,
            'c_class_pagination' =>
                array(
               'c_tabela' => get_class()
               ),
             'c_action' => 'cliente/login/dashboard',
            'c_id_where_blogs' =>  ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
		));
		
	}

	public function dashboard()
	{
		$data['tabela'] = tabelasBD('login_dashboard');
		$data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
		foreach ($data['campos'] as $resultCampos): // CAMPOS DA TABELA DESEJADA 
			if($resultCampos->primary_key != 1 && $resultCampos->default != 'FILE'): 
			 $this->form_validation->set_rules($resultCampos->name, $resultCampos->name, 'required');
			endif;
		endforeach;
		$data['tabela'] = tabelasBD('login_dashboard');
		$data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
		$data['metodo'] = get_class_methods(get_class())[2];
         foreach ($data['campos'] as $resultCampos) :
         	if($resultCampos->primary_key != 1): 
         		$date[$resultCampos->name] = $this->input->post($resultCampos->name);
         	endif;
         	if ($resultCampos->default == 'FILE') :
 				if ($this->upload($resultCampos->name)) :
 					$upload_data = $this->upload($resultCampos->name);
 					$date[$resultCampos->name] = base_url('/'). $upload_data['upload_path'] . $upload_data['file_name'];
 				endif;
         	endif;
		 endforeach;
		 
         if($this->Modulos_Model->crud($data, $date)):
         	redirect(BaseController(null , null , null , 'dashboard'));
         else:
			 $this->session->set_flashdata(array(
				 'flashdata' => array(
					'msm' =>  'Login ou senha incorretos !',
					'class' => 'alert-box alert round'
				 )
			 ));
			 
             redirect(BaseController('cliente' ,'login', null , 'site'));
         endif;
	}

	public function esqueci_minha_senha(){

		
	}

}	