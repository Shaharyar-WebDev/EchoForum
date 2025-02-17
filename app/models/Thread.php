<?php

class Thread
{

    private $conn;

    private $response = [
        'status' => 'error',
        'msg' => '',
        'error' => '',
        'data' => []
    ];

    public function __construct($db)
    {

        $this->conn = $db;
    }


    public function addThread($user_id, $category_id, $title, $content, $image)
    {

        if (!isset($user_id)) {

            $this->response['status'] = 'info';
            $this->response['msg'] = 'User ID is required, Please login to continue';
            echo json_encode($this->response);
            return false;
        } else {
            if (empty($title) || empty($content) || empty($user_id) || empty($category_id)) {

                $this->response['status'] = 'error';
                $this->response['msg'] = 'Title, Category and Content cannot be empty';
                echo json_encode($this->response);
                return false;
            } else if(strlen($title) > 100 || strlen($title) < 10){

                $this->response['status'] = 'warning';
                $this->response['msg'] = "Title Should be minimum 10 and max 100 characters";
                echo json_encode($this->response);
                return false;

            } else if(strlen($content) > 500 || strlen($content) < 10) {
                
                $this->response['status'] = 'warning';
                $this->response['msg'] = "Content Should be minimum 10 and max 500 characters";
                echo json_encode($this->response);
                return false;

            }else{
                if (!empty($image)) {

                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                    $type = 'tp';
                    $image_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                    $image_size = filesize($image['tmp_name']);
                    $image_path = $image['tmp_name'];

                    if (!in_array($image_ext, $allowed_ext)) {

                        $this->response['status'] = 'warning';
                        $this->response['msg'] = 'Invalid image format, only jpg, jpeg, png and gif allowed';
                        echo json_encode($this->response);
                        return false;
                    } else {

                        if ($image_size > 3000000) {

                            $this->response['status'] = 'warning';
                            $this->response['msg'] = 'File Size is too large, max 3mb allowed';
                            echo json_encode($this->response);
                            return false;
                        } else {

                            $image_name = $user_id . '_' . $type  . '_' . date('ymdHi') . '_' . substr(bin2hex(random_bytes(2)), 0, 4) . '.' . $image_ext;
                            $target_path = '../../public/uploads/threadPosts/' . $image_name;

                            $user_id = intval($user_id);
                            $category_id = intval($category_id);
                            $valid_title =  htmlspecialchars(trim($title));
                            $valid_content = htmlspecialchars(trim($content));

                            $stmt = $this->conn->prepare("INSERT INTO threads (user_id, cat_id, thread_title, thread_description, thread_image) VALUES (?,?,?,?,?)");
                            $stmt->bind_param("iisss", $user_id, $category_id, $valid_title, $valid_content,  $image_name);
                            if ($stmt->execute() && move_uploaded_file($image_path, $target_path)) {

                                $this->response['status'] = 'success';
                                $this->response['msg'] = 'Thread and image added successfully';
                                echo json_encode($this->response);
                                return true;
                            } else {

                                $this->response['status'] = 'error';
                                $this->response['msg'] = 'Error adding Thread, File upload failed' . $stmt->error;
                                echo json_encode($this->response);
                                return false;
                            }
                        }
                    }
                } else {
                        
                    $user_id = intval($user_id);
                    $category_id = intval($category_id);
                    $valid_title = htmlspecialchars(trim($title));
                    $valid_content = htmlspecialchars(trim($content));

                    $stmt = $this->conn->prepare("INSERT INTO threads (user_id, cat_id, thread_title, thread_description) VALUES (?,?,?,?)");
                    $stmt->bind_param("iiss", $user_id, $category_id, $valid_title, $valid_content);
                    if ($stmt->execute()) {

                        $this->response['status'] = 'success';
                        $this->response['msg'] = 'Thread added successfully';
                        echo json_encode($this->response);
                        return true;
                    } else {

                        $this->response['status'] = 'error';
                        $this->response['msg'] = 'Error adding Thread' . $stmt->error;
                        echo json_encode($this->response);
                        return false;
                    }
                }
            }
        }
    }

