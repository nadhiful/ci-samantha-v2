<?php 
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class c_home extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->check_isvalidated();
        $this->load->model('m_trans');
    }
    
    public function index(){
        // If the user is validated, then this function will run
      //  echo 'Congratulations, you are logged in.';*/
        // Add a link to logout
        /* echo '<br /><a href=''.base_url().'home/do_logout'>Logout Fool!</a>';-------> */
    $this->load->view('v_index2');
    }
    
 function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('c_login');
        }
    }
    
    function do_logout(){
        $this->session->sess_destroy();
        redirect('c_login');
    }
 }
 ?>