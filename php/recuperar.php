<?php
//ATENÇÃO O RECUPERAR SENHA NAO FUNCIONA. É APARENTEMENTE NECESSARIO UM SITE PARA FAZER O ENVIO PARA O E-MAIL, SITE QUE EU NÃO TENHO E TAMBÉM NÃO SEI FAZER.
//NÃO CONSEGUI FAZER ESSE METODO DE FORMA LOCAL, ENTÃO... NÃO FUNCIONA.

session_start();

function gerarToken() {
    return bin2hex(random_bytes(16));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    $host = 'localhost';
    $usuarioDB = 'root';
    $senhaDB = '';
    $nomeDB = 'usuarioscadastro';

    $conexao = new mysqli($host, $usuarioDB, $senhaDB, $nomeDB);

    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

   
    $sql = "SELECT id, email FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $resultado = $stmt->get_result();




    if ($resultado->num_rows > 0) {
        $usuarioDB = $resultado->fetch_assoc();

        $token = gerarToken();

        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $sqlInsert = "INSERT INTO recuperacao_senha (usuario_id, token, expiracao) VALUES (?, ?, ?)";
        $stmtInsert = $conexao->prepare($sqlInsert);
        $stmtInsert->bind_param("iss", $usuarioDB['id'], $token, $expiracao);
        $stmtInsert->execute();

        $linkRecuperacao = "E:\XAMPP\htdocs\Projeto Desenvolvimento web N2/recuperar_senha.php?token=" . $token; //Não tenho site então vai ser no localmesmo


        $assunto = "Recuperação de Senha";
        $mensagem = "Olá, clique no link abaixo para recuperar sua senha:\n\n" . $linkRecuperacao;
        $headers = "From: no-reply@seusite.com\r\n" . "Reply-To: no-reply@seusite.com";


        if (mail($email, $assunto, $mensagem, $headers)) {
            echo "Um link para recuperação de senha foi enviado para o seu email.";
        } else {
            echo "Erro ao enviar o email de recuperação.";
        }
    } else {
        echo "Email não encontrado!";
    }

    $conexao->close();
}
?>
