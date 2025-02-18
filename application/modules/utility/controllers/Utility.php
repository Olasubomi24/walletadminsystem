<?php
class Utility extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function call_api2($method, $url, $api_key, $content_type, $data = false)
    {
        $header = array('Content-Type:' . $content_type, 'x-api-key:' . $api_key);
        $curl = curl_init();
        switch ($method) {
            case 'POST':

                curl_setopt($curl, CURLOPT_POST, true);
                if ($data) {

                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'Q_POST':

                curl_setopt($curl, CURLOPT_POST, true);
                if ($data) {
                    $data = http_build_query($data);

                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:

                if ($data) {
                    $url = $url . "/$data";
                }
        }

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $response = 'cURL Error #:' . $err;
        } else {
            $response = $result;
        }
        //print_r( $response );

        return $response;
    }


   
    public function user_login($email, $password)
    {
        // Use parameterized query to prevent SQL injection
        $query = $this->db->select('*')
                          ->from('admins')
                          ->where('email', $email)
                          ->get();
    
        if ($query->num_rows() > 0) {
            // User found, check password
            $user = $query->row(); // Get the first row of the result
    
            // Compare the provided password with the hashed password in the database
            if (password_verify($password, $user->password)) {
                // Password matches, login successful
                $response = [
                    'status_code' => '0',
                    'message' => "Login Successful",
                    'user_details' => $user
                ];
            } else {
                // Password does not match
                $response = [
                    'status_code' => '1',
                    'message' => "Incorrect password"
                ];
            }
        } else {
            // User not found
            $response = [
                'status_code' => '1',
                'message' => "User not found"
            ];
        }
    
        return $response;
    }


    public function user_creation($firstname, $lastname, $username, $email, $password, $user_type_id)
{
    // Prepare the data to be inserted
    $data = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'user_type_id' => $user_type_id
    ];

    // Insert the data into the database
    $this->db->insert('admins', $data);

    if ($this->db->affected_rows() > 0) {
        // Success: User created
        return ['status_code' => 0, 'message' => 'User created successfully'];
    } else {
        // Failure: User creation failed
        return ['status_code' => 1, 'message' => 'Failed to create user'];
    }
}


    
public function change_password($email, $password)
{
    $data = array('password' => $password);
    $this->db->where('email', $email);
    $this->db->update('user_accounts', $data);

    if ($this->db->affected_rows() > 0) {
        $response = array('status_code' => '0', 'message' => 'Password change successful');
    } else {
        $response = array('status_code' => '1', 'message' => 'Incorrect user details or no change made');
    }
    
    return $response;
}
function is_email_exist($email){
    $response = array("status_code" => "0" , "message" => "Email not found");
    $query = $this->db->query("select email from user_accounts where email = '$email'")->result_array();
    if ( sizeof($query ) > 0){
        $response = array("status_code" => "1" , "message" => "Email already exist");  
    }
    return $response;
}

    // Helper function to check permissions
function check_permission($logged_in_user_type_id, $target_email)
    {
        // Fetch the target user's user_type_id
        $query = $this->db->select('user_type_id')
                          ->from('user_accounts')
                          ->where('email', $target_email)
                          ->get();
    
        if ($query->num_rows() === 0) {
            return false; // Target user does not exist
        }
    
        $target_user_type_id = $query->row()->user_type_id;
    
        // Admin (user_type_id = 2) can update any user's password
        if ($logged_in_user_type_id == 2) {
            return true;
        }
    
        // User (user_type_id = 1) can only update their own password or other users' passwords
        if ($logged_in_user_type_id == 1 && $target_user_type_id == 1) {
            return true;
        }
    
        return false; // No permission
    }
    public function reset_password_update($email, $new_password)
{
    $this->db->where('email', $email);
    $this->db->update('user_accounts', ['password' => $new_password]);

    if ($this->db->affected_rows() > 0) {
        return ['status_code' => '0', 'message' => 'Password updated successfully'];
    } else {
        return ['status_code' => '1', 'message' => 'Failed to update password'];
    }
}

public function get_all_funds() {
    return $this->db->get('fund_type')->result_array();
}

public function insert_fund($data) {
    return $this->db->insert('fund_type', $data);
}

public function get_fund_by_id($id) {
    return $this->db->get_where('fund_type', ['id' => $id])->row_array();
}

public function update_fund($id, $data) {
    $this->db->where('id', $id);
    return $this->db->update('fund_type', $data);
}

public function delete_fund($id) {
    return $this->db->delete('fund_type', ['id' => $id]);
}

public function get_user_by_phone($phone) {
    return $this->db->select('username, user_type_id, security_answer')
                    ->where('phonenumber', $phone)
                    ->get('users')
                    ->row_array();
}

// Fetch all fund types
public function get_fund_types() {
    return $this->db->select('id, fundname')
                    ->get('fund_type')
                    ->result_array();
}

// Fetch fund by ID
public function get_funds_by_id($fund_id) {
    return $this->db->select('id, fundname, amount')
                    ->where('id', $fund_id)
                    ->get('fund_type')
                    ->row_array();
}

// Validate security answer
// public function validate_security_answer($phone, $answer) {
//     return $this->db->where('phonenumber', $phone)
//                     ->where('security_answer', $answer)
//                     ->get('users')
//                     ->row_array();
// }

public function validate_security_answer($phone, $answer) {
    // Get user data by phone number
    $user = $this->db->where('phonenumber', $phone)
                     ->get('users')
                     ->row_array();

    // If user exists, verify the security answer
    if ($user && password_verify($answer, $user['security_answer'])) {
        return $user; // Return user data if answer is correct
    }

    // Return false if the answer is invalid or user not found
    return false;
}


// Insert fund transaction
public function insert_customer_wallet($data) {
    return $this->db->insert('customer_wallets', $data);
}

public function get_all_customer_wallets() {
    $this->db->select('customer_wallets.*, users.username, fund_type.fundname');
    $this->db->from('customer_wallets');
    $this->db->join('users', 'users.id = customer_wallets.customer_id', 'left');
    $this->db->join('fund_type', 'fund_type.id = customer_wallets.fund_id', 'left');
    $this->db->order_by('customer_wallets.insert_dt', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
}
    // Get user by phone number
    public function get_user_by_phonenumber($phonenumber)
    {
        $this->db->where('phonenumber', $phonenumber);
        $query = $this->db->get('users');
        
        if ($query->num_rows() > 0) {
            return $query->row(); // Return user data if phonenumber exists
        } else {
            return null; // Return null if phonenumber doesn't exist
        }
    }

    // Update user's security answer
    public function update_user_security($phonenumber, $hashed_answer)
    {
        $this->db->set('security_answer', $hashed_answer);
        $this->db->where('phonenumber', $phonenumber);
        return $this->db->update('users');
    }

}
