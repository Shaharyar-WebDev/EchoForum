 <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 max-w-3xl min-h-[300px]" id="thread-container">
        
    <span style="left: 50%; top: 25%; margin-top: 10px;" class="loading loading-spinner text-primary absolute"></span>

<div id="error-message" style="top: 30%; margin-top: 10px;" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md transition-opacity duration-300 ease-in-out relative">
<strong class="font-bold">Error:</strong>
<span class="block sm:inline" id="error-text">Something went wrong! Please try again.</span>
</div>

        <!-- Thread Header
        <div class="bg-white dark:bg-dark-900 p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex flex-row justify-center items-center gap-2">
            <img src="http://localhost/echoforum/public/uploads/avatars/admin.png" alt="" class="h-10 w-10">
                   <a href="profile.php" class="text-primary">JohnDoe</a>
                <span>•</span>
                <span>2 hours ago</span>
            </div>
            <span class="badge badge-primary">Web Development</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-dark">How to use Tailwind CSS effectively?</h1>
            <div class="mt-2 flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
               
                <span> • 5 replies </span><span>• 120 views</span>
            </div>
        </div>

        Thread Content
        <div class="bg-white dark:bg-dark-900 p-6 rounded-lg shadow-md mt-4">
            <p class="text-gray-700 dark:text-dark-300 mt-2">
                Tailwind CSS is an amazing utility-first framework that helps in building modern web UIs quickly. 
                How do you structure your Tailwind projects for better maintainability?
            </p>
            Like / Upvote Button
            <div class="flex items-center mt-3">
                <button class="btn btn-outline btn-primary btn-sm flex items-center space-x-1">
                    <i class="fas fa-thumbs-up"></i>
                    <span>12</span>
                </button>
            </div>
        </div> -->
        </main>

    <main class="container mx-auto px-4 max-w-3xl min-h-screen">
        <!-- Replies Section -->
         <div class="flex justify-between items-center">

        <h2 class="text-xl font-bold">💬 Replies</h2>

        <div class="tabs tabs-boxed">
        <a id='latest' data-sort='true' data-category-id=''
        class="tab tab-active">🔥 Trending</a>
        <a id='category-link'  data-sort='false' data-category-id='0' class="tab">📢 Latest</a>
        </div>         
         </div>

        <div class="space-y-4 mt-4 pb-[220px]" id="reply-container">

             
    <span style="
    left: 50%;
    top: 25%;
    margin-top: 10px;" class="loading loading-spinner reply-loading text-primary relative"></span>

<div id="reply-error-message" style="top: 30%; margin-top: 10px;" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md transition-opacity duration-300 ease-in-out relative">
<strong class="font-bold">Error:</strong>
<span class="block sm:inline" id="error-text">Something went wrong! Please try again.</span>
</div>

            <!-- Sample Reply -->
            <!-- <div class="bg-white dark:bg-dark-900 p-4 rounded-lg shadow-md">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="uploads/user1.png" alt="User" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="text-gray-800 dark:text-dark font-semibold"><a href="profile.php">JaneDoe</a></p>
                            <p class="text-xs text-dark-500">Replied 1 hour ago</p>
                        </div>
                    </div>
                    Like / Upvote
                    <button class="btn btn-outline btn-sm flex items-center space-x-1">
                        <i class="fas fa-thumbs-up"></i>
                        <span>5</span>
                    </button>
                </div>
                <p class="text-gray-700 dark:text-dark-300 mt-2">
                    I usually create reusable component classes for common UI elements. Also, using JIT mode makes Tailwind even better!
                </p>
            </div> -->

            <!-- Sample Reply -->
            <!-- <div class="bg-white dark:bg-dark-900 p-4 rounded-lg shadow-md">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="uploads/user2.png" alt="User" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="text-gray-800 dark:text-dark font-semibold">TechGuy123</p>
                            <p class="text-xs text-dark-500">Replied 30 minutes ago</p>
                        </div>
                    </div>
                    Like / Upvote
                    <button class="btn btn-outline btn-sm flex items-center space-x-1">
                        <i class="fas fa-thumbs-up"></i>
                        <span>3</span>
                    </button>
                </div>
                <p class="text-gray-700 dark:text-dark-300 mt-2">
                    I use Tailwind with a component-based approach, breaking things down into partials. It keeps things super clean and modular.
                </p>
            </div> -->

        </div>

</main>


  <!-- Floating Reply Box -->
<div class="fixed bottom-[60px] left-1/2 transform -translate-x-1/2 w-full max-w-3xl bg-white dark:bg-dark-900 rounded-lg p-4 shadow hover:shadow-xl transition border border-gray-400">
    <form action="" id="reply-form">
    <h3 class="text-lg font-bold text-dark-800 dark:text-dark-300">✍️ Post a Reply</h3>
    <textarea id="reply-input" name="reply" class="textarea textarea-bordered w-full mt-2 border border-gray-400" placeholder="Write your reply..."></textarea>
    <button id="reply-btn" class="btn btn-primary mt-3 w-full">Reply</button>
    </form>
</div>


