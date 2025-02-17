<?php
require("../../config/connection.php");
class User
{
    private $conn; // Database connection

    public $response = [
        'status' => 'error',
        'msg' => '',
        'redirect' => ''
    ];

    private $valid_username;
    private $valid_email;
    private $valid_password;
    private $target_path;

    private $image_path;

    private $valid_image;

    public function __construct($db)
    {
        $this->conn = $db; // Initialize the database connection
    }

    private function validateUsername($username)
    {
        // Check if username is empty or not within the length limits
        if (empty($username) || strlen($username) < 4 || strlen($username) > 20) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Username must be between 4 and 20 characters';
            echo json_encode($this->response);
            return false;
        } else {
            // Check if username contains only valid characters
            if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = "Only a-z, A-Z, 0-9 and underscores are allowed in username";
                echo json_encode($this->response);
                return false;
            } else {
                // Prepare and execute the SQL statement
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_name = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result(); // Get the result set

                // Check if the username already exists
                if ($result->num_rows > 0) {
                    $this->response['status'] = 'warning';
                    $this->response['msg'] = 'Username already exists';
                    echo json_encode($this->response);
                    return false;
                } else {
                    // Sanitize the username
                    $this->valid_username = htmlspecialchars(strip_tags(trim($username)));
                    // $this->response['status'] = 'success';
                    // $this->response['msg'] = 'Success, Username Valid';
                    // echo json_encode($this->response); 
                    return true;
                }
            }
        }
    }

    private function validateUsernameInput($username)
    {
        // Check if username is empty or not within the length limits
        if (empty($username) || strlen($username) < 4 || strlen($username) > 20) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Username must be between 4 and 20 characters';
            echo json_encode($this->response);
            return false;
        } else {
            // Check if username contains only valid characters
            if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = "Only a-z, A-Z, 0-9 and underscores are allowed in username";
                echo json_encode($this->response);
                return false;
            } else {

                // Sanitize the username
                $this->valid_username = htmlspecialchars(strip_tags(trim($username)));
                // $this->response['status'] = 'success';
                // $this->response['msg'] = 'Success, Username Valid';
                // echo json_encode($this->response); 
                return true;
            }
        }
    }
    private function validateEmail($email)
    {

        if (empty($email)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'email can not be empty';
            echo json_encode($this->response);
            return false;
        } else {

            $Sanitized_email = filter_var(htmlspecialchars(strip_tags(trim($email))), FILTER_SANITIZE_EMAIL);

            if (!filter_var($Sanitized_email, FILTER_VALIDATE_EMAIL)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'invalid email';
                echo json_encode($this->response);
                return false;
            } else {
                $valid_email = filter_var($Sanitized_email, FILTER_VALIDATE_EMAIL);

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $valid_email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {

                    $this->response['status'] = 'warning';
                    $this->response['msg'] = 'Email already exists';
                    echo json_encode($this->response);
                    return false;
                } else {
                    $this->valid_email = $valid_email;
                    // $this->response['status'] = 'success';
                    // $this->response['msg'] = 'Success, Email Valid and is unique';
                    // echo json_encode($this->response); 
                    return true;
                }
            }
        }
    }

    private function validateEmailInput($email)
    {

        if (empty($email)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'email can not be empty';
            echo json_encode($this->response);
            return false;
        } else {

            $Sanitized_email = filter_var(htmlspecialchars(strip_tags(trim($email))), FILTER_SANITIZE_EMAIL);

            if (!filter_var($Sanitized_email, FILTER_VALIDATE_EMAIL)) {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'invalid email';
                echo json_encode($this->response);
                return false;
            } else {

                $this->valid_email = filter_var($Sanitized_email, FILTER_VALIDATE_EMAIL);

                return true;
            }
        }
    }

    private function validatePass($password, $confirm_password)
    {

        if (empty($password) || strlen($password) < 4) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Password must be at least 4 characters';
            echo json_encode($this->response);
            return false;
        } else if ($password !== $confirm_password) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'Confirm password doesnt match';
            echo json_encode($this->response);
            return false;
        } else {
            $this->valid_password = password_hash($password, PASSWORD_DEFAULT);
            //  $this->response['status'] = 'success';
            // $this->response['msg'] = 'Success, valid password';
            // echo json_encode($this->response); 
            return true;
        }
    }

    public function register($user, $email, $password, $confirm_password)
    {
        if ($this->validateUsername($user) && $this->validateEmail($email) && $this->validatePass($password, $confirm_password)) {

            $create_user = "INSERT INTO users (user_name, email, password) Values (?,?,?)";
            $stmt = $this->conn->prepare($create_user);
            $stmt->bind_param("sss", $this->valid_username, $this->valid_email, $this->valid_password);


            if ($stmt->execute()) {

                $this->response['status'] = 'success';
                $this->response['msg'] = 'Success, User Registered Successfully!';
                echo json_encode($this->response);

                return true;
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = "Error in registration!" . $stmt->error;
                echo json_encode($this->response);

                return false; // Registration failed
            }
        };
    }

    public function login($email, $password)
    {

        $sanitized_email = filter_var(htmlspecialchars(strip_tags(trim($email))), FILTER_SANITIZE_EMAIL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $this->response['status'] = 'error';
            $this->response['msg'] = 'Invalid email';
            echo json_encode($this->response);
            return false;
        } else {

            $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);

            $stmt = $this->conn->prepare('SELECT * FROM users WHERE email = ?');
            $stmt->bind_param("s", $valid_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result->num_rows > 0) {

                $this->response['status'] = 'error';
                $this->response['msg'] = 'email not found, Please Register';
                echo json_encode($this->response);
                return false;
            } else {

                $login_user = $result->fetch_assoc();

                if (!password_verify($password, $login_user['password'])) {

                    $this->response['status'] = 'error';
                    $this->response['msg'] = 'Incorrect password!';
                    echo json_encode($this->response);
                    return false;
                } else {

                    session_start();

                    $_SESSION['user_id'] = $login_user['user_id'];
                    $_SESSION['bio'] = $login_user['bio'];
                    $_SESSION['user_name'] = $login_user['user_name'];
                    $_SESSION['email'] = $login_user['email'];
                    $_SESSION['role'] = $login_user['role'];
                    $_SESSION['avatar'] = $login_user['avatar'];

                    $this->response['status'] = 'success';
                    $this->response['msg'] = 'Login Successfull! Redirecting...';
                    $this->response['redirect'] = '../../';
                    echo json_encode($this->response);
                    return true;
                }
            }
        }
    }

    public function getUser($user_id)
    {
        // Use the passed user_id and convert it to int
        $user_id = intval($user_id);

        if (empty($user_id)) {
            $this->response['status'] = 'error';
            $this->response['msg'] = 'User id did not exist';
            echo json_encode($this->response);
            return false;
        } else {
            $stmt = $this->conn->prepare(
                "SELECT users.*, 
                    (SELECT COUNT(*) FROM threads WHERE threads.user_id = users.user_id) AS threads,
                    (SELECT COUNT(*) FROM replies WHERE replies.user_id = users.user_id) AS replies,
                    (SELECT COUNT(*) FROM reply_likes WHERE reply_likes.user_id = users.user_id) AS reply_likes,
                    (SELECT COUNT(*) FROM thread_likes WHERE thread_likes.user_id = users.user_id) AS thread_likes
                 FROM users
                 WHERE users.user_id = ?"
            );
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                $user["bio"] = html_entity_decode($user["bio"]);
                $this->response['status'] = 'success';
                $this->response['msg'] = 'User exists';
                $this->response['data'] = $user;
                echo json_encode($this->response);

                return true;
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'User not found';
                echo json_encode($this->response);
                return false;
            }
        }
    }

    public function getAllUsers($page)
    {
        // Use the passed user_id and convert it to int

        if(!isset($page)){

            $stmt = $this->conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                while ($user = $result->fetch_assoc()) {
    
                    $user["bio"] = html_entity_decode($user["bio"]);
                    $this->response['data'][] = $user;
                }
    
    
                $this->response['status'] = 'success';
                $this->response['msg'] = 'User exists';
                $this->response['records'] = $result->num_rows;
    
                echo json_encode($this->response);
    
                return true;
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'User not found';
                echo json_encode($this->response);
                return false;
            }

        }else{

            $page = intval($page);
            $records_per_page = 5;
            $start = $page - 1;
            $offset = $start * $records_per_page;
            $limit = $records_per_page;
            
            $stmt = $this->conn->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->get_result();

            $no_of_pages = ceil($result->num_rows/$records_per_page);

            $stmt_limit = $this->conn->prepare("SELECT * FROM users LIMIT ?,?");
            $stmt_limit->bind_param("ii", $offset, $limit);
            $stmt_limit->execute();
            $result_limit = $stmt_limit->get_result();

    
            if ($result_limit->num_rows > 0) {
                while ($user = $result_limit->fetch_assoc()) {
    
                    $user["bio"] = html_entity_decode($user["bio"]);
                    $this->response['data'][] = $user;
                }
    
    
                $this->response['status'] = 'success';
                $this->response['msg'] = 'User exists';
                $this->response['records'] = $result_limit->num_rows;
                $this->response['pagination'] = $no_of_pages;
    
                echo json_encode($this->response);
    
                return true;
            } else {
                $this->response['status'] = 'error';
                $this->response['msg'] = 'User not found 101';
                echo json_encode($this->response);
                return false;
            }


        }
    
    }


    public function editUser($user_id, $user_name, $bio, $image)
    {

        if (!isset($user_id)) {

            $this->response['status'] = 'info';
            $this->response['msg'] = 'User ID is required, Please login to continue';
            echo json_encode($this->response);
            return false;
        } else {

            if (isset($user_name)) {

                if ($this->validateUsernameInput($user_name)) {

                    $stmt = $this->conn->prepare("Update users set user_name = ? where user_id = ?");
                    $stmt->bind_param("si", $this->valid_username, $user_id);
                    if ($stmt->execute()) {

                        $response['status'] = 'success';
                        $response['msg'] = 'Username Updated Successfully!';
                        echo json_encode($response);

                        exit;
                    };
                };
            };
            if (isset($bio)) {

                if (empty($bio)) {

                    $this->response['status'] = 'warning';
                    $this->response['msg'] = 'Bio cannot be empty';
                    echo json_encode($this->response);
                    return false;
                } else if (strlen($bio) > 220 || strlen($bio) < 10) {

                    $this->response['status'] = 'warning';
                    $this->response['msg'] = "Bio Should be minimum 10 and max 220 characters";
                    echo json_encode($this->response);
                    return false;
                } else {

                    $valid_bio = htmlspecialchars(trim($bio));
                    $stmt = $this->conn->prepare("Update users set bio = ? where user_id = ?");
                    $stmt->bind_param("si", $valid_bio, $user_id);
                    if ($stmt->execute()) {

                        $response['status'] = 'success';
                        $response['msg'] = 'bio Updated Successfully!';
                        echo json_encode($response);

                        exit;
                    };
                }
            };
            if (isset($image)) {

                if (!empty($image)) {

                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                    $type = 'pp';
                    $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                    $image_size = filesize($image['tmp_name']);
                    $image_path = $image['tmp_name'];

                    if (!in_array($image_ext, $allowed_ext)) {

                        $this->response['status'] = 'warning';
                        $this->response['msg'] = 'Invalid image format, only jpg, jpeg, png and gif allowed';
                        echo json_encode($this->response);
                        return false;
                    } else {

                        if ($image_size > 2000000) {

                            $this->response['status'] = 'warning';
                            $this->response['msg'] = 'File Size is too large, max 2mb allowed';
                            echo json_encode($this->response);
                            return false;
                        } else {

                            $image_name = $user_id . '_' . $type  . '_' . date('ymdHi') . '_' . substr(bin2hex(random_bytes(2)), 0, 4) . '.' . $image_ext;
                            $target_path = '../../public/uploads/avatars/' . $image_name;

                            $stmt = $this->conn->prepare("Update users set avatar = ? where user_id = ?");
                            $stmt->bind_param("si", $image_name, $user_id);
                            if ($stmt->execute() && move_uploaded_file($image_path, $target_path)) {

                                $this->response['status'] = 'success';
                                $this->response['msg'] = 'profile pic Updated successfully';
                                echo json_encode($this->response);
                                return true;
                            } else {

                                $this->response['status'] = 'error';
                                $this->response['msg'] = 'Error adding image, File upload failed' . $stmt->error;
                                echo json_encode($this->response);
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }

    public function updateUser($user_id, $image, $username, $email, $role, $bio)
    {

        if (!isset($user_id)) {

            $this->response['status'] = 'warning';
            $this->response['msg'] = 'User ID is required';
            echo json_encode($this->response);
            return false;
        } else if (!isset($username)) {

            $this->response['status'] = 'warning';
            $this->response['msg'] = 'User Name is required';
            echo json_encode($this->response);
            return false;
        } else if (!isset($email)) {

            $this->response['status'] = 'warning';
            $this->response['msg'] = 'Email is required';
            echo json_encode($this->response);
            return false;
        } else if (!isset($role)) {

            $this->response['status'] = 'warning';
            $this->response['msg'] = 'Role is required';
            echo json_encode($this->response);
            return false;
        } else if (!isset($bio)) {

            $this->response['status'] = 'warning';
            $this->response['msg'] = 'Bio is required';
            echo json_encode($this->response);
            return false;
        } else {

            if (!intval($user_id)) {


                $this->response['status'] = 'error';
                $this->response['msg'] = 'Invalid User ID';
                echo json_encode($this->response);
                return false;
            } else if (empty($bio)) {

                $this->response['status'] = 'warning';
                $this->response['msg'] = 'Bio cannot be empty';
                echo json_encode($this->response);
                return false;
            } else if (strlen($bio) > 220 || strlen($bio) < 10) {

                $this->response['status'] = 'warning';
                $this->response['msg'] = "Bio Should be minimum 10 and max 220 characters";
                echo json_encode($this->response);
                return false;
            } else if (!empty($created_At)) {

                $this->response['status'] = 'warning';
                $this->response['msg'] = 'Creation date is necessary';
                echo json_encode($this->response);
                return false;
            } else {

                if (isset($image)) {

                    if (!empty($image)) {

                        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                        $type = 'pp';
                        $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                        $image_size = filesize($image['tmp_name']);
                        $this->image_path = $image['tmp_name'];

                        if (!in_array($image_ext, $allowed_ext)) {

                            $this->response['status'] = 'warning';
                            $this->response['msg'] = 'Invalid image format, only jpg, jpeg, png and gif allowed';
                            echo json_encode($this->response);
                            return false;
                        } else {

                            if ($image_size > 2000000) {

                                $this->response['status'] = 'warning';
                                $this->response['msg'] = 'File Size is too large, max 2mb allowed';
                                echo json_encode($this->response);
                                return false;
                            } else {

                                $image_name = $user_id . '_' . $type  . '_' . date('ymdHi') . '_' . substr(bin2hex(random_bytes(2)), 0, 4) . '.' . $image_ext;
                                $this->target_path = '../../public/uploads/avatars/' . $image_name;

                                $this->valid_image = $image_name;
                                $this->image_path = $image['tmp_name'];
                            }
                        }
                    }
                };

                if ($this->validateUsernameInput($username) && $this->validateEmailInput($email)) {

                    $bio = htmlspecialchars($bio);

                    $stmt = $this->conn->prepare("UPDATE users Set 
        user_id = ?,
        user_name = ?,
        email = ?,
        role = ?,
        bio = ?
        Where user_id = ?");
                    $stmt->bind_param("issisi", $user_id, $this->valid_username, $this->valid_email, $role, $bio, $user_id);
                    if (!isset($image)) {
                        if ($stmt->execute()) {

                            $this->response['status'] = 'success';
                            $this->response['msg'] = 'User Updated successfully';
                            echo json_encode($this->response);
                            return true;
                        } else {

                            $this->response['status'] = 'error';
                            $this->response['msg'] = 'Error Updating User !, An Error Occured' . $stmt->error;
                            echo json_encode($this->response);
                            return false;
                        }
                    } else {

                        $stmt_img = $this->conn->prepare("Update users set avatar = ? where user_id = ?");
                        $stmt_img->bind_param("si", $this->valid_image, $user_id);

                        if ($stmt->execute() && $stmt_img->execute() && move_uploaded_file($this->image_path, $this->target_path)) {

                            $this->response['status'] = 'success';
                            $this->response['msg'] = 'profile pic and User Updated successfully';
                            echo json_encode($this->response);
                            return true;
                        } else {

                            $this->response['status'] = 'error';
                            $this->response['msg'] = 'Error Updating User and image, An Error Occured' . $stmt->error;
                            echo json_encode($this->response);
                            return false;
                        }

                }
            }
            }
        }
    }

    public function deleteUser($user_id)
    {

        if (!isset($user_id)) {

            $this->response['status'] = "error";
            $this->response['msg'] = "Error! User Id missing";
            echo json_encode($this->response);
        } else if (!intval($user_id)) {


            $this->response['status'] = "error";
            $this->response['msg'] = "Error! Invalid User Id";
            echo json_encode($this->response);
        }else if($_SESSION['user_id'] == $user_id){

            
            $this->response['status'] = "error";
            $this->response['msg'] = "You are currently logged in with this account";
            echo json_encode($this->response);

        } else{

            $user_id = intval($user_id);
            $stmt = $this->conn->prepare("DELETE from users where user_id = ?");
            $stmt->bind_param("i", $user_id);
            if ($stmt->execute()) {

                $this->response['status'] = "success";
                $this->response['msg'] = "User Deleted Successfully";
                echo json_encode($this->response);
            } else {

                $this->response['status'] = "error";
                $this->response['msg'] = "Error! Cannot Delete missing";
                echo json_encode($this->response);
            }
        }
    }
};

// $User  = new User($conn); // Pass the database connection to the User class
// echo $User ->register('shery', 'userexample@gmail.com', '1234','1234'); // Test the registration with a username
