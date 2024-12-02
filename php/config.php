<?php
if (isset($_POST['Cadastrar'])) {
    //Vamo pegar os dados do FORM
    $primeiroNome = $_POST['primeironome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha']; 
    $confirmesenha = $_POST['confirmesenha']; 
    $genero = isset($_POST['gender']) ? $_POST['gender'] : 'Não especificado';
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $cpf = $_POST['cpf'];
    $complemento = $_POST['complemento'];
    $rg = $_POST['rg'];

    //vamos verificar se as senhas são iguais
    if ($senha !== $confirmesenha) {
        $erros[] = "As senhas não coincidem.";
    } else {
        //Criptografia para a senha no banco de dados
        $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
    }


    $dataNascimento = $_POST['data-nascimento']; 

    
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dataNascimento)) {
        $erros[] = "Data de nascimento inválida.";
    } else {
        
        $dataNascimentoFormatada = $dataNascimento; 
    }


    $camposObrigatorios = ['primeironome', 'sobrenome', 'email', 'telefone', 'senha', 'confirmesenha', 'gender', 'endereco', 'numero', 'cpf', 'complemento', 'rg', 'data-nascimento'];
    foreach ($camposObrigatorios as $campo) {
        if (empty(trim($_POST[$campo] ?? ''))) {
            $erros[] = "O campo '$campo' é obrigatório.";
        }
    }

    if (empty($erros)) {
        try {
    
            $pdo = new PDO('mysql:host=localhost;dbname=usuarioscadastro', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Vamos inserir os dados no banco de dados, coloca certo pra não dar B.O no banco de dados.
            $sql = "INSERT INTO usuarios (primeironome, sobrenome, email, telefone, senha, genero, endereco, numero, cpf, complemento, rg, data_nascimento) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$primeiroNome, $sobrenome, $email, $telefone, $senhaCriptografada, $genero, $endereco, $numero, $cpf, $complemento, $rg, $dataNascimentoFormatada]);

            
            header('Location: ../login.html'); 
            exit; 
        } catch (PDOException $e) {
            echo "Erro ao cadastrar: " . $e->getMessage();
        }
    } else {

        foreach ($erros as $erro) {
            echo "<p style='color: red;'>$erro</p>";
        }
    }
}
?>
