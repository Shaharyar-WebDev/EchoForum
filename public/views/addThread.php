  <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 max-w-3xl">
        
        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-dark">📝 Create a New Thread</h1>

        <!-- Thread Form -->
        <form action="" method="POST" class="add-thread-form bg-white dark:bg-dark-900 p-6 rounded-lg shadow-md mt-4">
            
            <!-- Thread Title -->
            <label class="block font-semibold text-gray-700 dark:text-dark-300">Thread Title</label>
            <input id="title" type="text" name="thread-title" placeholder="Enter a catchy title..."
                class="input input-bordered w-full mt-2" required>

            <!-- Category Selection -->
            <label class="block mt-4 font-semibold text-gray-700 dark:text-dark-300">Category</label>
            <select style="  font-family: 'FontAwesome', 'Second Font name'
" name="category" id="category" class="select select-bordered w-full mt-2" required>
                <option value="" disabled selected>Choose a category</option>
                <?php
                $stmt = $conn->prepare("SELECT * FROM categories");
                $stmt->execute();
                $result = $stmt->get_result();
                while($category = $result->fetch_assoc()){

                    echo "<option value='$category[cat_id]'>&#x$category[icon_unicode]; $category[cat_name]</option>";

                }
                
                ?>
            </select>

            <!-- Thread Content -->
            <label class="block mt-4 font-semibold text-gray-700 dark:text-dark-300">Content</label>
            <textarea name="content" id="content" class="textarea textarea-bordered w-full mt-2" rows="6" placeholder="Write your discussion..." required></textarea>

            <!-- Optional Image Upload -->
            <label class="block mt-4 font-semibold text-gray-700 dark:text-dark-300">Attach Image (Optional)</label>
            <input type="file" name="image" class="file-input file-input-bordered w-full mt-2">

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-6 w-full">🚀 Post Thread</button>

        </form>
    </main>

