<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - EchoForum</title>
  <?php include("../partials/common.php"); ?>
</head>

<body class="flex items-center justify-center min-h-screen bg-base-200">

  <div id="settingsSubmenu" class="dropdown dropdown-end absolute top-4 right-4">
    <div class="dropdown mb-72">
      <div tabindex="0" role="button" class="btn m-1 text-white dark:bg-gray-700 hover:bg-gray-700">
        Theme
        <svg
          width="12px"
          height="12px"
          class="inline-block h-2 w-2 fill-current opacity-60"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 2048 2048">
          <path d="M1799 349l242 241-1017 1017L7 590l242-241 775 775 775-775z"></path>
        </svg>
      </div>
      <ul tabindex="0" class="dropdown-content bg-base-300 rounded-box z-[1] w-52 p-2 shadow-2xl">
        <li>
          <input
            type="radio"
            name="theme-dropdown"
            class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
            aria-label="Default"
            value="default" />
        </li>
        <li>
          <input
            type="radio"
            name="theme-dropdown"
            class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
            aria-label="Retro"
            value="retro" />
        </li>
        <li>
          <input
            type="radio"
            name="theme-dropdown"
            class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
            aria-label="Cyberpunk"
            value="cyberpunk" />
        </li>
        <li>
          <input
            type="radio"
            name="theme-dropdown"
            class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
            aria-label="Cupcake"
            value="cupcake" />
        </li>
        <li>
          <input
            type="radio"
            name="theme-dropdown"
            class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
            aria-label="Valentine"
            value="valentine" />
        </li>
      </ul>
    </div>
  </div>

  <!-- Signup Card -->
  <div class="w-full max-w-md p-6 bg-white shadow-md hover:shadow-xl rounded-lg dark:bg-dark-900 border border-gray-300 transition">

    <!-- Branding Section with Logo -->
    <div class="text-center mb-6">
      <!-- Replace the src with your logo's path -->
      <img src="../uploads/logo.png" alt="EchoForum Logo" class="mx-auto h-[100px] w-auto">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-dark">EchoForum</h2>
      <p class="text-sm text-gray-500 dark:text-dark-400">Create your account and join the conversation.</p>
    </div>

    <!-- Signup Form -->
    <form class="signup-form">
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Username</label>
        <input type="text" id="user-name" placeholder="Enter your username" data-input="username" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white username" pattern="[a-zA-Z0-9_]+$" title="Only letters and numbers are allowed (except underscores), with no spaces." required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Email</label>
        <input type="email" placeholder="Enter your email" data-input="email" id="email" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Password</label>
        <input type="password" id="password" placeholder="Enter your password" data-input="password" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white" required>
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Confirm Password</label>
        <input type="password" id="confirm-password" placeholder="Re-enter your password" data-input="confirmpassword" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white" required>
      </div>

      <!-- Signup Button -->
      <button type="submit" class="w-full btn btn-primary">Sign Up</button>
    </form>

    <!-- Divider -->
    <div class="divider my-4">or</div>

    <!-- Link to Login Page -->
    <p class="text-center text-sm text-gray-600 dark:text-dark-300">
      Already have an account?
      <a href="login.php" class="text-primary hover:underline">Log In</a>
    </p>
  </div>
  <?php
  include("../partials/toast.php");
  ?>

  <script src="../js/app.js"></script>
  <script src="../js/toast.js"></script>
  <script src="../js/helper.js"></script>
  <script src="../js/signup.js"></script>

</body>

</html>