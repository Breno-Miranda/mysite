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

			if(!empty($dados['m_where'])):
				foreach($dados['m_where'] as $index => $where):
					$this->db->where($this->conf['prefixo_tb'].$dados['m_tabela'].'.'.$where['m_coluna'] , $where['m_id']);
				endforeach;
			endif;
			
			if(isset($dados['m_id'])): 
				$this->db->where($this->conf['prefixo_tb'].$dados['m_tabela'].'.id' , $dados['m_id']);
			endif;

			if(isset($dados['m_pagination'])): 	endif;

			if(isset($dados['m_orderby'])): endif;

			if(isset($dados['m_limit'])): 	endif;

			if(isset($dados['m_type']) && $dados['m_type'] === 'array'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->result_array();
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'objeto'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->result();
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'row'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->row();
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'row_array'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->row_array();
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'num_rows'):
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->num_rows();
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'true_false'):
				$this->db->get($this->conf['prefixo_tb'].$dados['m_tabela']);
				return $this->db->affected_rows() ? true  : false;
			elseif(isset($dados['m_type']) && $dados['m_type'] === 'json'):
				return json_encode($this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->result_array(), true);
			endif;
		else:
			return FALSE;
		endif;
	}

	public function query_auto_dropdown( Array $dados )
	{
		if(!empty($dados)):

			$campos = $this->db->field_data($this->conf['prefixo_tb'].$dados['m_tabela']);
			
			foreach($campos as $campo):
				if($campo->default == 1):
					$dropdown[$campo->name] = $this->query_auto_dropdown_core($campo);
				endif;
			endforeach;

			return !empty($dropdown) ? $dropdown : array();
		else:
			return FALSE;
		endif;
	}

	public function query_auto_campos_tabela( Array $dados )
	{
		if(!empty($dados)):

			if(isset($dados['m_select'])):
				$this->db->select("{$dados['m_select']}");
				return $this->db->get($this->conf['prefixo_tb'].$dados['m_tabela'])->field_data();
			else:
				return $this->db->field_data($this->conf['prefixo_tb'].$dados['m_tabela']);
			endif;
		else:
			return FALSE;
		endif;
	}

	public function query_auto_dropdown_core( $dados )
	{
		if(isset( $dados )):

				$retorno[0] = "Escolha um opção";
				
				$this->db->order_by($dados->name.'.id' , 'desc');
				
				$result = $this->db->get(strval($dados->name))->result();
			
				foreach($result as $row):
					$retorno[$row->id] = $row->slug;
				endforeach;
				
			return $retorno;
		else:
			return FALSE;
		endif;
	}

	public function query_auto_roobor( Array $dados )
	{
		if(isset($dados['m_where'])):
			$this->db->where($dados['m_where'] ,$dados['m_where_id']);
		endif;
		

		$dados['campos'] = $this->db->field_data($this->conf['prefixo_tb'].$dados['m_tabela']);
		$dados['m_tabela'] = $this->conf['prefixo_tb'].$dados['m_tabela'];
		
		if(isset($dados['campos'])): 

			if($dados['campos'][0]->primary_key == 1 ):
				$this->db->order_by("{$dados['m_tabela']}.id " , 'desc');
			endif;

			foreach ($dados['campos'] as $index => $CamposResult):
				if($CamposResult->primary_key == 1):
					$this->db->select($dados['m_tabela'].'.'.$CamposResult->name);
				elseif($CamposResult->name == 'data'):
					$this->db->select("date_format({$dados['m_tabela']}.{$CamposResult->name} , '%d/%m/%Y') as {$CamposResult->name}");
				elseif($CamposResult->name == 'datainicial'):
					$this->db->select("date_format({$dados['m_tabela']}.{$CamposResult->name} , '%d/%m/%Y') as {$CamposResult->name}");
				elseif($CamposResult->name == 'datafinal'):
					$this->db->select("date_format({$dados['m_tabela']}.{$CamposResult->name} , '%d/%m/%Y') as {$CamposResult->name}");
				elseif($CamposResult->name == 'slug' ):
					$this->db->select("{$dados['m_tabela']}.slug");
				elseif($CamposResult->default == 1 && $CamposResult->type == 'int' ):
					$this->db->select("{$CamposResult->name}.slug AS {$CamposResult->name}");
					$this->db->select("{$CamposResult->name}.id AS id_t_".$index); // ID_T CODIGO IDENTIFICAÇÃO DE OUTRA TABELA
				elseif(isset($dados['m_select'])):
					$this->db->select("{$dados['m_select']}");
				else:
					$this->db->select($dados['m_tabela'].'.'.$CamposResult->name);
				endif;
				if ($CamposResult->default == 1 && $CamposResult->name != "timestamp" && $CamposResult->type == "int"  ):
					$this->db->join($CamposResult->name, "{$dados['m_tabela']}.{$CamposResult->name}={$CamposResult->name}.id " ,'LEFT');
				endif;
			endforeach;
		endif;

		return $this->db->get($dados['m_tabela'])->result();
	}

	public function query_auto_insert(Array $dados)
	{	
		if(!empty($dados)):
				if(!empty($dados['m_dados']) && isset($dados['m_type']) && $dados['m_type'] == "return_id"):
					$this->db->insert($this->conf['prefixo_tb'].$dados['m_tabela'] , $dados['m_dados']);
					return $this->db->insert_id();
				elseif(!empty($dados['m_dados']) && isset($dados['m_type']) && $dados['m_type'] == "batch"):
					return $this->db->insert_batch($this->conf['prefixo_tb'].$dados['m_tabela'] , $dados['m_dados']);
				elseif(!empty($dados['m_dados']) && isset($dados['m_type']) && $dados['m_type'] == "insert"):
					return $this->db->insert($this->conf['prefixo_tb'].$dados['m_tabela'] , $dados['m_dados']);
				else:
					return FALSE;
				endif;
			else:
				return FALSE;
		endif;
	}

	public function query_auto_update(Array $dados)
	{	
		if(!empty($dados)):

				if(!empty($dados['m_where'])):
					foreach($dados['m_where'] as $index => $where):
						$this->db->where($this->conf['prefixo_tb'].$dados['m_tabela'].'.'.$where['m_coluna'] , $where['m_id']);
					endforeach;
				endif;
				
				if(!empty($dados['m_dados']) && isset($dados['m_type']) && $dados['m_type'] == "update"):
					return $this->db->update($this->conf['prefixo_tb'].$dados['m_tabela'] , $dados['m_dados']);
				elseif(!empty($dados['m_dados']) && isset($dados['m_type']) && $dados['m_type'] == "batch"):
					return $this->db->update_batch($this->conf['prefixo_tb'].$dados['m_tabela'] , $dados['m_dados']);
				else:
					return FALSE;
				endif;
			else:
				return FALSE;
		endif;
	}

	public function query_auto_delete(Array $dados)
	{
		if(!empty( $dados )):

			if(!empty($dados['m_where'])):
				foreach($dados['m_where'] as $index => $where):
					$this->db->where($this->conf['prefixo_tb'].$dados['m_tabela'].'.'.$where['m_coluna'] , $where['m_id']);
				endforeach;
				return $this->db->delete($this->conf['prefixo_tb'].$dados['m_tabela']);
			endif;
		else:
			return FALSE;
		endif;
	}

	
}