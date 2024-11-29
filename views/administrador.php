<?php
session_start();
require_once('../public/php/conexao.php');

if(!isset($_SESSION['admin_logado'])){
    header ("Location:login.php");
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE ADM_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: administrador.php");
        exit(); 
    } catch (PDOException $e) {
        header("Location: administrador.php");
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

    <link rel="stylesheet" href="../public/css/administrador.css"> <!-- css do arquivo -->

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
        <section>
            <div class="content-header">
                <h4>Ambiente do administrador</h4>
                <!-- <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" required />
                    <button type="submit">
                        <img src="../public/assets/lupa.svg" alt="search">
                    </button>
                </form> -->
                <a href="./administrador-cadastrar.php"><button class="button1">Cadastrar administrador</button>  </a>  
            </div>
            <div class="container-tabela">
                <?php if ($administradores) { 
                foreach ($administradores as $administrador) { ?>
                <div class="card">
                    <div class="status">
                        <p class="titulo-col">Status</p>
                        <?php if($administrador ['ADM_ATIVO'] >= 1){ ?>
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
                        <h6><?php echo $administrador ['ADM_ID']?></h6>
                    </div>
                    <div id="nome">
                        <p class="titulo-col">Nome</p>
                        <h6><?php echo $administrador ['ADM_NOME']?></h6>
                    </div>
                    <div id="e-mail">
                        <p class="titulo-col">E-mail</p>
                        <h6><?php echo $administrador ['ADM_EMAIL']?></h6>
                    </div>
                    <div id="senha">
                        <p class="titulo-col">Senha</p>
                        <h6><?php echo $administrador ['ADM_SENHA']?></h6>
                    </div>
                    <div class="barra"></div>
                    <div class="acoes">
                        <a href="./administrador-editar.php?id=<?php echo $administrador['ADM_ID']?>"><img src="../public/assets/editar.svg" alt=""></a>
                        <a href="#" onclick="confirmDelete(<?php echo $administrador['ADM_ID']; ?>);"><img src="../public/assets/excluir.svg" alt=""></a>
                    </div>
                </div>
            </div>
            
            <?php } ?>
            <?php } ?>
        </section>
    </main>

    <script>
        function confirmDelete(id) {
            if (confirm("Você tem certeza que deseja excluir este administrador?")) {
                window.location.href = "administrador.php?id=" + id;
            }
        }
    </script>
</body>
</html>