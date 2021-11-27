<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CMS</title>
  <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_PUBLIC_KEY ?? ""; ?>"></script>
  <script src="./assets/js/app.bundle.js"></script>
</head>

<body>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="relative bg-white overflow-hidden">
    <div class="mx-auto">
      <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20">
        <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
          <polygon points="50,0 100,0 50,100 0,100" />
        </svg>

        <div>
          <div class="relative pt-6 px-4 sm:px-6 lg:px-8">
            <nav class="relative flex items-center justify-between sm:h-10" aria-label="Global">
              <div class="flex items-center flex-grow flex-shrink-0 lg:flex-grow-0">
                <div class="flex items-center justify-between w-full md:w-auto">
                  <a href="#">
                    <span class="sr-only">Workflow</span>
                    <a href="/">
                      <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg">
                    </a>
                  </a>
                  <div class="-mr-2 flex items-center md:hidden">
                    <button type="button" id="btn-open-hamburguer" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                      <span class="sr-only">Open main menu</span>
                      <!-- Heroicon name: outline/menu -->
                      <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="hidden md:block md:ml-10 md:pr-4 md:space-x-8">
                <a href="/" class="font-medium text-gray-500 hover:text-gray-900">Home</a>

                <a href="/events" class="font-medium text-gray-500 hover:text-gray-900">Events</a>

                <a href="/shop" class="font-medium text-gray-500 hover:text-gray-900">Shop</a>

                <a href="/team" class="font-medium text-gray-500 hover:text-gray-900">Team</a>

                <?php if(isset($_SESSION) && !empty($_SESSION)): ?>
                  <a href="/logout" class="font-medium text-indigo-600 hover:text-indigo-500">Log out</a>
                <?php else: ?>
                  <a href="/login" class="font-medium text-indigo-600 hover:text-indigo-500">Log in</a>
                <?php endif; ?>
              </div>
            </nav>
          </div>

          <!--
          Mobile menu, show/hide based on menu open state.

          Entering: "duration-150 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
          <div id="menu-mobile" class="hidden absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden">
            <div class="rounded-lg shadow-md bg-white ring-1 ring-black ring-opacity-5 overflow-hidden">
              <div class="px-5 pt-4 flex items-center justify-between">
                <div>
                  <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="">
                </div>
                <div class="-mr-2">
                  <button type="button"  id="btn-close-hamburguer" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                    <span class="sr-only">Close main menu</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Home</a>

                <a href="/events" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Events</a>

                <a href="/shop" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Shop</a>

                <a href="/team" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">Team</a>
              </div>

              <?php if(isset($_SESSION) && !empty($_SESSION)): ?>
                <a href="/logout" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100">Log out</a>
              <?php else: ?>
                <a href="/login" class="block w-full px-5 py-3 text-center font-medium text-indigo-600 bg-gray-50 hover:bg-gray-100">Log in</a>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>


<script>
  const btnOpenHamburguer = document.getElementById('btn-open-hamburguer');
  const btnCloseHamburguer = document.getElementById('btn-close-hamburguer');  
  const menuMobile = document.getElementById('menu-mobile');

  btnOpenHamburguer.addEventListener('click', () => {    
    if(menuMobile.classList.contains('hidden') ){
      menuMobile.classList.remove('hidden');
    }
  });

  btnCloseHamburguer.addEventListener('click', () => {
    if(!menuMobile.classList.contains('hidden') ){
      menuMobile.classList.add('hidden');
    }
  });
  
</script>