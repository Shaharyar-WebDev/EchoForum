<?php
session_start();
if(isset($_SESSION['user_id'])){

header("location: ../");

}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EchoForum</title>
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

    <!-- Login Card -->
    <div class="w-full max-w-md p-6 bg-white shadow-md rounded-lg hover:shadow-xl dark:bg-dark-900 border border-gray-300 transition">
        <!-- Branding -->
        <div class="text-center">
            <img src="../uploads/logo.png" alt="EchoForum Logo" class="mx-auto h-[100px] w-auto">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-dark">EchoForum</h2>
            <p class="text-sm text-gray-500 dark:text-dark-400">Welcome back! Please login to continue.</p>
        </div>

        <!-- Login Form -->
        <form class="mt-4 login-form">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Email</label>
                <input type="email" id="email" placeholder="Enter your email" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-dark-300">Password</label>
                <input type="password" id="password" placeholder="Enter your password" class="w-full input input-bordered focus:ring focus:ring-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white" required>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between items-center mb-4">
                <label class="flex items-center">
                    <input type="checkbox" class="checkbox checkbox-primary">
                    <span class="ml-2 text-sm text-gray-600 dark:text-dark-300">Remember Me</span>
                </label>
                <a href="forgot.php" class="text-sm text-primary hover:underline">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full btn btn-primary">Login</button>
        </form>

        <!-- Divider -->
        <div class="divider my-4">or</div>

        <!-- Register Link -->
        <p class="text-center text-sm text-gray-600 dark:text-dark-300">
            Don't have an account?
            <a href="signup.php" class="text-primary hover:underline">Sign up</a>
        </p>
    </div>

    <?php include("../partials/toast.php"); ?>

    <script src="../js/app.js"></script>
    <script src="../js/toast.js"></script>
    <script src="../js/helper.js"></script>
    <script src="../js/login.js"></script>

</body>

</html>