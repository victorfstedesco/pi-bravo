<?php 
session_start();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../public/css/login.css"> <!-- Adapte esse CSS para seu layout -->
    <link rel="stylesheet" href="../public/css/tipografia.css">
    <link rel="stylesheet" href="../public/css/main.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="image-section">
            <!-- <img class="capa" src="../public/assets/foto-login.jpeg" alt="Imagem tela de login"> -->
        </div>

        <div class="form-section">
            <img src="../public/assets/logo-minimalista.svg" alt="Logo" class="logo">
            <h2>Faça login na sua conta</h2>
            <form action="processa-login.php" method="post">
                <div class="div-input">
                    <label for="nome">Nome ou E-mail</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                
                <div class="div-input">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <?php 
                    if (isset($_SESSION['mensagem_erro'])) {
                        echo "<div class='error-message-container'>";
                        echo "<p class='mensagem-erro'>" . $_SESSION['mensagem_erro'] . "</p>";
                        echo "</div>";
                        unset($_SESSION['mensagem_erro']); // Limpa a mensagem após exibição
                    }
                ?>
                
                <button class="button2" type="submit">Entrar</button>
            </form>
        </div>

        <!-- Exibe a mensagem de erro aqui, logo abaixo do formulário -->
    </div>
</body>
</html>