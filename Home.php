<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('model', 'dados');

    }
    
    public function dados(){
        $dt_inicial = $this->input->post('dt_inicial'); 
        $dt_fim = $this->input->post('dt_fim');
               
        $config['base_url'] = base_url('home/dados');
        $config['total_rows'] = $this->dados->quantidade($dt_inicial, $dt_fim);
        $config['per_page'] = 20;
        $inicio = (!$this->uri->segment("3")) ? 0 : $this->uri->segment("3");
        $limite = $inicio + 20;
        $this->pagination->initialize($config);

        $data['dados'] = $this->dados->dados($dt_inicial, $dt_fim, $limite, $inicio);
        $data['paginacao'] = $this->pagination->create_links();


        if ($data) {
            $this->load->view('head');
            $this->load->view('relatorio', $data);
            $this->load->view('footer');
        } else {
            die("Não foi possível inserir os dados!");
        }
    }
     
}
