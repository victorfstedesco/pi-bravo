<?php
session_start();
require_once('../public/php/conexao.php');
try{
    $stmt=$pdo->prepare("SELECT PRODUTO.*,CATEGORIA.CATEGORIA_NOME,PRODUTO_IMAGEM.IMAGEM_URL,PRODUTO_ESTOQUE.PRODUTO_QTD
    FROM PRODUTO JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID=CATEGORIA.CATEGORIA_ID
    LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID=PRODUTO_IMAGEM.PRODUTO_ID
    LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID=PRODUTO_ESTOQUE.PRODUTO_ID");
    $stmt->execute();//Executa a consulta
    $produtos=$stmt->fetchAll(PDO::FETCH_ASSOC);//Transforma os dados que coletamos acima em um array associativo ([chave-valor] chave será os nomes das colunas e os valores serão os dados cadastrados)
    // echo"<pre>";
    // print_r($produtos);
    // echo"</pre>";
}catch(PDOException $e){
    //Em caso de erro na consulta exibe uma mensagem
    echo"<p style='color:red;'>Erro ao listar produtos:".$e-getMessage()."</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../public/css/produtos.css"> <!-- css do arquivo -->

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
        <section>
            <div class="content-header">
                <h4>Ambiente de produtos</h4>
                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" required />
                    <button type="submit">
                        <img src="../public/assets/lupa.svg" alt="search">
                    </button>
                </form>
                <a href="./produtos-cadastrar.php"><button class="button1">Cadastrar produto</button>  </a>  
            </div>
            <div class="container-tabela">
                <?php if ($produtos) { 
                foreach ($produtos as $produto) { ?>
                <div class="card">
                    <div class="card-header">
                        <div class="status">
                            <p class="titulo-col">Status</p>
                            <?php if($produto ['PRODUTO_ATIVO'] >= 1){ ?>
                            <div class="ativado">
                                <img src="../public/assets/ativado.svg" alt="">
                                <p>Ativado</p>
                            </div>
                            <?php } else { ?>
                                <div class="desativado">
                                    <img src="../public/assets/desativado.svg" alt="">
                                    <p>Desativado</p>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="barra"></div>
                        <div id="id">
                            <p class="titulo-col">ID</p>
                            <h6><?php echo $produto ['PRODUTO_ID']?></h6>
                        </div>
                        <div id="nome">
                            <p class="titulo-col">Nome do produto</p>
                            <h6><?php echo $produto ['PRODUTO_NOME']?></h6>
                        </div>
                        <div id="categoria">
                            <p class="titulo-col">Categoria</p>
                            <h6><?php echo $produto ['CATEGORIA_NOME']?></h6>
                        </div>
                        <div id="quantidade">
                            <p class="titulo-col">Quantidade</p>
                            <h6><?php echo $produto ['PRODUTO_QTD']?></h6>
                        </div>
                        <div id="preco">
                            <p class="titulo-col">Preço</p>
                            <h6><?php echo $produto ['PRODUTO_PRECO']?></h6>
                        </div>
                        <div id="desconto">
                            <p class="titulo-col">Desconto</p>
                            <h6><?php echo $produto ['PRODUTO_DESCONTO']?></h6>
                        </div>
                        <div class="barra"></div>
                        <div class="acoes">
                            <a href="./produtos-editar.php?id=<?php echo $produto['PRODUTO_ID']?>"><img src="../public/assets/editar.svg" alt=""></a>
                            <a href="#" onclick="confirmDelete(<?php echo $produto['PRODUTO_ID']; ?>);"><img src="../public/assets/excluir.svg" alt=""></a>
                        </div>
                    </div>
                    <div class="card-info">
                        <img src="<?php echo isset($produto ['IMAGEM_URL']) ? $produto ['IMAGEM_URL'] : "../public/assets/notfound.jpg";  ?>" alt="">
                        <div class="desc">
                            <p>Descrição</p>
                            <h6><?php echo $produto ['PRODUTO_DESC']?></h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php } ?>
            <?php } ?>
        </section>
    </main>

    <script>
        function confirmDelete(id) {
            if (confirm("Você tem certeza que deseja excluir este produto?")) {
                window.location.href = "produtos.php?id=" + id;
            }
        }

    </script>
</body>
</html>