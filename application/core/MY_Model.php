<?php 
class MY_Model extends CI_Model
{
	private $conf = array(
        'prefixo_tb' => 'tb_'
    );

	public function get_esqueci_senha()
	{
		
	}

	public function insert_api_instagram( $dados )
	{
	
		if(!empty( $dados )):
			$_dados['access_token'] = $dados->access_token;
			$_dados['user_id'] = $dados->user->id;
			$_dados['user_bio'] = $dados->user->bio;
			$_dados['user_name'] = $dados->user->username;
			$_dados['user_picture'] = $dados->user->profile_picture;
			$_dados['user_full_name'] = $dados->user->full_name;
			$_dados['usu_id'] = $this->session->userdata('id-login');
		
			return $this->db->insert('tb_instagram_api' , $_dados);
		else:
			return false;
		endif;
	}


	public function get_api_instagram( )
	{
		$this->db->where('usu_id' , $this->session->userdata('id-login')); 
		return $this->db->get('tb_instagram_api')->row();
	}



	# configurações padroes do sistema de ferramentas e modulos

	public function get_permissoes( Array $dados )
	{ 
		if(!empty( $dados )):
			$this->db->where('tb_permissao.tb_login',$this->session->userdata('id-login'));
			$this->db->where('tb_modulos.slug',$dados['modulo']);
			$this->db->join('tb_modulos','tb_permissao.tb_modulos = tb_modulos.id');
			return $this->db->get('tb_permissao')->row();
		else:
			return false;
		endif;
	}



	#core database generate query automatica

	public function query_auto_view( Array $dados )
	{
		if(!empty( $dados )):

			if(isset($dados['M_id'])):

			endif;

			if(isset($dados['M_pagination'])):

			endif;

			if(isset($dados['M_orderby'])):

			endif;

			if(isset($dados['M_limit'])):

			endif;

			if(isset($dados['M_type']) && $dados['M_type'] === 'array'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['M_tabela'])->result_array();
			elseif(isset($dados['M_type']) && $dados['M_type'] === 'row'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['M_tabela'])->result_array();
			elseif(isset($dados['M_type']) && $dados['M_type'] === 'num_rows'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['M_tabela'])->num_rows();
			endif;
		else:
			return FALSE;
		endif;
	}

	public function query_auto_select_list()
	{
		
	}
}