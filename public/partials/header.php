  <!-- Navbar -->
<nav class="sticky top-0 bg-gray-200 border border-gray-300 dark:bg-dark-900 shadow-md p-4 flex justify-between items-center z-50">
    <!-- Left: Logo & Branding -->
    <a href=".?page=home" class="flex items-center">
        <img src="uploads/logo.png" alt="EchoForum Logo" class="h-14 w-auto">
        <span class="text-xl font-bold text-gray-800 dark:text-dark tracking-wide">EchoForum</span>
    </a>
  <!-- CENTER SEARCH BAR -->
    <div class="relative md:max-w-[300px] w-full lg:max-w-lg hidden md:block">
        <input type="text" placeholder="Search threads..." 
            class="input input-bordered w-full pl-10 bg-gray-100 dark:bg-dark-800 text-gray-700 dark:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary transition-all" id="search">
        <i class="fas fa-search absolute left-3 top-4 text-gray-500 dark:text-gray-400"></i>
    </div> 

    <!-- Right: Icons & Profile -->
    <div class="flex items-center space-x-2">
        <!-- Ask a question/ thread -->
        <div class="tooltip tooltip-bottom" data-tip="Add Thread">
         <a href=".?page=addThread">
        <button class="btn btn-ghost btn-circle">
            <i class="fas fa-plus text-lg text-gray-600 dark:text-dark-300"></i>
        </button>
        </a>
        </div>

 <!-- Profile Dropdown (Main) -->
<div class="relative group">
  <!-- Profile Button (trigger for main dropdown on hover) -->
  <div class="flex items-center space-x-2 cursor-pointer group-hover:text-primary">
 <button class="btn btn-ghost btn-circle avatar">
    <div class="w-10 h-10 rounded-full border border-gray-300 dark:border-gray-600 overflow-hidden">
      <?php if(isset($_SESSION['user_id'])): ?>
      <img src="http://echoforum.free.nf/EchoForum/public/uploads/avatars/<?php echo $_SESSION['avatar'] ?>" alt="User" id="userProfile" class="w-full h-full object-cover">
      <?php else: ?>
        <img src="http://echoforum.free.nf/EchoForum/public/uploads/avatars/agent.png" alt="User" class="w-full h-full object-cover">
      <?php endif; ?>
    </div>
  </button>
  <?php if(isset($_SESSION['user_id'])): ?>
      <p id="userProfileName"><?php echo $_SESSION['user_name'] ?></p>
      <?php else: ?>
        <p>Anonymous</p>
      <?php endif; ?>
   </div>
 

  <!-- Main Dropdown: Opens on hover over the profile button -->
  <ul class="absolute right-0 w-48 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-2 transition-opacity duration-300 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto z-[9999]" style="z-index: 99 !important;">

    <?php if(isset($_SESSION['user_id'])): ?>
    <li>
      <a href=".?page=profile" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
        <i class="fas fa-user text-gray-600 dark:text-gray-300"></i>
        <span class="text-gray-700 dark:text-gray-200">Profile</span>
      </a>
    </li>
    <?php endif; ?>

    <!-- Settings with Nested Submenu triggered on click -->
    <li class="relative">
      <a href="#" 
         class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700"
         onclick="toggleSubmenu(event)">
        <i class="fas fa-cog text-gray-600 dark:text-gray-300"></i>
        <span class="text-gray-700 dark:text-gray-200">Preferences</span>
        <i class="fas fa-chevron-left dark:text-gray-300"></i>
      </a>
      <!-- Nested Submenu: Hidden by default -->
      <ul id="settingsSubmenu" class="absolute top-0 right-full mr-3 w-48 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-2 transition-all duration-300 hidden" style="z-index: 100;">
      <li>
      <input
        type="radio"
        name="theme-dropdown"
        class="theme-controller btn btn-sm btn-block btn-ghost justify-start text-white hover:bg-gray-100 dark:hover:bg-gray-700 "
        aria-label="Default"
        value="default" />
    </li>
    <li>
      <input
        type="radio"
        name="theme-dropdown"
        class="theme-controller btn btn-sm btn-block btn-ghost justify-start text-white hover:bg-gray-100 dark:hover:bg-gray-700 "
        aria-label="Retro"
        value="retro" />
    </li>
    <li>
      <input
        type="radio"
        name="theme-dropdown"
        class="theme-controller btn btn-sm btn-block btn-ghost text-white hover:bg-gray-100 dark:hover:bg-gray-700 justify-start"
        aria-label="Cyberpunk"
        value="cyberpunk" />
    </li>
    <li>
      <input
        type="radio"
        name="theme-dropdown"
        class="theme-controller btn btn-sm btn-block btn-ghost text-white hover:bg-gray-100 dark:hover:bg-gray-700 justify-start"
        aria-label="Cupcake"
        value="cupcake" />
    </li>
    <li>
      <input
        type="radio"
        name="theme-dropdown"
        class="theme-controller btn btn-sm btn-block btn-ghost justify-start text-white hover:bg-gray-100 dark:hover:bg-gray-700 "
        aria-label="Valentine"
        value="valentine" />
    </li>
      </ul>
    </li>

    <?php if(isset( $_SESSION['user_id'])): ?>
      <li>
      <a href=".?page=home&logout=true" class="flex items-center space-x-2 p-2 dark:text-red-400 rounded-lg hover:bg-red-500 hover:text-white dark:hover:bg-red-600">
        <i class="fas fa-sign-out-alt text-dark-500 dark:text-dark-400"></i>
        <span>Logout</span>
      </a>
    </li>
    <?php else: ?>
      <li>
      <a href="auth/login.php" class="flex items-center space-x-2 p-2 dark:text-green-400 rounded-lg hover:bg-red-500 hover:text-white dark:hover:bg-green-600">
        <i class="fas fa-sign-in-alt text-dark-500 dark:text-dark-400"></i>
        <span>Login</span>
      </a>
    </li> 
    <?php endif; ?>
   
  </ul>
</div>
<script>
    function toggleSubmenu(e) {
    e.preventDefault();
    // Find the nested submenu relative to the clicked "Settings" link
    var submenu = e.currentTarget.nextElementSibling;
    if (submenu) {
      submenu.classList.toggle('hidden');
    }
    // Stop propagation if needed so that clicking doesn't trigger the main dropdown hover behavior again
    e.stopPropagation();
  }
</script>
    </div>
</nav>
