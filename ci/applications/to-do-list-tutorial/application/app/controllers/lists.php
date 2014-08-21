<?php

class Lists extends CI_Controller {
    
	/*
	* @purpose - if the user is not logged in , dont allow him to access lists.
	* redirected to the home/index
	*/
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            //Set error
            $this->session->set_flashdata('need_login', 'Sorry, you need to be logged in to view that area');
            redirect('home/index');
        }
    }


    public function index(){
        //Get the logged in users id
        $user_id = $this->session->userdata('user_id');
        
        //Get all lists from the model
        $data['lists'] = $this->List_model->get_all_lists($user_id);
        // echo '<pre>';print_r($data);die(__FILE__.__FUNCTION__.__LINE__);
        
        //Load view and layout
        $data['main_content'] = 'lists/index';
        $this->load->view('layouts/main',$data);
    }

    /*
	* R of CRUD
	* shows details of a list id fetched from the url
    */
    public function show($id){
    	// echo '<pre>';print_r($id);die(__FILE__.__FUNCTION__.__LINE__);
        
        //Get all lists from the model
        $data['list'] = $this->List_model->get_list($id);
        
        //Get all completed tasks for this list
        $data['completed_tasks'] = $this->List_model->get_list_tasks($id,true);
        //Get all uncompleted tasks for this list
        $data['uncompleted_tasks'] = $this->List_model->get_list_tasks($id,false);
        
        //Load view and layout
        $data['main_content'] = 'lists/show';
        $this->load->view('layouts/main',$data);
    }

    /*
	* C of CRUD
	* used to create a new list, opens a form for it
    */
    public function add(){
        $this->form_validation->set_rules('list_name','List Name','trim|required|xss_clean');
        $this->form_validation->set_rules('list_body','List Body','trim|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'lists/add_list';
            $this->load->view('layouts/main',$data);  
        } else {
            //Validation has ran and passed  
             //Post values to array - these are directly inserted to the database 
        	// intelligent code here ,no need to redeclare the arrays again in the model
            $data = array(             
                'list_name'    => $this->input->post('list_name'),
                'list_body'    => $this->input->post('list_body'),
                'list_user_id' => $this->session->userdata('user_id')
            );
           if($this->List_model->create_list($data)){
                $this->session->set_flashdata('list_created', 'Your task list has been created');
                //Redirect to index page with error above
                redirect('lists/index');
           }
        }
    }

    /*
	* U of CRUD
	* used to update  list, opens a form for it
	* values for the edit form are prefilled in the view and passed from this controller ,fetched from the get_list_data function
    */
    public function edit($list_id){
        $this->form_validation->set_rules('list_name','List Name','trim|required|xss_clean');
        $this->form_validation->set_rules('list_body','List Body','trim|xss_clean');
        
        if($this->form_validation->run() == FALSE){
            //Get the current list info
            $data['this_list'] = $this->List_model->get_list_data($list_id);
            //Load view and layout
            $data['main_content'] = 'lists/edit_list';
            $this->load->view('layouts/main',$data);  
        } else {
            //Validation has ran and passed  
             //Post values to array
            $data = array(             
                'list_name'    => $this->input->post('list_name'),
                'list_body'    => $this->input->post('list_body'),
                'list_user_id' => $this->session->userdata('user_id')
            );
           if($this->List_model->edit_list($list_id,$data)){      
                $this->session->set_flashdata('list_updated', 'Your task list has been updated');
                //Redirect to index page with error above
                redirect('lists/index');
           }
        }
    }

    /*
	* D of CRUD
	* used to delete  list
	* PENDING
    */
    public function delete($list_id){      
            //Delete list
            $this->List_model->delete_list($list_id);
            //Create Message
            $this->session->set_flashdata('list_deleted', 'Your list has been deleted');        
            //Redirect to list index
            redirect('lists/index');
     }

    /*
    * for quick add feature on the landing page , redirects to the add_list form
    */
    public function quickadd(){
        $this->form_validation->set_rules('list_name','List Name','trim|required|xss_clean');
        if($this->form_validation->run() == FALSE){
            //Load view and layout
            $data['main_content'] = 'home';
            $this->load->view('layouts/main',$data);  
        } else {
            $data['list_name'] = $this->input->post('list_name');
            //Load view and layout
            $data['main_content'] = 'lists/add_list';
            $this->load->view('layouts/main',$data);  
        }
    }
}   