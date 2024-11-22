<?php
//Inicia a sessão de gerenciamento do usuário
session_start();

//Importa a configuração de conexão com o banco de dados
require_once('../public/php/conexao.php');

//Bloco que será executado quando o formulário for submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) VALUES (:nome, :email, :senha, :ativo);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        $stmt->execute();

        // Pegar o ID do Administrador inserido
        $adm_id = $pdo->lastInsertId();

        // Salvar a mensagem na sessão
        $_SESSION['mensagem'] = "<p class='mensagem-acerto'>Administrador cadastrado com sucesso! ID: " . $adm_id . "</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: administrador-cadastrar.php");
        exit;
    } catch (PDOException $e) {
        // Salvar a mensagem de erro na sessão
        $_SESSION['mensagem'] = "<p class='mensangem-erro'>Erro ao cadastrar o administrador: " . $e->getMessage() . "</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: administrador-cadastrar.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../public/css/administrador-cadastrar.css"> <!-- css do arquivo -->

    <link rel="stylesheet" href="../public/css/tipografia.css"> <!-- css externo -->
    <link rel="stylesheet" href="../public/css/main.css"> <!-- css externo -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <!--começo do 'componente' header-->
        <header>
            <nav>
                <ul> 
                    <a href="./menu.php"><li>Menu</li></a>
                    <a href="./administrador.php"><li class="li-style">Ambiente do administrador</li></a>
                    <a href="./categoria.php"><li>Ambiente de categoria</li></a>
                    <a href="./produtos.php"><li>Ambiente de produtos</li></a>
                </ul>
            </nav>
            <img src="../public/assets/logo-minimalista.svg" alt="">
        </header>
        <!--fim do 'componente' header-->
    </main>
    <section>
        <div class="header-content">
            <a href="./administrador.php"><img src="../public/assets/voltar.svg" alt=""></a>
            <h4>Cadastrar administrador</h4>
            <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
            }
            ?>
        </div>
            <form action="administrador-cadastrar.php" method="post">
                <div class="formulario">
                    <div class="div-input">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome">
                    </div>
                    <div class="div-input">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" placeholder="E-mail">
                    </div>
                    <div class="div-input">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Senha">
                    </div>
                    <div class="div-checkbox">
                        <label for="ativo">Ativo</label>
                        <input type="checkbox" id="ativo" name="ativo" value="1" checked>
                    </div>
                </div>
                <div class="submit">
                    <button class="button2" type="submit">Cadastrar admistrador</button>
                </div>
            </form>
    </section>
    </section>
</body>
</html>