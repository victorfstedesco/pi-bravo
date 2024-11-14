<?php
session_start();
require_once('../php/conexao.php');

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

    <link rel="stylesheet" href="./administrador.css"> <!-- css do arquivo -->

    <link rel="stylesheet" href="../css/tipografia.css"> <!-- css externo -->
    <link rel="stylesheet" href="../css/main.css"> <!-- css externo -->

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
            <img src="./assets/logo-minimalista.svg" alt="">
        </header>
        <!--fim do 'componente' header-->
        <section>
            <div class="content-header">
                <h4>Ambiente do administrador</h4>
                <form method="POST" class="pesquisa-form">
                    <input type="text" placeholder="Buscar administrador" name="adm_nome" required />
                    <button type="submit">
                        <img src="./assets/lupa.svg" alt="search">
                    </button>
                </form>
                <button class="button1">Cadastrar adminsitrador</button>    
            </div>
            <div class="divisoria"></div>
            <div class="container-tabela">
                <div class="card">
                    <div class="status">
                        <p class="titulo-col">Status</p>
                        <div class="ativado">
                            <img src="../ativado.svg" alt="">
                            <p>Ativado</p>
                        </div>
                    </div>
                    <div class="barra"></div>
                    <div id="id">
                        <p class="titulo-col">ID</p>
                        <h6>113</h6>
                    </div>
                    <div id="nome">
                        <p class="titulo-col">Nome</p>
                        <h6>Emernostrildo da Silva e Lima</h6>
                    </div>
                    <div id="e-mail">
                        <p class="titulo-col">E-mail</p>
                        <h6>name@example.com.br</h6>
                    </div>
                    <div id="senha">
                        <p class="titulo-col">Senha</p>
                        <h6>$2y$10$TuQRpIDAh2nGGPxMBMAriO5iRmX2pw4G0B4YZKHP88b31eClXCsIG</h6>
                    </div>
                    <div class="barra"></div>
                    <div class="acoes">
                        <img src="./assets/editar.svg" alt="">
                        <img src="./assets/excluir.svg" alt="">
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>