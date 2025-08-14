<?php
/**
 * Template Name: JWT Login Page
 */
get_header();
?>

<div id="jwt-login">
  <h2>Login</h2>
  <form id="login-form" autocomplete="on">
    <input type="text" id="username" name="username" placeholder="Username" required autocomplete="username" /><br><br>
    <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password" /><br><br>
    <button type="submit">Login</button>
  </form>
</div>


<hr>

<div id="posts-area" style="display: none;">
  <h2>Protected Posts</h2>
  <div id="posts-container"></div>
  <button id="logout-btn">Logout</button>   
</div>


<?php get_footer(); ?>
