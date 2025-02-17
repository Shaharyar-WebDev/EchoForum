    <?php 
require("../config/connection.php");

  $stmt = $conn->prepare(
    "SELECT users.*, 
        (SELECT COUNT(*) FROM threads WHERE threads.user_id = users.user_id) AS threads,
        (SELECT COUNT(*) FROM replies WHERE replies.user_id = users.user_id) AS replies,
        (SELECT COUNT(*) FROM reply_likes WHERE reply_likes.user_id = users.user_id) AS reply_likes,
        (SELECT COUNT(*) FROM thread_likes WHERE thread_likes.user_id = users.user_id) AS thread_likes
     FROM users
     WHERE users.user_id = ?"
);
$stmt->bind_param("i", $_GET['user']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($result->num_rows > 0): ?>


 <!-- Main Content -->
 <main class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-dark-900 p-6 rounded-lg shadow-md hover:shadow-xl flex flex-col justify-evenly items-center border border-gray-300 transition min-h-[70vh]">

<?php if(isset($_SESSION['user_id']) && $user['user_id'] == $_SESSION['user_id']): ?>

  <div class="flex flex-col justify-center items-center gap-2">
  <div id="avatar" class="avatar cursor-pointer">
  <div class="mask mask-hexagon w-32">
  <img src="http://echoforum.free.nf/EchoForum/public/uploads/avatars/<?php echo $user['avatar'] ?>" alt="User Avatar" class="userImg w-full h-full object-cover">
</div>
  </div>
  <div class="flex gap-2">
  <form class="profilePicInput" action="">
  <input id="profilePic" type="file" name="image" class="file-input file-input-bordered w-28 transition"  placeholder="Choose Profile pic" required>
  <div class="tooltip tooltip-bottom" data-tip="Update">
  <button id="profileUpdateBtn" class="btn btn-outline btn-primary  items-center space-x-1" type="submit"><i class="fas fa-edit"></i></button>
  </div>
  </form>
</div>
</div>
       <div class="flex justify-center items-center gap-1">
       <h1 id="usernameDisplay" class="text-3xl font-bold text-gray-800 dark:text-dark"><?php echo htmlspecialchars(html_entity_decode($user['user_name'])) ?></h1>
        <input type="text" id="usernameInput" class="text-3xl font-bold min-w-32 max-w-48" value="<?php echo htmlspecialchars(html_entity_decode($user['user_name'])) ?>" style="display: none;">
        <div class="tooltip tooltip-bottom" data-tip="Edit">
        <button id="editButton" class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
        <i class="fas fa-edit"></i>
        </button>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="Save">
        <button id="saveButton"  style="display: none;" class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
        <i class="fas fa-download"></i>
        </button>
        </div>
       </div>
      
       <div class="flex justify-center items-center gap-2">
       <p id="bioDisplay" class="mt-2 text-gray-600 dark:text-dark-400 text-center max-w-md"><?php echo htmlspecialchars(html_entity_decode($user['bio'])) ?></p>
        <textarea id="bioInput" id="bioInput" class="font-bold textarea textarea-bordered w-[480px] mt-2 border border-gray-400" value="<?php echo htmlspecialchars(html_entity_decode($_SESSION['bio'])) ?>" style="display: none;"><?php echo htmlspecialchars(html_entity_decode($user['bio'])) ?></textarea>
        <div class="tooltip tooltip-bottom" data-tip="Edit">
        <button id="editBioButton" class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
        <i class="fas fa-edit"></i>
        </button>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="Save">
        <button id="saveBioButton"  style="display: none;" class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
        <i class="fas fa-download"></i>
        </button>
        </div>
       </div>
      
      <div class="mt-4 flex space-x-8">
      <div class="text-center">
          <span id="threadsShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['threads'] ?></span>
          <p class="text-sm text-gray-500">Threads</p>
        </div>
        <div class="text-center">
          <span id="repliesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['replies'] ?></span>
          <p class="text-sm text-gray-500">Replies</p>
        </div>
        <div class="text-center">
          <span id="treadLikesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['thread_likes'] ?></span>
          <p class="text-sm text-gray-500">Thread likes</p>
        </div>
        <div class="text-center">
          <span id="replyLikesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['reply_likes'] ?></span>
          <p class="text-sm text-gray-500">Reply likes</p>
        </div>
      </div>
    </div>

    <?php else: ?>

      <div class="avatar">
  <div class="mask mask-rounded-full w-32">
  <img src="http://echoforum.free.nf/EchoForum/public/uploads/avatars/<?php echo $user['avatar'] ?>" alt="User Avatar" class="userImg w-full h-full object-cover">
  </div>
</div>
      <h1 id="usernameDisplay" class="text-3xl font-bold text-gray-800 dark:text-dark"><?php echo htmlspecialchars(html_entity_decode($user['user_name'])) ?></h1>
      <p id="bioDisplay" class="mt-2 text-gray-600 dark:text-dark-400 text-center max-w-md"><?php echo htmlspecialchars(html_entity_decode($user['bio'])) ?></p>
      <div class="mt-4 flex space-x-8">
      <div class="text-center">
          <span id="threadsShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['threads'] ?></span>
          <p class="text-sm text-gray-500">Threads</p>
        </div>
        <div class="text-center">
          <span id="repliesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['replies'] ?></span>
          <p class="text-sm text-gray-500">Replies</p>
        </div>
        <div class="text-center">
          <span id="treadLikesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['thread_likes'] ?></span>
          <p class="text-sm text-gray-500">Thread likes</p>
        </div>
        <div class="text-center">
          <span id="replyLikesShow" class="text-2xl font-semibold text-gray-800 dark:text-dark"><?php echo $user['reply_likes'] ?></span>
          <p class="text-sm text-gray-500">Reply likes</p>
        </div>
        </div>  

      <?php endif ?>

      </div>
    
    <!-- My Threads Section -->
    <!-- <div class="mt-8">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-dark mb-4">My Threads</h2>
      <div class="space-y-4">
        Sample Thread Card -->
        <!-- <div class="bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition">
                <div class="flex justify-between">
                    <h3 class="text-lg font-semibold">How to use Tailwind CSS effectively?</h3>
                    <span class="badge h-auto badge-primary">Web Development</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-2">
                    Started by <a href="profile.php" class="text-primary">JohnDoe</a> • 5 replies • 120 views
                </p>
                <div class="mt-3 flex justify-between items-center">
                    <div class="flex space-x-2">
                    <a href="thread.php"><button class="btn btn-outline btn-sm" >👁️ View Thread</button></a>
                    <button class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
                    <i class="fas fa-thumbs-up"></i>
                    <span>12</span>
                </button>
                    </div>
                    <span class="text-xs text-gray-500">Last reply: 2 hours ago</span>
                </div>
            </div> -->
        <!-- Additional Thread Cards can be added here -->
      <!-- </div>
    </div> -->
    
    <!-- (Optional) My Replies Section -->
    <!-- You can include another section here for replies if needed -->
    
  </main>


<?php else: ?>
 
  
  <div class="flex flex-col justify-center items-center text-center space-y-6 min-h-[78vh]">
    <h1 class="text-6xl font-extrabold text-red-600">User Not Found</h1>
    <p class="text-lg">
      We couldn’t locate the user you’re looking for. Please check the username or try again later.
    </p>
    <a href="index.php" class="btn btn-error px-6 py-3 text-lg">
      Go Home
    </a>
  </div>


<?php endif  ?>
 
  

