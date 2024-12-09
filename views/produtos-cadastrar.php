<?php
session_start();

require_once("../public/php/conexao.php");

if(!isset($_SESSION['admin_logado'])){
    header ("Location:login.php");
    exit();
}

//bloco de consulta para categoria 
try{
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria-> execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo "<p style='color:red;'>Erro ao buscar categorias: . $e->getMessage(). </p>";
}

//bloco que será executado quando o formulário for submetido
if($_SERVER['REQUEST_METHOD']=='POST'){
    //Pegamos os valores do post enviados via formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $desconto = $_POST['desconto'];
    $estoque = $_POST['estoque'];
    $categoria_id = $_POST['categoria_id'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $imagens_urls= $_POST['imagem_url'];
    $imagem_ordens= $_POST['imagem_ordem'];

//bloco para inserir no banco de dados, os dados capturados do formulário PRODUTOS

try{
    $sql = "INSERT INTO PRODUTO (PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, CATEGORIA_ID, PRODUTO_ATIVO, PRODUTO_DESCONTO) VALUES (:nome, :descricao, :preco, :categoria_id, :ativo, :desconto);";
    $stmt =$pdo->prepare($sql);

    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR); //Vicula placeholder com a variavel, PARAM_STR serve para seleionar apenas o que é string, deixando mais seguro 
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
    $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
    $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
    $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);

    $stmt->execute();
    
    //Pegar o ID do último produto inserido no banco de dados 
    $produto_id = $pdo->lastInsertId();


//bloco para inserir no banco de dados, os dados capturados do formulário PRODUTO_ESTOQUE

    $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE (PRODUTO_ID, PRODUTO_QTD) VALUES (:produto_id, :estoque);";
    $stmt_estoque =$pdo->prepare($sql_estoque);

    $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
    $stmt_estoque->bindParam(':estoque', $estoque, PDO::PARAM_INT);
 

    $stmt_estoque->execute();
    

//bloco para inserir no banco de dados, os dados capturados do formulário PRODUTO_IMAGEM

    $imagens_urls = $imagens_urls ?? [];
    $imagem_ordens = $imagem_ordens ?? [];

    foreach($imagens_urls as $index=> $url){
        $ordem = $imagem_ordens[$index];

    $sql_imagem = "INSERT INTO PRODUTO_IMAGEM (IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) VALUES (:url_imagem, :produto_id, :imagem_ordem);";
    $stmt_imagem =$pdo->prepare($sql_imagem);

    $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
    $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
    $stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);


    $stmt_imagem->execute();
    
    }

    // Salvar mensagem de sucesso na sessão
    $_SESSION['mensagem'] = "<p class='mensagem-acerto'>Cadastro feito com sucesso.</p>";

    // Redirecionar para evitar reenvio do formulário
    header("Location: produtos-cadastrar.php?id=$id");
    exit;


    } catch (PDOException $e) {
        // Salvar mensagem de erro na sessão
        $_SESSION['mensagem'] = "<p class='mensagem-erro'>Erro ao cadastrar produto: " . $e->getMessage() . "</p>";

        // Redirecionar para evitar reenvio do formulário
        header("Location: produtos-cadastrar.php?id=$id");
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
            <h4>Cadastrar produto</h4>
            <?php
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
            }
            ?>
        </div>
            <form action="produtos-cadastrar.php" method="post">
                <div class="formulario">
                    <div class="div-input">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome" required></input>
                    </div>
                    <div class="div-input">
                        <label for="descricao">Descrição</label>
                        <textarea type="text" name="descricao" id="descricao" placeholder="Descrição" required></textarea>
                    </div>
                    <div class="div-input">
                        <label for="desconto">Desconto</label>
                        <input type="text" name="desconto" id="desconto" placeholder="Desconto" required></input>
                    </div>
                    <div class="div-input">
                        <label for="estoque">Estoque</label>
                        <input type="text" name="estoque" id="estoque" placeholder="Estoque" required></input>
                    </div>
                    <div class="div-input">
                        <label for="preco">Preço</label>
                        <input type="text" name="preco" id="preco" placeholder="Preço" required></input>
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
                        <input type="checkbox" id="ativo" name="ativo" value="1" checked>
                    </div>
                    
                    <div id="containerImagens">
                        <div class="imagem-input">
                            <input type="text" name="imagem_url[]" placeholder="URL da imagem" >
                            <input type="number" name="imagem_ordem[]" placeholder="Ordem" value="1">
                        </div>
                    </div>
                </div>
                <div class="submit">
                    <button class="button1" type="button" onclick="adicionarImagem()">Adicionar mais Imagens</button>
                    <button class="button2" type="submit">Cadastrar produto</button>
                </div>
            </form>
    </section>
    </section>

    <script>
            // Adiciona um novo campo de imagem URL e ordem
            function adicionarImagem() {
            // Cria uma variável e joga nela o elemento identificado por id='containerImagens', que é uma div que conterá os divs de inputs
            const containerImagens = document.getElementById('containerImagens');
            // Criar uma nova div e jogar na variável novoDiv. Esse novo div tem a classe 'imagem-input'
            const novoDiv = document.createElement('div');
            novoDiv.className = 'imagem-input';

            // Cria um elemento de input e joga na variável novoInputURL
            const novoInputURL = document.createElement('input');
            novoInputURL.type = 'text';
            novoInputURL.name = 'imagem_url[]'; // Corrigido para 'imagem_url[]'
            novoInputURL.placeholder = 'URL da imagem';
            novoInputURL.required = true;

            // Cria um elemento de input e joga na variável novoInputOrdem
            const novoInputOrdem = document.createElement('input');
            // Define atributos desse input criado
            novoInputOrdem.type = 'number';
            novoInputOrdem.name = 'imagem_ordem[]'; // Corrigido para 'imagem_ordem[]'
            novoInputOrdem.placeholder = 'Ordem';
            novoInputOrdem.min = '1';
            novoInputOrdem.required = true;

            // Incorpora esses dois inputs criados na div definida como novoDiv
            novoDiv.appendChild(novoInputURL);
            novoDiv.appendChild(novoInputOrdem);

            // Incorpora a div novoDiv na div mais externa, denominada containerImagens
            containerImagens.appendChild(novoDiv);
        }
    </script>
</body>
</html>
