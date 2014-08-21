<?php
class List_model extends CI_Model{
    
    /*
	* This function is used to get all the lists related to the user passed as the arguement
    * this function is also called from the home controller
    */
    public function get_all_lists($user_id){
        $this->db->where('list_user_id',$user_id);
        $this->db->order_by('create_date', 'asc'); 
        $query = $this->db->get('lists');
        return $query->result();
    }

    /*
	* this function fetches 1 particular list of a "id"
	* IMP - since we pass only one row , used query->row insted of query->result
    */
    public function get_list($id){
        $this->db->select('*');
        $this->db->from('lists');
        $this->db->where('id',$id);
        $query = $this->db->get();
         if($query->num_rows() != 1){
            return FALSE;
        }
        return $query->row();
    }

    /*
	* Function used to create new list
    */
    public function create_list($data){
		$insert = $this->db->insert('lists', $data);
		return $insert;
    }

    /*
	* used in the U of crud to update a list
    */
    public function edit_list($list_id,$data){
        $this->db->where('id', $list_id);
        $this->db->update('lists', $data); 
        return TRUE;
    }
    
    /*
	* used in the U of crud to update a list
	* this method will get the data from the lists table to be displayed in the form
    */
    public function get_list_data($list_id){
        $this->db->where('id',$list_id);
        $query = $this->db->get('lists');
        return $query->row();
    }

    /*
	* used to delete a list
    */
    public function delete_list($list_id){
        $this->db->where('id',$list_id);
        $this->db->delete('lists');
        $this->delete_tasks_of_list($list_id);
        return;
    }

    /* called from the above function to delete the tasks in a list*/
    private function delete_tasks_of_list($list_id){
        $this->db->where('list_id',$list_id);
        $this->db->delete('tasks');
        return;
    }
    

    /*
    * function used to fetch tasks for a list
    * @param $active if true fetches active/un-complete with is_complete value 0 tasks else with is_complete value 1
    * imp due to the join present
    */
    public function get_list_tasks($list_id,$active = true){
        $this->db->select('
            tasks.task_name,
            tasks.task_body,
            tasks.id as task_id,
            lists.list_name,
            lists.list_body
            ');
        $this->db->from('tasks');
        $this->db->join('lists', 'lists.id = tasks.list_id');
        $this->db->where('tasks.list_id',$list_id);
        if($active == true){
            $this->db->where('tasks.is_complete',0);
        } else {
            $this->db->where('tasks.is_complete',1);
        }
        $query = $this->db->get();
        if($query->num_rows() < 1){
            return FALSE;
        }
        return $query->result();
        
    }

}