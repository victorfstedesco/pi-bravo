<?php
session_start();
require_once('../public/php/conexao.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE ADM_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ambiente-administrador.php");
        exit(); 
    } catch (PDOException $e) {
        header("Location: ambiente-administrador.php");
        exit();
    }
}

try {
    $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR");
    $stmt->execute();
    $administradores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao listar administradores: " . $e->getMessage() . "</p>";
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
        <div class="formulario">
        <img src="../public/assets/voltar.svg" alt="">
        <h4>Cadastrar administrador</h4>
            <form action="cadastrar-administrador.php" method="post">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" placeholder="Nome">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="E-mail">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Senha">
                <label for="ativo">Ativo</label>
                <input type="checkbox" id="ativo" name="ativo" value="1" checked>
                <div>
                    <button type="submit">Cadastrar Admistrador</button>
                    <button type="submit">Cadastrar Admistrador</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>