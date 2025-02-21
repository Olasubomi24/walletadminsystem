<?php
class Auth extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->module('template');
        $this->load->module('utility');
        $this->load->library('session');
    }

    // public function user_account()
    // {

    //     $data = array(
    //         'content_view' => 'auth/user_account',
    //         'title' => 'User  Account',
    //     );

    //     $this->template->auth_template($data);
    // }

    // public function create_account()
    // {

    //     $data = array(
    //         'content_view' => 'auth/create_account',
    //         'title' => 'Create account',
    //     );

    //     $this->template->auth_template($data);
    // }
    public function index()
    {
        $data = array(
            'title' => 'Log In',
            'content_view' => 'auth/login'
        );
        $this->template->auth_template($data);
    }

    // public function login()
    // {
    //     // Check if the request is an AJAX POST request
    //     if ($this->input->is_ajax_request() && $this->input->method() === 'post') {
    //         // Get input data
    //         $email = trim($this->input->post('email'));
    //         $password = trim($this->input->post('password'));
    
    //         // Validate input (basic validation)
    //         if (empty($email) || empty($password)) {
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => 'Email and password are required.'
    //             ]);
    //             return;
    //         }
    
    //         // Call the utility function to validate user credentials
    //         $login_response = $this->utility->user_login($email, $password);
    
    //         if ($login_response['status_code'] === '0') {
    //             // Login successful
    //             $user_details = $login_response['user_details'];
    
    //             // Start a session or set session variables as needed
    //             $this->session->set_userdata([
    //                 'logged_in' => true,
    //                 'user_email' => $user_details->email,
    //                 'firstname' => $user_details->firstname,
    //                 'lastname' => $user_details->lastname,
    //                 'phonenumber' => $user_details->phonenumber,
    //                 'user_type_id' => $user_details->user_type_id, // Store user_type_id in session
    //                 'user_name' => $user_details->firstname . ' ' . $user_details->lastname
    //             ]);
    
    //             // Return success response with redirect URL
    //             echo json_encode([
    //                 'status' => 'success',
    //                 'message' => 'Login Successful!',
    //                 'redirect' => base_url('dashboard')
    //             ]);
    //         } else {
    //             // Login failed
    //             echo json_encode([
    //                 'status' => 'error',
    //                 'message' => $login_response['message']
    //             ]);
    //         }
    //     } else {
    //         // Invalid request
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Invalid request method.'
    //         ]);
    //     }
    // }

    public function login()
{
    if ($this->input->is_ajax_request() && $this->input->method() === 'post') {
        $email = trim($this->input->post('email'));
        $password = trim($this->input->post('password'));

        if (empty($email) || empty($password)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email and password are required.'
            ]);
            return;
        }

        $login_response = $this->utility->user_login($email, $password);
          //print_r($login_response);die();
        if ($login_response['status_code'] === '0') {
            $user_details = $login_response['user_details'];

            $this->session->set_userdata([
                'logged_in' => true,
                'user_email' => $user_details->email,
                'firstname' => $user_details->firstname,
                'lastname' => $user_details->lastname,
                'phonenumber' => $user_details->phonenumber,
                'user_type_id' => $user_details->user_type_id,
                'user_name' => $user_details->firstname . ' ' . $user_details->lastname
            ]);

            echo json_encode([
                'status' => 'success',
                'message' => 'Login Successful!',
                'redirect' => base_url('dashboard'),
                'user_details' => [
                    'status' => $user_details->status
                ]
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => $login_response['message']
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request method.'
        ]);
    }
}


    public function sign_up()
    {
        $data = array(
            'title' => 'Sign Up',
            'content_view' => 'auth/sign_up'
        );
        $this->template->auth_template($data);
    }

    public function user_creation()
    {
        // Set form validation rules
        $this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
        $this->form_validation->set_rules('phonenumber', 'Phonenumber', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[admins.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required|in_list[1,2]'); // Ensure valid user type
    
        if ($this->input->is_ajax_request()) {
            if ($this->form_validation->run() == false) {
                // Validation failed, return errors as JSON
                echo json_encode([
                    'status' => 'error',
                    'message' => validation_errors()
                ]);
                return;
            }
    
            // Collect input data
            $firstname = $this->input->post('firstname');
            $lastname = $this->input->post('lastname');
            $phonenumber = $this->input->post('phonenumber');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user_type_id = $this->input->post('user_type_id');
    
            // Generate username dynamically
            $username = strtolower(str_replace(' ', '_', $firstname . '_' . $lastname));
    
            // Hash the password securely using bcrypt
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
            // Call the utility function to create the user
            $send_data = $this->utility->user_creation($firstname, $lastname, $phonenumber, $username, $email, $hashed_password, $user_type_id);
    
            if ($send_data['status_code'] == 0) {
                // Success: User created successfully
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User created successfully'
                ]);
            } else {
                // Failure: Operation failed
                echo json_encode([
                    'status' => 'error',
                    'message' => $send_data['message']
                ]);
            }
        } else {
            // Invalid request
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid request method.'
            ]);
        }
    }

    public function reset_password()
    {

        $data = array(
            'content_view' => 'auth/reset_password',
            'title' => 'Reset password',
        );

        $this->template->auth_template($data);
    }

    public function reset_password_update()
    {
        if ($this->input->is_ajax_request() && $this->input->method() === 'post') {
            $email = $this->input->post('email');
            $new_password = trim($this->input->post('new_password'));
            $confirm_password = trim($this->input->post('confirm_password'));
    
            if (empty($new_password) || empty($confirm_password)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'New password and confirm password are required.'
                ]);
                return;
            }
    
            if ($new_password !== $confirm_password) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Passwords do not match.'
                ]);
                return;
            }
    
            // Get the email of the user whose password is being updated
            $email = $this->input->post('email');
    
            // Get the logged-in user's type from the session
            $logged_in_user_type_id = $this->utility->get_user_id('email');
    
            // Check if the logged-in user has permission to update the password
            if ($this->utility->check_permission($logged_in_user_type_id, $email)) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'You do not have permission to update this user\'s password.'
                ]);
                return;
            }
    
            // Hash the new password securely using bcrypt
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    
            $update_response = $this->utility->change_password($email, $hashed_password);
    
            if ($update_response['status_code'] === '0') {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Password updated successfully!'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => $update_response['message']
                ]);
            }
        }
    }
    
    



    public function sign_out()
    {
        session_destroy();
        redirect('auth');
    }
}