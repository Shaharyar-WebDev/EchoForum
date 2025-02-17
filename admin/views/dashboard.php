<div class=" min-h-[80vh] flex justify-center">

<?php

$total_users_query = "SELECT
(SELECT COUNT(*) FROM users) as users,
(SELECT COUNT(*)FROM threads) as threads,
(SELECT COUNT(*) FROM thread_likes) as thread_likes,
(SELECT COUNT(*) FROM replies) as replies,
(SELECT COUNT(*)FROM reply_likes) as reply_likes,
(SELECT COUNT(*)FROM views) as views,
(SELECT COUNT(*)FROM categories) as categories;
"; 
$result = mysqli_query($conn, $total_users_query);
if($result){
  $total = mysqli_fetch_assoc($result);  
}



?>

<div class="flex flex-col flex-wrap justify-center items-center">
<div class="stats stats-vertical lg:stats-horizontal shadow">

<div class="stat shadow-md hover:shadow-xl">
    <div class="stat-figure text-secondary">
      <div class="avatar online">
        <div class="w-16 rounded-full">
          <img src="../public/uploads/avatars/admin.png" />
        </div>
      </div>
    </div>
    <div class="stat-title">Total Users</div>
    <div class="stat-value text-primary"><?php echo htmlspecialchars($total['users']) ?></div>
  </div>
</div>
<div class="stats stats-vertical lg:stats-horizontal shadow">
  <div class="stat">
    <div class="stat-figure text-primary">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block h-8 w-8 stroke-current">
      <circle cx="12" cy="12" r="10" fill="none"></circle>
      <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" fill="none"></path>
      <line x1="12" y1="17" x2="12.01" y2="17" fill="none"></line>
    </svg>
    </div>
    <div class="stat-title">Total Threads</div>
    <div class="stat-value text-primary"><?php echo htmlspecialchars($total['threads']) ?></div>
  </div>

  <div class="stat">
    <div class="stat-figure text-primary">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        class="inline-block h-8 w-8 stroke-current">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
    </div>
    <div class="stat-title">Total Thread Replies</div>
    <div class="stat-value text-primary"><?php echo htmlspecialchars($total['replies']) ?></div>
  </div>

  <div class="stat">
    <div class="stat-figure text-primary">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        class="inline-block h-8 w-8 stroke-current">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
      </svg>
    </div>
    <div class="stat-title">Total Categories</div>
    <div class="stat-value text-primary"><?php echo htmlspecialchars($total['categories']) ?></div>
  </div>
 
</div>
<br>
<div class="stats stats-vertical md:stats-vertical lg:stats-horizontal shadow">
  <div class="stat">
    <div class="stat-figure text-secondary">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        class="inline-block h-8 w-8 stroke-current">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
      </svg>
    </div>
    <div class="stat-title">Total Thread Likes</div>
    <div class="stat-value text-secondary"><?php echo htmlspecialchars($total['thread_likes']) ?></div>
  </div>

  <div class="stat">
    <div class="stat-figure text-secondary">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        class="inline-block h-8 w-8 stroke-current">
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
      </svg>
    </div>
    <div class="stat-title">Total Reply LIkes</div>
    <div class="stat-value text-secondary"><?php echo htmlspecialchars($total['reply_likes']) ?></div>
  </div>

  <div class="stat">
    <div class="stat-figure text-secondary">
    <svg xmlns="http://www.w3.org/2000/svg"
     width="24"
      height="24"
       viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block h-8 w-8 stroke-current">
       <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
       <circle cx="12" cy="12" r="3"></circle>
      </svg>
    </div>
    <div class="stat-title">Total Thread Views</div>
    <div class="stat-value text-secondary"><?php echo htmlspecialchars($total['views']) ?></div>
  </div>
</div>
</div>

</div>
