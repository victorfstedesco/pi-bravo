<?php
session_start();
require_once('../public/php/conexao.php');

try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao buscar categorias: " . $e->getMessage() . "</p>";
}

// Verificação do método GET para obter a categoria
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM CATEGORIA WHERE CATEGORIA_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifique se a categoria foi encontrada
            if (!$categoria) {
                echo "<p style='color:red;'>Categoria não encontrada.</p>";
                exit();
            }
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro: " . $e->getMessage() . "</p>";
            exit();
        }
    } else {
        header('Location: categoria.php');
        exit();
    }
}

// Bloco de atualização de dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $stmt = $pdo->prepare("UPDATE CATEGORIA SET CATEGORIA_NOME = :nome, CATEGORIA_DESC = :descricao, CATEGORIA_ATIVO = :ativo WHERE CATEGORIA_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT); 
        $stmt->execute();


        // Salvar mensagem de sucesso na sessão
        $_SESSION['mensagem'] = "<p class='mensagem-acerto'>Edição feita com sucesso.</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: categoria-editar.php?id=$id");
        exit;
    } catch (PDOException $e) {
        // Salvar mensagem de erro na sessão
        $_SESSION['mensagem'] = "<p class='mensagem-erro'>Erro ao editar o categoria: " . $e->getMessage() . "</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: categoria-editar.php?id=$id");
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

    <link rel="stylesheet" href="../public/css/categoria-editar.css"> <!-- css do arquivo -->

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
            <h4>Editar categoria</h4>
            <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
            }
            ?>
        </div>
            <form action="categoria-editar.php" method="post">
                <div class="formulario">
                    <div class="div-input">
                        <input type="hidden" name="id" value="<?php echo isset($categoria['CATEGORIA_ID']) ? $categoria['CATEGORIA_ID'] : ''; ?>">
                        <label for="categoria">Categoria</label>
                        <input type="text" name="nome" id="nome" value="<?php echo isset($categoria['CATEGORIA_NOME']) ? $categoria['CATEGORIA_NOME'] : ''; ?>">
                    </div>
                    <div class="div-input">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao"><?php echo isset($categoria['CATEGORIA_DESC']) ? $categoria['CATEGORIA_DESC'] : ''; ?></textarea>                </div>
                <div class="submit">
                    <button class="button2" type="submit">Editar categoria</button>
                </div>
            </form>
    </section>
</body>
</html>