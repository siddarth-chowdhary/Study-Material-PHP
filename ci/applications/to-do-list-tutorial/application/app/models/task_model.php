<?php
class Task_model extends CI_Model{
    
    /* used for R of CRUD , to get a task*/ 
    public function get_task($id){
        $this->db->where('id',$id);
        $query = $this->db->get('tasks');
        return $query->row();
    }

    /* used for R of CRUD , to check status of a task ,0 is uncomplete and 1 is complete*/ 
    public function check_if_complete($id){
        $this->db->where('id',$id);
        $query = $this->db->get('tasks');
        return $query->row()->is_complete;
    }

    /* used for C of CRUD , to get the list name of a particular list id*/
    public function get_list_name($list_id){
        $this->db->where('id',$list_id);
        $query = $this->db->get('lists');
        return $query->row()->list_name;
    }
    
    
    /* used for C of CRUD , to create a new task*/
    public function create_task($data){
	$insert = $this->db->insert('tasks', $data);
	return $insert;
    }

    /* used for U of CRUD , to get list id of a corresponding task id*/
    public function get_task_list_id($task_id){
        $this->db->where('id',$task_id);
        $query = $this->db->get('tasks');
        return $query->row()->list_id;
    }

    /* used for U of CRUD , to get all details of a task id*/
    public function get_task_data($task_id){
        $this->db->where('id',$task_id);
        $query = $this->db->get('tasks');
        return $query->row();
    }

    /* used for U of CRUD , to edit a task*/
    public function edit_task($task_id,$data){
        $this->db->where('id', $task_id);
        $this->db->update('tasks', $data); 
        return TRUE;
    }

    /* used for D of CRUD , to delete a task*/
    public function delete_task($task_id){
        $this->db->where('id',$task_id);
        $this->db->delete('tasks');
        return;
    }

     /*
     * This function is used to mark a task complete.
     * it will change the is_complete value in db to 1
     */
    public function mark_complete($task_id){
        $this->db->set('is_complete', 1);
        $this->db->where('id', $task_id);
        $this->db->update('tasks');
        return TRUE;
    }
    
    /*
     * This function is used to mark a task new.
     * it will change the is_complete value in db to 0
     */
    public function mark_new($task_id){
        $this->db->set('is_complete', 0);
        $this->db->where('id', $task_id);
        $this->db->update('tasks');
        return TRUE;
    }

    /*
    * get tasks of a user
    */
    public function get_users_tasks($user_id){
        $this->db->where('list_user_id',$user_id);
        $this->db->join('tasks', 'lists.id = tasks.list_id');
        $this->db->order_by('tasks.create_date', 'asc'); 
        $query = $this->db->get('lists');
        return $query->result();
    }
}