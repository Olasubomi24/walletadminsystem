<?php

class Dashboard extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');

        $this->load->module('agg');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard/dashboard';
        $this->template->general_template($data);
    }
    public function table()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard/table';
        $this->template->general_template($data);
    }
}