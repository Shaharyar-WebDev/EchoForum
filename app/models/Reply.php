<?php
require('../../config/connection.php');

class ThreadReply
{

    private $conn;
    private $response = [
        'status' => '',
        'msg' => ''
    ];

    public function __construct($db)
    {

        $this->conn = $db;
    }

    public function addReply($user_id, $thread_id, $reply)
    {

        if (!isset($user_id)) {

            $response['msg'] = "You Need to login to reply Threads!!";
            $response['status'] = "warning";

            echo json_encode($response);
            return false;
        } else {

            if (!isset($thread_id) || !isset($reply)) {

                $response['msg'] = "Error! Ids cannot be missing";
                $response['status'] = "error";

                echo json_encode($response);
                return false;
            } else if (empty($reply)) {

                $response['msg'] = "Reply Can't Be empty";
                $response['status'] = "warning";

                echo json_encode($response);
                return false;
            } else if (strlen($reply) < 10) {


                $response['msg'] = "Reply Can not be less than 10 characters";
                $response['status'] = "warning";

                echo json_encode($response);
                return false;
            } else {

                $user_id = intval($user_id);
                $thread_id = intval($thread_id);
                $reply = htmlspecialchars($reply);

                $stmt = $this->conn->prepare("INSERT into replies (user_id, thread_id, reply_desc) values (?,?,?)");
                $stmt->bind_param("iis", $user_id, $thread_id, $reply);
                if ($stmt->execute()) {

                    $response['msg'] = "Reply Added Successfully!";
                    $response['status'] = "success";

                    echo json_encode($response);
                    return true;
                }
            }
        };
    }

    public function getReply($thread_id, $sort)
    {

        if (isset($thread_id)) {

            if(!isset($sort) || $sort == 'false'){

                
            $stmt = $this->conn->prepare("SELECT replies.*,
            users.user_name,
            users.avatar,
            count(reply_likes.reply_id) As likes
            FROM replies
            JOIN users
            on  replies.user_id = users.user_id
            LEFT JOIN 
            reply_likes
            on replies.reply_id = reply_likes.reply_id
            WHERE replies.thread_id = ?
            GROUP BY 
            replies.reply_id,
            users.user_name
            ORDER BY reply_id DESC;");
        $stmt->bind_param("i", $thread_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {


            $response['status'] = 'error';
            $response['msg'] = 'No Replies Yet! Add a Reply!!';

            echo json_encode($response);
            return false;
        } else {
            $replies = $result->fetch_all(MYSQLI_ASSOC); 

            foreach ($replies as &$reply) {

                $reply['reply_desc'] = html_entity_decode($reply['reply_desc']);
                $reply['user_name'] = html_entity_decode($reply['user_name']);

            }
            
                $response['data'] = $replies;

                echo json_encode($response);
                return true;
            
        }

            }else {
                
                
            $stmt = $this->conn->prepare("SELECT replies.*,
            users.user_name,
            users.avatar,
            count(reply_likes.reply_id) As likes
            FROM replies
            JOIN users
            on  replies.user_id = users.user_id
            LEFT JOIN 
            reply_likes
            on replies.reply_id = reply_likes.reply_id
            WHERE replies.thread_id = ?
            GROUP BY 
            replies.reply_id,
            users.user_name
            ORDER BY likes DESC;");
        $stmt->bind_param("i", $thread_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {


            $response['status'] = 'error';
            $response['msg'] = 'No Replies Yet! Add a Reply!!';

            echo json_encode($response);
            return false;
        } else {
            $replies = $result->fetch_all(MYSQLI_ASSOC); 

            foreach ($replies as &$reply) {

                $reply['reply_desc'] = html_entity_decode($reply['reply_desc']);
                $reply['user_name'] = html_entity_decode($reply['user_name']);

            }
            
                $response['data'] = $replies;

                echo json_encode($response);
                return true;
            
        }

            }

        } else {

            $response['status'] = 'error';
            $response['msg'] = 'thread_id missing';

            echo json_encode($response);
            return false;
        }
    }


    public function likeReply($user_id, $reply_id)
    {

        if (!isset($user_id) || empty($user_id)) {

            $response['status'] = 'info';
            $response['msg'] = 'you need to log in to Like Replies!';
            echo json_encode($response);

            exit;
        } else if (!isset($reply_id) || empty($reply_id) || !intval($reply_id)) {

            $response['status'] = 'error';
            $response['msg'] = 'An Error Ocurred ! Id Missing';
            echo json_encode($response);

            exit;
        } else {

            $user_id = intval($user_id);
            $reply_id = intval($reply_id);

            $stmt = $this->conn->prepare("SELECT * FROM reply_likes where user_id = ? and reply_id = ?");
            $stmt->bind_param("ii", $user_id, $reply_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->num_rows;

            if ($row > 0) {

                $unlike_stmt = $this->conn->prepare("DELETE FROM reply_likes where user_id = ? and reply_id = ?");
                $unlike_stmt->bind_param("ii", $user_id, $reply_id);
                if ($unlike_stmt->execute()) {

                    $response['status'] = 'warning';
                    $response['msg'] = 'Reply UnLiked Successfully!!';
                }
            } else {

                $like_stmt = $this->conn->prepare("INSERT INTO reply_likes (user_id, reply_id) values (?,?)");
                $like_stmt->bind_param("ii", $user_id, $reply_id);
                if ($like_stmt->execute()) {

                    $response['status'] = 'success';
                    $response['msg'] = 'Reply Liked Successfully!!';
                }
            }

            $count_stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM reply_likes where reply_id = ?");
            $count_stmt->bind_param("i", $reply_id);
            $count_stmt->execute();
            $result = $count_stmt->get_result();
            $row = $result->fetch_assoc();


            $response['data'] = $row['count'];
            echo json_encode($response);
        }
    }
}
