<form id="login" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="POST">
<input type="email" name="email" value="E-mail"/></br>
<input type="password" name="password" value="Password"/></br>
<input type="hidden" name="action" value="loginUser">
<input type="submit" name="login" class="btn btn-green" value="Log in" />
</form>