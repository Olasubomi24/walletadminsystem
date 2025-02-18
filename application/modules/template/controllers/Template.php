<?php
class Template extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function auth_template($data)
    {
        $this->load->view('auth_template', $data);
    }

    public function general_template($data)
    {
        $this->load->view('general_template', $data);
    }
    public function login_template($data)
    {
        $this->load->view('login_template', $data);
    }
}
