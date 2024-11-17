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

    <link rel="stylesheet" href="../public/css/ambiente-administrador.css"> <!-- css do arquivo -->

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
        <section>
            <div class="content-header">
                <h4>Ambiente do administrador</h4>
                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" required />
                    <button type="submit">
                        <img src="../public/assets/lupa.svg" alt="search">
                    </button>
                </form>
                <button class="button1">Cadastrar adminsitrador</button>    
            </div>
            <div class="container-tabela">
                <?php if ($administradores) { 
                foreach ($administradores as $administrador) { ?>
                <div class="card">
                    <div class="status">
                        <p class="titulo-col">Status</p>
                        <div class="ativado">
                            <img src="../public/assets/ativado.svg" alt="">
                            <p>Ativado</p>
                        </div>
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
                        <img src="../public/assets/editar.svg" alt="">
                        <img src="../public/assets/excluir.svg" alt="">
                    </div>
                </div>
            </div>
            
            <?php } ?>
            <?php } ?>
        </section>
    </main>
</body>
</html>