    public function getThread($thread_id, $category_id, $sort, $search)
    {

        if (isset($thread_id)) {

            $thread_id = intval($thread_id);

            $stmt = $this->conn->prepare("SELECT 
    threads.*,
    categories.color,
    categories.cat_name,
    users.user_name,
    users.avatar,
    (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
    (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
    (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
FROM threads
JOIN categories ON threads.cat_id = categories.cat_id
JOIN users ON threads.user_id = users.user_id
WHERE threads.thread_id = ?
ORDER by thread_id ASC;
");
            $stmt->bind_param("i", $thread_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 0){
 
                $response['status'] = 'error';
                $response['msg'] = 'No Threads Yet, Start Discussion!!';

                echo json_encode($response);
                return false;

            }else{

            $thread = $result->fetch_all(MYSQLI_ASSOC) ;

                foreach($thread as &$th){

                    $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                    $th['thread_title'] = html_entity_decode(  $th['thread_title']);

                }

                $response['status'] = 'success';
                $response['msg'] = 'All threads fethced successfully';
                $response['data'] = $thread;

                echo json_encode($response);
                return true;
            }
    
        } else if (isset($category_id) && !empty($category_id)) {

            $category_id = intval($category_id);

            $stmt = $this->conn->prepare("SELECT 
    threads.*,
    categories.color,
    categories.cat_name,
    users.user_name,
    users.avatar,
    (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
    (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
    (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
FROM threads
JOIN categories ON threads.cat_id = categories.cat_id
JOIN users ON threads.user_id = users.user_id
WHERE threads.cat_id = ?
ORDER by thread_id DESC;");
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 0){

                
                $response['status'] = 'error';
                $response['msg'] = 'No Threads Yet, Start Discussion!!';

                echo json_encode($response);
                return false;

            }else{

            $thread = $result->fetch_all(MYSQLI_ASSOC);

            foreach($thread as &$th){

                $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                $th['thread_title'] = html_entity_decode(  $th['thread_title']);

            }

                $response['status'] = 'success';
                $response['msg'] = 'All threads fethced successfully';
                $response['data'] = $thread;

                echo json_encode($response);
                return true;
            
        }
        } else if(isset($search) && !empty($search)){

            $stmt = $this->conn->prepare("SELECT 
                threads.*,
                categories.color,
                categories.cat_name,
                users.user_name,
                users.avatar,
                (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
                (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
                (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
            FROM threads
            JOIN categories ON threads.cat_id = categories.cat_id
            JOIN users ON threads.user_id = users.user_id
            WHERE thread_title LIKE ?   OR thread_description LIKE  ?  OR user_name LIKE ? OR cat_name LIKE ? 
            ORDER by thread_id DESC;");
            $searchTerm = '%'. $search. '%';
                        $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
                        $stmt->execute();
                        $result = $stmt->get_result();
            
                        
            if($result->num_rows == 0){
 
                $response['status'] = 'error';
                $response['msg'] = 'No thread Matches Search';

                echo json_encode($response);
                return false;

            }else{
            
                        $thread = $result->fetch_all(MYSQLI_ASSOC);
            
                        foreach($thread as &$th){

                            $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                            $th['thread_title'] = html_entity_decode(  $th['thread_title']);
        
                        }
                        
                            $response['status'] = 'success';
                            $response['msg'] = 'All threads fethced successfully';
                            $response['data'] = $thread;
            
                            echo json_encode($response);
                            return true;

            }

        } 
        else if (isset($category_id) && isset($thread_id) && !empty($category_id)) {

            $thread_id = intval($thread_id);
            $category_id = intval($category_id);

            $stmt = $this->conn->prepare("SELECT 
    threads.*,
    categories.color,
    categories.cat_name,
    users.user_name,
    users.avatar,
    (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
    (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
    (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
FROM threads
JOIN categories ON threads.cat_id = categories.cat_id
JOIN users ON threads.user_id = users.user_id
WHERE threads.thread_id = ? threads.cat_id = ?
ORDER by thread_id ASC;");
            $stmt->bind_param("i", $thread_id, $category_id);
            $stmt->execute();
            $result = $stmt->get_result();


            $thread = $result->fetch_all(MYSQLI_ASSOC);

            foreach($thread as &$th){

                $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                $th['thread_title'] = html_entity_decode(  $th['thread_title']);

            }
                $response['status'] = 'success';
                $response['msg'] = 'All threads fethced successfully';
                $response['data'] = $thread;

                echo json_encode($response);
                return true;
            
        } else {
            if($sort !== true){

                $stmt = $this->conn->prepare("SELECT 
                threads.*,
                categories.color,
                categories.cat_name,
                users.user_name,
                users.avatar,
                (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
                (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
                (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
            FROM threads
            JOIN categories ON threads.cat_id = categories.cat_id
            JOIN users ON threads.user_id = users.user_id
            ORDER by thread_id DESC;");
                        $stmt->execute();
                        $result = $stmt->get_result();
            
            
            if($result->num_rows == 0){
 
                $response['status'] = 'error';
                $response['msg'] = 'No Threads Yet, Start Discussion!!';

                echo json_encode($response);
                return false;

            }else{
            
                        $thread = $result->fetch_all(MYSQLI_ASSOC);
            
                        foreach($thread as &$th){

                            $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                            $th['thread_title'] = html_entity_decode(  $th['thread_title']);
        
                        }
                        
                            $response['status'] = 'success';
                            $response['msg'] = 'All threads fethced successfully';
                            $response['data'] = $thread;
            
                            echo json_encode($response);
                            return true;

            }
                        

            }else{
                $stmt = $this->conn->prepare("SELECT 
                threads.*,
                categories.color,
                categories.cat_name,
                users.user_name,
                users.avatar,
                (SELECT COUNT(*) FROM views WHERE thread_id = threads.thread_id) AS views,
                (SELECT COUNT(*) FROM replies WHERE thread_id = threads.thread_id) AS replies,
                (SELECT COUNT(*) FROM thread_likes WHERE thread_id = threads.thread_id) AS likes
            FROM threads
            JOIN categories ON threads.cat_id = categories.cat_id
            JOIN users ON threads.user_id = users.user_id
            ORDER by likes DESC;");
                        $stmt->execute();
                        $result = $stmt->get_result();
            
            
            if($result->num_rows == 0){
 
                $response['status'] = 'error';
                $response['msg'] = 'No Threads Yet, Start Discussion!!';

                echo json_encode($response);
                return false;

            }else{
            
                        $thread = $result->fetch_all(MYSQLI_ASSOC);
            
                          foreach($thread as &$th){

                    $th['thread_description'] = html_entity_decode(  $th['thread_description']);
                    $th['thread_title'] = html_entity_decode(  $th['thread_title']);

                }
                            $response['status'] = 'success';
                            $response['msg'] = 'All threads fethced successfully';
                            $response['data'] = $thread;
            
                            echo json_encode($response);
                            return true;

            }
                        
            }
        }
    }

    public function likeThread($user_id, $thread_id)
    {

        if (!isset($user_id) || empty($user_id)) {

            $response['status'] = 'info';
            $response['msg'] = 'you need to log in to Like Threads!';
            echo json_encode($response);

            exit;
        } else if (!isset($thread_id) || empty($thread_id) || !intval($thread_id)) {

            $response['status'] = 'error';
            $response['msg'] = 'An Error Ocurred ! Id Missing';
            echo json_encode($response);

            exit;
        } else {

            $user_id = intval($user_id);
            $thread_id = intval($thread_id);

            $stmt = $this->conn->prepare("SELECT * FROM thread_likes where user_id = ? and thread_id = ?");
            $stmt->bind_param("ii", $user_id, $thread_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->num_rows;

            if ($row > 0) {

                $unlike_stmt = $this->conn->prepare("DELETE FROM thread_likes where user_id = ? and thread_id = ?");
                $unlike_stmt->bind_param("ii", $user_id, $thread_id);
                if ($unlike_stmt->execute()) {

                    $response['status'] = 'warning';
                    $response['msg'] = 'UnLiked Successfully!!';
                }
            } else {

                $like_stmt = $this->conn->prepare("INSERT INTO thread_likes (user_id, thread_id) values (?,?)");
                $like_stmt->bind_param("ii", $user_id, $thread_id);
                if ($like_stmt->execute()) {

                    $response['status'] = 'success';
                    $response['msg'] = 'Liked Successfully!!';
                }
            }

            $count_stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM thread_likes where thread_id = ?");
            $count_stmt->bind_param("i", $thread_id);
            $count_stmt->execute();
            $result = $count_stmt->get_result();
            $row = $result->fetch_assoc();


            $response['data'] = $row['count'];
            echo json_encode($response);
        }
    }

    public function viewThread($user_ip, $thread_id){

        if(!isset($user_ip) || !isset($thread_id)){

            
            $response['status'] = 'error';
            $response['msg'] = 'AN ERROR OCURRED! ID MISSING';
            echo json_encode($response);

            exit;

        }else{
        $thread_id = intval($thread_id);

        $stmt = $this->conn->prepare("SELECT * FROM views WHERE user_ip = ? and thread_id = ? ");
        $stmt->bind_param("si", $user_ip, $thread_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->num_rows;

        if($row > 0){

        $response['status'] = 'info';
        $response['msg'] = 'View EXIST';
        echo json_encode($response);

        exit;

        }else{

            $add_view_stmt = $this->conn->prepare("INSERT INTO views (user_ip, thread_id) VALUES (?,?)");
            $add_view_stmt->bind_param("si", $user_ip, $thread_id);
            if($add_view_stmt->execute()){

                $response['status'] = 'success';
                $response['msg'] = 'View Added successfully';
                echo json_encode($response);

                exit;

            };

        }
    }
    }
}
?>