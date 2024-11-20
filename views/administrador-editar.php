<?php
session_start();

require_once('../public/php/conexao.php');

$administrador = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $administrador = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        
        if (!$administrador) {
            header('Location: ambiente-administrador.php');
            exit();
        }
    } else {
        header('Location: ambiente-administrador.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        echo "<p style='color:green;'>Edição feita com sucesso.</p>";

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao editar o Administrador: " . $e->getMessage() . "</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../public/css/administrador-editar.css"> <!-- css do arquivo -->

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
                    <li>Menu</li>
                    <li>Ambiente do administrador</li>
                    <li>Ambiente de categoria</li>
                    <li>Ambiente de produtos</li>
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
                    <button class="button1" type="submit">Excluir</button>
                    <button class="button2" type="submit">Cadastrar Admistrador</button>
                </div>
            </form>
    </section>
</body>
</html>