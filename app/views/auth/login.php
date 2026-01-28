<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.7.3/tailwind.min.css'></head>
 <body>
  <body class="flex h-screen bg-indigo-700">
<div class="w-full max-w-xs m-auto bg-indigo-100 rounded p-5">   
      <header>
        <img class="w-20 mx-auto mb-5" src="<?= BASE_URL ?>/assets/images/acceso.png" alt="Icono de inicio de sesion" width="96" height="96" />
      </header>   
      <?php if ($error = Session::getFlash('error')): ?>
        <div style="color:red; margin-bottom:10px;" class="error">
            <?= htmlspecialchars($error)?>
        </div>
        <?php endif; ?>

      <form method="POST" action="<?= BASE_URL ?>/login">
        <div>
          <label class="block mb-2 text-indigo-500" for="username">Usuario</label>
          <input class="w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300" type="text" name="username" required>
        </div>
        <div>
          <label class="block mb-2 text-indigo-500" for="password">Contraseña</label>
          <input class="w-full p-2 mb-6 text-indigo-700 border-b-2 border-indigo-500 outline-none focus:bg-gray-300" type="password" name="password" required>
        </div>
        <div>          
          <input class="w-full bg-indigo-700 hover:bg-pink-700 text-white font-bold py-2 px-4 mb-6 rounded" type="submit">
        </div>       
      </form>  
      <footer>
       
      </footer>   
    </div>
</body>
    
  </body>
</html>