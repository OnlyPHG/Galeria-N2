<?php

session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $host = 'localhost'; 
    $usuarioDB = 'root'; 
    $senhaDB = ''; //Deixa vazia, se colocar algo vai ter que colocar pra acessar o banco de dados
    $nomeDB = 'usuarioscadastro'; // Nome do banco de dados

   
    $conexao = new mysqli($host, $usuarioDB, $senhaDB, $nomeDB);

    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // Verifica se o email foi encontrado
    if ($resultado->num_rows > 0) {
        // Pega os dados do usuário
        $usuarioDB = $resultado->fetch_assoc();
        
        // Verifica a senha
        $senhaCorreta = password_verify($senha, $usuarioDB['senha']);

        if ($senhaCorreta) {
            // Senha correta, cria a sessão
            $_SESSION['usuario_id'] = $usuarioDB['id']; 
            $_SESSION['usuario_nome'] = $usuarioDB['primeironome']; 
            
            header("Location: ../hub.html"); 
            exit();
        } else {
            $_SESSION['erro_login'] = "Senha incorreta!";
            header("Location: ../login.php"); 
            exit();
        }
    } else {

        $_SESSION['erro_login'] = "Email não encontrado!";
        header("Location: ../login.php"); 
        exit();
    }

    $conexao->close();
}
?>
