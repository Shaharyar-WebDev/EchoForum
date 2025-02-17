<!-- Category Tabs with Fixed Hover Dropdown -->
<div class="w-full flex justify-center mt-4 z-10">
    <div class="tabs tabs-boxed flex space-x-4 relative z-10">
        <a id='latest' data-value='' data-category-id=''
        class="tab tab-active">🔥 Trending</a>
        <a id='category-link'  data-value='0' data-category-id='0' class="tab">📢 Latest</a>

        <!-- Categories Dropdown -->
        <div class="relative group">
            <!-- Button -->
            <a class="tab flex items-center cursor-pointer group">
                📂 Categories <i class="fas fa-chevron-down ml-1"></i>
            </a>

            <!-- Dropdown Menu -->
            <div id="category-dropdown" class="absolute left-0 w-40 w-lg-60 w-sm-96 w-md-96 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-2 mt-2 
                opacity-0 scale-95 transform origin-top transition-all duration-200 ease-in-out invisible 
                group-hover:visible group-hover:opacity-100 group-hover:scale-100">
                <!-- <a href="#" id='category-link' data-value='0' data-category-id='0' class="block p-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">All</a> -->

                <?php
                
                try {

                    $stmt = $conn->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($cat = $result->fetch_assoc()) {

                        $category_link = " <a href='#' id='category-link' data-value='$cat[cat_id]' data-category-id ='$cat[cat_id]' class='flex justify-canter items-center gap-2 p-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md'><i class='$cat[icon]'></i>$cat[cat_name]</a>";

                        echo $category_link;
                    }
                } catch (Exception $e) {

                    error_log($e->getMessage());

                    echo 'An Error Occurred';;
                }

                ?>
            </div>
        </div>
    </div>
</div>



<!-- Main Content - Thread List -->
<main class="container mx-auto px-4 py-6  max-w-3xl min-h-screen">
    <h2 id="thread-heading" class="text-2xl font-bold mb-4">🔥 Trending Discussions</h2>

    <div id="thread-container" class="space-y-4 flex flex-col justify-center min-h-[36vh]">

        <?php
 $stmt = $conn->prepare("SELECT 
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

        while($thread = $result->fetch_assoc()){

            echo"<div class='bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition border border-gray-300' id='card' data-thread_id='2'>
            <div class='flex justify-between items-center'>
            <p class='flex justify-center items-center gap-2 text-gray-600 dark:text-gray-400 text-sm mt-2'>
            <img class='h-10 w-10 rounded-full object-cover' src='http://echoforum.free.nf/EchoForum/public/uploads/avatars/$thread[avatar]'>
            <a class='text-primary' href='.?page=profile&amp;user=$thread[user_id]'>$thread[user_name]</a><span>. $thread[replies] replies</span><span>. $thread[views] views</span></p>
            <span class='badge' style='background-color: rgb(0, 123, 255);'>$thread[cat_name]</span>
            </div>
            <h3 class='text-lg font-semibold'>$thread[thread_title]</h3>
            <div class='mt-3 flex justify-between items-center'>
            <div class='flex space-x-2'>
            <a href='.?page=thread&amp;thread_id=$thread[thread_id]'>
            <button class='btn btn-outline btn-sm'>👁️ View Thread</button></a>
            <button class='btn btn-outline btn-primary btn-sm flex items-center space-x-1' data-thread_id='$thread[thread_id]'><i class='fas fa-thumbs-up'></i><span>$thread[likes]</span></button>
            </div>
            <span>$thread[created_at]</span>
            </div>
            </div>";

        }

        ?>


        <span style="left: 50%;" class="loading loading-spinner text-primary fixed"></span>

        <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md transition-opacity duration-300 ease-in-out">
            <strong class="font-bold">Error:</strong>
            <span class="block sm:inline" id="error-text">Something went wrong! Please try again.</span>
        </div>


        <!-- Sample Thread Card
            <div id="card" class="bg-white dark:bg-light-800 p-4 rounded-lg shadow hover:shadow-lg transition">
         
                <div class="flex justify-between">
                <p class="flex justify-center items-center gap-2 text-gray-600 dark:text-gray-400 text-sm mt-2">
                <img src="http://localhost/echoforum/public/uploads/avatars/admin.png" alt="" class="h-10 w-10">
                   <a href="profile.php" class="text-primary">JohnDoe</a>
                   <span> • 5 replies </span><span•>• 120 views</span•>
                </p>
                    <span class="badge badge-primary">Web Development</span>
                </div>
                <h3 class="text-lg font-semibold">How to use Tailwind CSS effectively?</h3>
                <div class="image-section">
                <a href="#" onclick="showImg()" id="view-image-btn" class="text-primary" style="text-decoration: underline;">View Image ↓ </a>
                <img id="upload" style="display: none; transition: 0.3s;" src="http://localhost/echoforum/public/uploads/1_tp_2502081753_d659.png" alt="" class="w-full h-auto object-cover mt-2 rounded-lg">
                </div>
                <div class="mt-3 flex justify-between items-center">
                    <div class="flex space-x-2">
                    <a href=".?page=thread"><button class="btn btn-outline btn-sm" >👁️ View Thread</button></a>
                    <button class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
                    <i class="fas fa-thumbs-up"></i>
                    <span>12</span>
                </button>
                    </div>
                    <span class="text-xs text-gray-500">Last reply: 2 hours ago</span>
                </div>
            </div> -->

    </div>
    </div>
</main>