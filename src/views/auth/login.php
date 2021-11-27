<?php
declare(strict_types=1);

validateStartSession();

// If the user is logged in, redirect them to the home page
if (isset($_SESSION) && !empty($_SESSION)) :
  header('Location: /');
endif;

?>

<div class="flex justify-center">
  <div class="md:w-2/4">

    <form class="md:border md:border-gray-100 rounded p-2 md:p-8 lg:px-20" method="POST" action="/login" id="login-form">
      <h1 class="text-center mb-8 uppercase font-normal">Log In</h1>
      <div class="mb-4">
        <label for="email" class="block text-gray-600 mb-1">Email address</label>
        <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded shadow-sm outline-none focus:border-indigo-400" id="email" placeholder="myemail@cms.com" required>
      </div>
      <div class="mb-4">
        <label for="password" class="block text-gray-600 mb-1">Password</label>
        <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded shadow-sm outline-none focus:border-indigo-400" id="password" placeholder="********" required>
      </div>
      <button id="login-submit" class="g-recaptcha bg-indigo-500 hover:bg-indigo-600 d-block px-4 py-2 rounded w-full text-white" data-sitekey="<?php echo RECAPTCHA_PUBLIC_KEY; ?>" data-action='submit' type="submit">Submit</button>
      <div class="text-red-500 mt-4">
        <?php
          if (isset($errors) && is_array($errors) && !empty($errors)) :
            foreach ($errors as $error) :
              echo "<small>{$error}</small>";
            endforeach;
          endif;
        ?>
      </div>
    </form>

  </div>
</div>
<script src="./assets/js/login.bundle.js"></script>
