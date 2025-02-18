<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Fund_admin_wallet extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');

        //$this->load->module('agg');
    }

// Load the fund admin wallet page
public function fund_admin_wallet() {
    $data['title'] = 'Fund Admin Wallet';
    $data['fund_types'] = $this->utility->get_fund_types(); // Fetch fund types
    $data['content_view'] = 'fund_admin_wallet/add_fund';
    $this->template->general_template($data);
}



public function index() {
    $data['title'] = 'Customer Wallet Transactions';
    $data['customer_wallets'] = $this->utility->get_all_customer_wallets();
    $data['content_view'] = 'fund_admin_wallet/table';
    $this->template->general_template($data);
}

public function get_user_details() {
    log_message('debug', 'Received POST Data: ' . json_encode($_POST));

    $phone = $this->input->post('phone');

    if (!$phone) {
        echo json_encode(['status' => 'error', 'message' => 'Phone number is required']);
        return;
    }

    $user = $this->utility->get_user_by_phone($phone);

    if ($user) {
        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
}


// Fetch fund details by ID
public function get_fund_details() {
    $fund_id = $this->input->post('id');
    $fund = $this->utility->get_funds_by_id($fund_id);
   
    if ($fund) {
        echo json_encode(['status' => 'success', 'fund' => $fund]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Fund not found']);
    }
}

public function adds_fund()
{
    $data['title'] = 'Dashboard';
    $data['fund_types'] = $this->utility->get_fund_types(); // Fetch fund types
    $data['content_view'] = 'fund_admin_wallet/add_fund';
    $this->template->general_template($data);
}

// Validate security answer and insert fund
public function add_fund() {
    $phone = $this->input->post('phone');
    $security_answer = $this->input->post('security_answer');
    $user = $this->utility->validate_security_answer($phone, $security_answer);

    if (!$user) {
        echo json_encode(['status' => 'error', 'status_code' => 1, 'message' => 'Invalid security answer']);
        return;
    }

    // Get the current wallet balance (if any)
    $current_balance = $this->utility->get_wallet_balance($phone);

    // Check if the operation is CR or DR
    $operation_type = 'CR'; // Default is CR (Credit)
    $amount = $this->input->post('amount');

    if ($operation_type === 'CR') {
        // If wallet balance is NULL, start from 0, else add amount to current balance
        $new_balance = ($current_balance === NULL) ? $amount : ($current_balance + $amount);
    } elseif ($operation_type === 'DR') {
        // For DR (Debit), subtract the amount from the current balance
        $new_balance = ($current_balance === NULL) ? -$amount : ($current_balance - $amount);
    }

    // Insert transaction into the customer_wallets table with wallet balance calculation
    $data = [
        'transaction_reference' => uniqid('TXN_'),
        'customer_id' => $phone,
        'username' => $user['username'],
        'user_type_id' => $user['user_type_id'],
        'fund_id' => $this->input->post('fund_id'),
        'amount' => $amount,
        'operation_type' => $operation_type,
        'description' => $this->input->post('description'),
        'status_code' => 0,
        'status' => 'successful',
        'wallet_balance' => $new_balance // Directly store the updated balance
    ];

    // Insert the transaction with the calculated wallet balance
    $this->utility->insert_customer_wallet($data);

    echo json_encode(['status' => 'success', 'status_code' => 0, 'message' => 'Fund added successfully']);
}

}