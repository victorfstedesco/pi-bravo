<?php
session_start();

require_once('../public/php/conexao.php');

try{
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria-> execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "<p style='color:red;'>Erro ao buscar categorias: . $e->getMessage(). </p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO
                LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID = PRODUTO_IMAGEM.PRODUTO_ID
                LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID = PRODUTO_ESTOQUE.PRODUTO_ID
                WHERE PRODUTO.PRODUTO_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            $categorias = $pdo->query("SELECT CATEGORIA_ID, CATEGORIA_NOME FROM CATEGORIA")->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header("Location: produtos-editar.php?id=$id");
        exit();
    }


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $imagem_url = $_POST['imagem_url'];
    $estoque = $_POST['estoque'];
    $categoria_id = $_POST['categoria_id'];


    try {
        // Atualizando a tabela PRODUTO
        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->execute();

        // Atualizando a tabela PRODUTO_IMAGEM
        $stmt = $pdo->prepare("UPDATE PRODUTO_IMAGEM SET IMAGEM_URL = :imagem_url WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':imagem_url', $imagem_url, PDO::PARAM_STR);
        $stmt->execute();

        // Atualizando a tabela PRODUTO_ESTOQUE
        $stmt = $pdo->prepare("UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :estoque WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: produtos-editar.php?id=$id");
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../public/css/produtos-cadastrar.css"> <!-- css do arquivo -->

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
                    <a href="./categoria.php"><li>Ambiente de categoria</li></a>
                    <a href="./produtos.php"><li class="li-style">Ambiente de produtos</li></a>
                </ul>
            </nav>
            <img src="../public/assets/logo-minimalista.svg" alt="">
        </header>
        <!--fim do 'componente' header-->
    </main>
    <section>
        <div class="header-content">
            <a href="./produtos.php"><img src="../public/assets/voltar.svg" alt=""></a>
            <h4>Editar produto</h4>
            <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
            }
            ?>
        </div>
            <form action="produtos-editar.php" method="POST">
                <div class="formulario">
                    <div class="div-input">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="<?php echo $produto['PRODUTO_NOME']; ?>">
                        </div>
                    <div class="div-input">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao"><?php echo $produto['PRODUTO_DESC']; ?></textarea>
                    </div>
                    <div class="div-input">
                        <label for="desconto">Desconto</label>
                        <input type="text" name="desconto" id="desconto" value="<?php echo $produto['PRODUTO_DESCONTO']; ?>">
                    </div>
                    <div class="div-input">
                        <label for="estoque">Estoque</label>
                        <input type="number" name="estoque" id="estoque" value="<?php echo $produto['PRODUTO_QTD']; ?>">
                    </div>
                    <div class="div-input">
                        <label for="preco">Preço</label>
                        <input type="number" name="preco" id="preco" value="<?php echo $produto['PRODUTO_PRECO']; ?>">
                    </div>
                    <div class="div-input">
                        <label for="categoria">Categoria</label>
                        <select name="categoria_id" id="categoria_id" required> <!-- COMEÇO DA MODIFICAÇÃO -->
                        <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"> <?php echo $categoria['CATEGORIA_NOME']; ?> </option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="div-checkbox">
                        <label for="ativo">Ativo</label>
                        <input type="checkbox" id="ativo" name="ativo" value="1" <?php echo (isset($produto['PRODUTO_ATIVO']) && $produto['PRODUTO_ATIVO'] == 1) ? 'checked' : ''; ?>>
                    </div>
                    
                    <div id="containerImagens">
                        <label for="imagem_url">URL da Imagem</label>
                        <input type="text" name="imagem_url" id="imagem_url" value="<?php echo isset($produto['IMAGEM_URL']) ? $produto['IMAGEM_URL'] : ''; ?>">
                    </div>
                </div>
                <div class="submit">
                    <button class="button2" type="submit">Editar produtos</button>
                </div>
            </form>
    </section>
</body>
</html>