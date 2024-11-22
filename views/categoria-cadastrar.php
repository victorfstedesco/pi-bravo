<?php
session_start();

require_once("../public/php/conexao.php");

if(!isset($_SESSION['admin_logado'])){
    header ("Location:login.php");
    exit();
}

try{
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria-> execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "<p style='color:red;'>Erro ao buscar categorias: . $e->getMessage(). </p>";
}

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;


try{
    $sql = "INSERT INTO CATEGORIA (CATEGORIA_NOME, CATEGORIA_DESC, CATEGORIA_ATIVO) VALUES (:nome, :descricao, :ativo)";
    $stmt =$pdo->prepare($sql);

    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR); 
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
    $stmt->execute();

        // Salvar a mensagem na sessão
        $_SESSION['mensagem'] = "<p class='mensagem-acerto'>Categoria cadastrado com sucesso!</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: categoria-cadastrar.php");
        exit;
    } catch (PDOException $e) {
        // Salvar a mensagem de erro na sessão
        $_SESSION['mensagem'] = "<p class='mensangem-erro'>Erro ao cadastrar o categoria: " . $e->getMessage() . "</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: categoria-cadastrar.php");
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

    <link rel="stylesheet" href="../public/css/categoria-cadastrar.css"> <!-- css do arquivo -->

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
                    <a href="./administrador.php"><li>Ambiente do administrador</li></a>
                    <a href="./categoria.php"><li class="li-style">Ambiente de categoria</li></a>
                    <a href="./produtos.php"><li>Ambiente de produtos</li></a>
                </ul>
            </nav>
            <img src="../public/assets/logo-minimalista.svg" alt="">
        </header>
        <!--fim do 'componente' header-->
    </main>
    <section>
        <div class="header-content">
            <a href="./categoria.php"><img src="../public/assets/voltar.svg" alt=""></a>
            <h4>Cadastrar categoria</h4>
            <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
            }
            ?>
        </div>
            <form action="categoria-cadastrar.php" method="post">
                <div class="formulario">
                    <div class="div-input">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome">
                    </div>
                    <div class="div-input">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" required></textarea>
                    </div>
                    <div class="div-checkbox">
                        <label for="ativo">Ativo</label>
                        <input type="checkbox" id="ativo" name="ativo" value="1" checked>
                    </div>
                </div>
                <div class="submit">
                    <button class="button2" type="submit">Cadastrar categoria</button>
                </div>
            </form>
    </section>
    </section>
</body>
</html>