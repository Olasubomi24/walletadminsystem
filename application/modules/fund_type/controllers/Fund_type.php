<?php

class Fund_type extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');

        //$this->load->module('agg');
    }

    public function index() {
        $data['title'] = 'Funds List';
    
        // Fetch all funds from the utility class
        $fundsData = $this->utility->get_all_funds();
    
        // Pass the funds data to the view
        $data['funds'] = $fundsData;
    
        $data['content_view'] = 'fund_type/table'; // Load the fund table view
        $this->template->general_template($data);
    }
   
    public function adds_fund()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'fund_type/add_fund';
        $this->template->general_template($data);
    }
    
    public function add_fund()
    {
        if ($this->input->post()) {
            $fundData = [
                "fundname" => $this->input->post('fundname'),
                "amount" => $this->input->post('amount'),
                "insert_by" => $this->input->post('insert_by'),
                "status" => 0 // Setting status to 0 as required
            ];
    
            // Call the utility function to insert the fund data
            $insertResponse = $this->utility->insert_fund($fundData);
    
            if ($insertResponse) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Fund added successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'An error occurred while adding the fund.'
                ]);
            }
            exit();
        } else {
            $data['title'] = 'Add Fund';
            $data['content_view'] = 'fund_type/add_fund';
            $this->template->general_template($data);
        }
    }

    public function edit_fund($id = null) {
        // Validate if an ID is provided
        if (!$id) {
            show_404(); // Handle invalid requests
        }
    
        // Fetch the fund data by ID
        $fundData = $this->utility->get_fund_by_id($id);
    
        if (!$fundData) {
            $this->session->set_flashdata('error', 'Fund not found');
            redirect('fund/index'); // Redirect back to the index page
        }
    
        // Prepare data for the view
        $data = [
            'title' => 'Edit Fund',
            'content_view' => 'fund_type/edit',
            'fund' => $fundData
        ];
    
        // Load the template with the data
        $this->template->general_template($data);
    }
    
    public function update_fund() {
        // Validate CSRF token (if CSRF protection is enabled)
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id'); // Get the fund ID from the form data
    
            if (!$id) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid fund ID']);
                return;
            }
    
            // Fetch the existing fund data
            $existingFund = $this->utility->get_fund_by_id($id);
    
            if (!$existingFund) {
                echo json_encode(['status' => 'error', 'message' => 'Fund not found']);
                return;
            }
    
            // Collect form data
            $fundData = [
                "fundname" => $this->input->post('fundname'),
                "amount" => $this->input->post('amount'),
                "insert_by" => $this->input->post('insert_by'),
                "status" => $this->input->post('status') // Add status field
            ];
    
            // Call the utility method to update the fund
            $result = $this->utility->update_fund($id, $fundData);
    
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Fund updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update fund']);
            }
        } else {
            show_404(); // Handle non-AJAX requests
        }
    }

    public function adds_security_answer()
    {
        $data['title'] = 'Update Security Answer';
        $data['content_view'] = 'fund_type/adds_security_answer';
        $this->template->general_template($data);
    }

    public function update_security_answer()
    {
        if ($this->input->post()) {
            $phonenumber = $this->input->post('phonenumber');
            $security_answer = $this->input->post('security_answer');

            // Check if the phonenumber exists in the database
            $user = $this->utility->get_user_by_phonenumber($phonenumber);

            if ($user) {
                // Hash the security answer using bcrypt
                $hashed_answer = password_hash($security_answer, PASSWORD_BCRYPT);

                // Update user security answer
                $updateResponse = $this->utility->update_user_security($phonenumber, $hashed_answer);

                if ($updateResponse) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Security answer updated successfully.'
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to update security answer.'
                    ]);
                }
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Phonenumber not found.'
                ]);
            }
            exit();
        }
    }
}