<?php

require_once ("Secure_area.php");

class Home extends Secure_area {

    function __construct()
    {
        parent::__construct('home');
    }

    function index()
    {
        $user_info = $this->Employee->get_logged_in_employee_info();
        if ( $user_info->role_id == CUSTOMER_ROLE_ID )
        {
            redirect('leads/dashboard');
        }
        
        $data["total_loans"] = $this->Loan->get_total_loans();
        $data["total_borrowers"] = $this->Customer->count_all();
        $data["my_wallet"] = $this->My_wallet->get_total();
        $this->load->view("home", $data);
    }

    function logout()
    {
        $this->Employee->logout();
    }

}

?>