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

    public function index() {
        $customer_id = '09067508756';

        $data['main_account'] = $this->utility->get_main_account_balance($customer_id);
        $data['today_revenue'] = $this->utility->get_total_debit_by_date($customer_id, date('Y-m-d'));
        $data['yesterday_revenue'] = $this->utility->get_total_debit_by_date($customer_id, date('Y-m-d', strtotime('-1 day')));
        $data['weekly_revenue'] = $this->utility->get_total_debit_by_range($customer_id, date('Y-m-d', strtotime('-7 days')), date('Y-m-d'));
        $data['month_revenue'] = $this->utility->get_total_debit_by_range($customer_id, date('Y-m-01'), date('Y-m-d'));
        $data['year_revenue'] = $this->utility->get_total_debit_by_range($customer_id, date('Y-01-01'), date('Y-m-d'));
        
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