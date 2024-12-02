<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS\login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
    <title>Login</title>
  </head>
  <body>
    <video id="background-video" autoplay loop muted poster="assets\Videos\Dark Star_ Nothing Escapes _ Skins Teaser - League of Legends.mp4">
        <source src="assets\Videos\Dark Star_ Nothing Escapes _ Skins Teaser - League of Legends.mp4" type="video/mp4">
    </video>

    <div class="tela-login">
        <form action="php\autenticar.php" method="POST"> 
            <h1 class="login">Faça seu Login</h1>

            <?php
            if (isset($_SESSION['erro_login'])) {
                echo "<p style='color: red;'>" . $_SESSION['erro_login'] . "</p>";
                unset($_SESSION['erro_login']); 
            }
            ?>
            
            <p>Digite seu Email</p>
            <input id="email" type="email" name="email" placeholder="Email" required>
            <br><br>
            <p>Digite sua Senha</p>
            <input id="senha" type="password" name="senha" placeholder="Senha" required>
            <br><br>
            <a href="recuperarsenha.html" target="_blank">Esqueci minha senha</a>
            
            <div class="login-button"> 
                <button type="submit">Entrar</button>
                
                <button><a class="cadastre-sebutton" href="cadastro.html" target="_blank">Cadastre-se</a></button>
            </div>
        </form>
    </div>
  </body>
</html>
