<?php 
    
class Solicitacao extends MY_Controller{

    private $class = array(
        'class_artificial' => 'solicitacao_dashboard',
        'tabela' => 'solicitacao_dashboard',
        'url' => 'dashboard/solicitacao/',
        'msm_sucesso' => 'operação realizado com sucesso',
        'msm_error' => 'operação não foi realizada. tente novamente.',
        'class_alert_sucesso' => 'alert alert-success',
        'class_alert_error' => 'alert alert-danger'
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
            'c_class' => get_class(),
            'c_metodo' => 'index',
            'c_diretorio_pagina' => 'dashboard/pagina/'.get_class(),
            'c_layout' => 'dashboard',
            'c_pagination' => 'pagination',
            'c_limit' => 5,
            'c_class_pagination' => array('c_tabela' => $this->class['tabela']),
            'c_campos' => $this->MY_Model->query_auto_campos_tabela(array(
                'm_tabela' => $this->class['tabela'],
            )),
            'w_dados' => $this->MY_Model->query_auto_roobor(array(
                'm_tabela' => $this->class['tabela'],
                'm_type' => 'objeto'
            )),
            'c_links' => array(
                'detalhes' => 'detalhe/'
            ),
            'c_replace' => 'solicitação'
        ));

    }

    public function salvar()
    {
        if(!empty($_POST)):

            $_POST['dados'] = $_POST;

             if(!empty($_FILES)):
               $upload = $this->upload("imagem");
                if($upload):
                    $_POST['dados']['imagem'] = base_url('/'). $upload['upload_path'] . $upload['file_name'];
                endif;
            endif;

            $status = $this->MY_Model->query_auto_insert(array(
                'm_type'    => 'insert',
                'm_tabela'  =>  $this->class['tabela'],
                'm_dados'   =>  $_POST['dados']
            ));

            if($status):
                $this->session->set_flashdata( array( 'flashdata' => array('class' => $this->class['class_alert_sucesso'] , 'msm' =>  $this->class['msm_sucesso'])));
                redirect( base_url($this->class['url']));
            else:
                $this->session->set_flashdata( array( 'flashdata' => array( 'class' => $this->class['class_alert_error'] , 'msm' =>  $this->class['msm_error'])));
                redirect( base_url($this->class['url'] . 'salvar'));
            endif;

        else:

            $this->layout(array(
                'c_diretorio' => 'layout/dashboard/index',
                'c_class' => get_class(),
                'c_metodo' => 'index',
                'c_diretorio_pagina' => 'dashboard/pagina/'.get_class().'/salvar',
                'c_layout' => 'dashboard',
                'c_pagination' => 'pagination',
                'c_limit' => 5,
                'c_class_pagination' => array('c_tabela' => $this->class['tabela']),
                'c_campos' => $this->MY_Model->query_auto_campos_tabela(array(
                    'm_tabela' => $this->class['tabela']
                )),
                'c_links' => array(
                    'detalhes' => 'detalhe/'
                ),
                'c_replace' => 'solicitação',
                'c_campos_not' => array('tb_status'),
                'c_action' => base_url($this->class['url'] . 'salvar')
            ));

        endif;

    }

    public function editar( $id )
    {
        if(!empty($_POST)):

            $_POST['dados'] = $_POST;

             if(!empty($_FILES)):
               $upload = $this->upload("imagem");
                if($upload):
                    $_POST['dados']['imagem'] = base_url('/'). $upload['upload_path'] . $upload['file_name'];
                endif;
            endif;

            $status = $this->MY_Model->query_auto_update(array(
                'm_type'    => 'update',
                'm_tabela'  =>  $this->class['tabela'],
                'm_dados'   =>  $_POST['dados'],
                'm_where'   =>  array( 0 => array('m_coluna' => 'id', 'm_id' => $id))
            ));

            if($status):
                $this->session->set_flashdata( array( 'flashdata' => array('class' => $this->class['class_alert_sucesso'] , 'msm' =>  $this->class['msm_sucesso'])));
                redirect( base_url($this->class['url']));
            else:
                $this->session->set_flashdata( array( 'flashdata' => array( 'class' => $this->class['class_alert_error'] , 'msm' =>  $this->class['msm_error'])));
                redirect( base_url($this->class['url'] . 'editar'));
            endif;
        else:
            $this->layout(array_merge(array(
                'c_diretorio' => 'layout/dashboard/index',
                'c_class' => get_class(),
                'c_metodo' => 'index',
                'c_diretorio_pagina' => 'dashboard/pagina/'.get_class().'/editar',
                'c_layout' => 'dashboard',
                'c_pagination' => 'pagination',
                'c_limit' => 5,
                'c_class_pagination' => array('c_tabela' => $this->class['tabela']),
                'c_campos' => $this->MY_Model->query_auto_campos_tabela(array(
                    'm_tabela' => $this->class['tabela']
                )),
                'c_links' => array(
                    'detalhes' => 'detalhe/'
                ),
                'w_dados' => $this->MY_Model->query_auto_view(array(
                    'm_tabela' => $this->class['tabela'],
                    'm_type' => 'objeto',
                    'm_id' => $id
                )),
                'c_replace' => 'solicitação',
                'c_action' => base_url($this->class['url'] . 'editar/'. $id)
            ), $this->MY_Model->query_auto_dropdown(array(
                'm_tabela' => $this->class['tabela']
            ))));

        endif;

    }

    public function deletar( $id )
    {
        if(isset( $id )):

            $status = $this->MY_Model->query_auto_delete(array(
                'm_tabela'  => $this->class['tabela'],
                'm_where'   => array(  0 => array('m_coluna' => 'id', 'm_id' => $id))
            ));

            if( $status ):
                $this->session->set_flashdata( array( 'flashdata' => array('class' => $this->class['class_alert_sucesso']  , 'msm' =>  $this->class['msm_sucesso'])));
                redirect( base_url($this->class['url']));
            else:
                $this->session->set_flashdata( array( 'flashdata' => array( 'class' => $this->class['class_alert_error'] , 'msm' =>  $this->class['msm_error'])));
                redirect( base_url($this->class['url']));
            endif;
        else:
            return redirect(base_url($this->class['url']));
        endif;
    }

    public function view( $id )
    {
         $this->layout(array(
            'c_diretorio' => 'layout/dashboard/index',
            'c_class' => get_class(),
            'c_metodo' => 'index',
            'c_diretorio_pagina' => 'dashboard/pagina/'.get_class(),
            'c_layout' => 'dashboard',
            'c_pagination' => 'pagination',
            'c_limit' => 5,
            'c_class_pagination' => array('c_tabela' => $this->class['tabela']),
            'c_campos' => $this->MY_Model->query_auto_campos_tabela(array(
                'm_tabela' => $this->class['tabela'],
            )),
            'w_dados' => $this->MY_Model->query_auto_view(array(
                'm_tabela' => $this->class['tabela'],
                'm_type' => 'objeto',
                'm_id' => $id
            )),
            'c_links' => array(
                'detalhes' => 'detalhe/'
            ),
            'c_replace' => 'solicitação'
        ));
    }
}   