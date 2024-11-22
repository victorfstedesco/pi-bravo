<?php 
session_start();

try {
    require_once('../public/php/conexao.php');  // Inclui o arquivo de conexão

    $usuario = $_POST['nome'];  // Recebe o nome ou e-mail do formulário
    $senha = $_POST['senha'];  // Recebe a senha do formulário

    // Verifica se o valor inserido no campo de nome parece um e-mail
    if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        // Se for um e-mail, consulta com o e-mail
        $sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :usuario AND ADM_SENHA = :senha AND ADM_ATIVO = 1";
    } else {
        // Se for nome, consulta com o nome
        $sql = "SELECT * FROM ADMINISTRADOR WHERE ADM_NOME = :usuario AND ADM_SENHA = :senha AND ADM_ATIVO = 1";
    }

    $query = $pdo->prepare($sql);  // Prepara a consulta SQL
    $query->bindParam(':usuario', $usuario, PDO::PARAM_STR);  // Vincula o nome ou e-mail ao parâmetro
    $query->bindParam(':senha', $senha, PDO::PARAM_STR);  // Vincula a senha ao parâmetro
    $query->execute();  // Executa a consulta

    if ($query->rowCount() > 0) {  // Se a consulta retornar algum usuário
        $admin = $query->fetch(PDO::FETCH_ASSOC);  // Obtém os dados do administrador
        $_SESSION['admin_logado'] = $admin;  // Armazena os dados do administrador na sessão
        header('Location: menu.php');  // Redireciona para a página do menu
        exit;
    } else {
        $_SESSION['mensagem_erro'] = "Nome de usuário ou Senha incorreto";  // Mensagem de erro
        header('Location: login.php?erro');  // Redireciona de volta para o login
        exit;
    }
} catch (Exception $e) {
    $_SESSION['mensagem_erro'] = "Erro de conexão: " . $e->getMessage();  // Mensagem de erro em caso de exceção
    header('Location: login.php?erro');  // Redireciona para o login em caso de erro
    exit;
}
?>