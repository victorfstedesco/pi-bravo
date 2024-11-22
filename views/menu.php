<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/menu.css"> <!-- css do arquivo -->

    <link rel="stylesheet" href="../public/css/tipografia.css"> <!-- css externo -->
    <link rel="stylesheet" href="../public/css/main.css"> <!-- css externo -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <section>
            <img src="../public/assets/logo completo 1.svg" alt="" class="logo">
            <div class="bem-vindo">
                <h5>Bem vindo 'nome'</h5>
                <div class="finalizar-sessao">
                    <a href="./login.php">
                        <p>Finalizar sessão</p>
                    </a>
                    <img src="./assets/sair.svg" alt="">
                </div>
            </div>
            <div class="direcionamentos">
                <div onclick="window.location.href='administrador.php'" class="card">
                    <img src="../public/assets/administrador.svg" alt="">
                    <h3>Ambiente do Administrador</h3>
                    <p>Configuração geral de todos os administradores.</p> 
                </div>
                <div onclick="window.location.href='categoria.php'" class="card">
                    <img src="../public/assets/categoria.svg" alt="">
                    <h3>Ambiente de categoria</h3>
                    <p>Cadastrar uma categoria para adicionar ao produto</p>
                </div>
                <div onclick="window.location.href='produtos.php'" class="card">
                    <img src="../public/assets/produtos.svg" alt="">
                    <h3>Ambiente de produtos</h3>
                    <p>Gerenciamento geral de todos os produtos do banco de dados</p>
                </div>
            </div>
            <p class="descricao">Esse aplicativo tem como o intuito acadêmico. Qualquer dúvida entre em contato com os desenvolvedores.</p>
        </section>
    </main>
</body>
</html>