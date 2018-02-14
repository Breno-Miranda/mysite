<?php 
    
class Solicitacao extends MY_Controller{

    private $conf = array(
        'class_artificial' => 'solicitacao_dashboard'
    );
        
    function __construct() 
    {
        parent::__construct();
        autorizacao_dashboard();
    }
    
    public function index()
    {   
        $this->layout(array(
            'c_diretorio' => 'layout/dashboard/index',
            'c_class' => $this->conf['class_artificial'],
            'c_class_nativa' => get_class(),
            'c_metodo' => get_class_methods(get_class())[1],
            'c_diretorio_pagina' => 'dashboard/pagina/'.get_class(),
            'c_layout' => 'dashboard',
            'c_pagination' => 'pagination',
            'c_limit' => 5,
            'c_class_pagination' =>
                array(
                'c_tabela' => $this->conf['class_artificial']),
            'c_padrao_dados' => 'dados'
        ));

    }

    public function salvar()
    {

        $data['tabela'] = tabelasBD($this->conf['class_artificial']);
        $data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
        
        foreach ($data['campos'] as $resultCampos): // CAMPOS DA TABELA DESEJADA 
            if($resultCampos->primary_key != 1 && $resultCampos->default != 'FILE'): 
             $this->form_validation->set_rules($resultCampos->name, $resultCampos->name, 'required');
            endif;
        endforeach;

        
        if ($this->form_validation->run() == FALSE)
        {


           $this->layout(array(
                'c_diretorio' => 'layout/dashboard/index',
                'c_class' => $this->conf['class_artificial'],
                'c_class_nativa' => get_class(),
                'c_metodo' => get_class_methods(get_class())[1],
                'c_diretorio_pagina' => 'dashboard/pagina/'.get_class().'/'.  get_class_methods(get_class())[2],
                'c_layout' => 'site',
                'c_pagination' => 'pagination   ',
                'c_limit' => 5,
                'c_class_pagination' =>
                    array(
                    'c_tabela' => $this->conf['class_artificial']),
                'c_padrao_dados' => 'dados',
                'c_metodo_extends' => get_class_methods(get_class())[2],
            'action' => BaseController(get_class() ,get_class_methods(get_class())[2] ,null, 'dashboard')
            ));


        }
        else
        {
            $data['tabela'] = tabelasBD($this->conf['class_artificial']);
            $data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
            $data['metodo'] = get_class_methods(get_class())[2];
             foreach ($data['campos'] as $resultCampos) :
                if($resultCampos->primary_key != 1 && $resultCampos->default != 'FILE'): 
                    $date[$resultCampos->name] = $this->input->post($resultCampos->name);
                endif;
                if ($resultCampos->default == 'FILE') :
                    if ($this->upload($resultCampos->name)) :
                        $upload_data = $this->upload($resultCampos->name);
                        $date[$resultCampos->name] = base_url('/'). $upload_data['upload_path'] . $upload_data['file_name'];
                    endif;
                endif;
             endforeach;
             if($this->Modulos_Model->crud($data, $date)){
                redirect(BaseController(get_class(), null , null , 'dashboard'));
             } else {
                show_error('erro de cadastro ou o servidor falhou !');
             }
        }

    }

    public function editar()
    {
        $data['tabela'] = tabelasBD(get_class());
        $data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
        foreach ($data['campos'] as $resultCampos): // CAMPOS DA TABELA DESEJADA 
            if($resultCampos->primary_key != 1 && $resultCampos->default != 'FILE'): 
             $this->form_validation->set_rules($resultCampos->name, $resultCampos->name, 'required');
            endif;
        endforeach;
        if ($this->form_validation->run() == FALSE)
        {
            $this->layout(array(
                'c_diretorio' => 'layout/dashboard/index',
                'c_class' => get_class(),
                'c_metodo' => get_class_methods(get_class())[1],
                'c_diretorio_pagina' => 'dashboard/' .  get_class_methods(get_class())[3],
                'c_layout' => 'site',
                'c_pagination' => 'pagination_blogs',
                'c_limit' => 5,
                'c_class_pagination' =>
                    array(
                    'c_tabela' => get_class()),
                'c_padrao_dados' => 'dados',
                'c_metodo_extends' => get_class_methods(get_class())[2],
                'c_id_where' => ($this->uri->segment(4)) ? $this->uri->segment(4) : 0,
                'action' => BaseController(get_class() ,get_class_methods(get_class())[3] , ($this->uri->segment(4)) ? $this->uri->segment(4) : 0)
            ));
        }
        else
        {
            $data['tabela'] = tabelasBD(get_class());
            $data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
            $data['metodo'] = get_class_methods(get_class())[3];
            $data['id_where'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             foreach ($data['campos'] as $resultCampos) :
                if($resultCampos->primary_key != 1 && $resultCampos->default != 'FILE'): 
                    $date[$resultCampos->name] = $this->input->post($resultCampos->name);
                endif;
                if ($resultCampos->default == 'FILE') :
                    if ($this->upload($resultCampos->name)) :
                        $upload_data = $this->upload($resultCampos->name);
                        $date[$resultCampos->name] = base_url('/'). $upload_data['upload_path'] . $upload_data['file_name'];
                    endif;
                endif;
             endforeach;
             if($this->Modulos_Model->crud($data, $date)){
                redirect(BaseController(get_class(), null , null , 'dashboard'));
             } else {
                show_error('erro de cadastro ou o servidor falhou !');
             }
        }
    }
    public function deletar($id = null )
    {
        $data['tabela'] = tabelasBD(get_class());
        $data['campos'] = $this->Modulos_Model->tabela($data['tabela'] , null);
        $data['metodo'] = get_class_methods(get_class())[4];

        $date['id'] = $id;

        if(isset($id)):
            if($this->Modulos_Model->crud($data, $date)):
                redirect(BaseController(get_class(), null));
                else:
                show_error('erro de cadastro ou o servidor falhou !');
            endif;
        endif;
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


    public function view()
    {
         $this->layout(array(
            'c_diretorio' => 'layout/dashboard/index',
            'c_class' => $this->conf['class_artificial'],
            'c_class_nativa' => get_class(),
            'c_metodo' => get_class_methods(get_class())[1],
            'c_diretorio_pagina' => 'dashboard/pagina/'.get_class().'/view',
            'c_layout' => 'dashboard',
            'c_pagination' => 'pagination_'.get_class(),
            'c_limit' => 5,
            'c_class_pagination' =>
                array(
                'c_tabela' => $this->conf['class_artificial']),
            'c_id_where_paginas' =>  ($this->uri->segment(4)) ? $this->uri->segment(4) : 0
        ));
    }
}   