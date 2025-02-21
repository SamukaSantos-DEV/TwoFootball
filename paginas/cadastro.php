<?php
session_start();
include_once '../config.php';

$sql = "SELECT * FROM clubes ORDER BY clubes.nome ASC";
$result = $conn->query($sql);

if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $favorito = $_POST['clubeFavorito'];

    if(!empty($_FILES['fotoPerfil'])){
        $extensao = strtolower(substr($_FILES['fotoPerfil']['name'], -4));
        $novo_nome = md5(time()).$extensao;
        $diretorio = "../imagens/FotoPerfil/";
        move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $diretorio.$novo_nome);
        $sql_cadastro = "INSERT INTO usuario(id,nome,email,senha,fotoPerfil,ClubeFavorito) VALUES('','$nome','$email','$senha','$novo_nome','$favorito')";
        $resultado_cadastro = $conn->query($sql_cadastro);

        $sql_id = "SELECT * FROM usuario WHERE email = '$email' and senha = '$senha'";
        $res_id = $conn->query($sql_id);
        $res_id->execute();
        if($res_id->rowCount()>0){
            $reg_id = $res_id->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $reg_id['id'];
        }
        $_SESSION['login'] = true;

        header('Location: ../usuario/usuario.php');


    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | TwoFootball</title>
    <link rel="stylesheet" href="styles/cadastro.css">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../imagens/logoNoTitle.png" type="image/png">
</head>

<body>

<nav id="menu" class="menu" style="margin-top: 0px;"  onmouseenter="abrir()" onmouseleave="abrir()">
        <div class="actionbar">
            <div>
                <button id="openMenuSideBar"><img src="../imagens/logoNoTitle.png" width="40px"></button>
                <h3 class="menuText" id="sidebarTitle">TWOFOOTBALL</h3>
                <i class="fas fa-chevron-right" style="margin-left: -5px;"></i>
            </div>
        </div>
        <ul class="optionsBar">
            <li class="menuItem">
                <a href="../index.php" class="menuOption" style="color: black;">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                    <h5 class="menuText">Início</h5>
                </a>
            </li>
            <li class="menuBreak">
                <hr>
            </li>
            <li class="menuItem">
                <a href="../paginas/jogadores.php" class="menuOption" style="color: black;">
                <button id="productManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sprint
                    </span>
                    <h5 class="menuText">Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/clube.php">
                <button id="constantManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports_soccer
                    </span>
                    <h5 class="menuText">Clubes</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/tecnico.php">
                <button id="orderManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports
                    </span>
                    <h5 class="menuText">Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/campeonato.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        emoji_events
                    </span>
                    <h5 class="menuText">Campeonatos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/contratojogadores.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../paginas/contratotecnicos.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="desenvolvedores.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        code
                    </span>
                    <h5 class="menuText">Desenvolvedores</h5>
                </button>
                </a>
            </li>
        </ul>
        <div class="menuUser">
            <a href="login.php">
                <div>
                    <img src="../imagens/usuarioNoLogin.png" alt="">
                </div>
                <h5 id="nomeUsuario" class="Username menuText">Fazer Login</h5>
            </a>
        </div>
    </nav>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const openMenuSideBar = document.getElementById('openMenuSideBar');
        const menu = document.getElementById('menu');
        const menuText = document.querySelectorAll('.menuText');

        function abrir() {
            menu.classList.toggle('open');
            menuText.forEach(function(text, index) {
                setTimeout(() => {
                    text.classList.toggle('open2');
                }, index * 50);
            })
        }
    </script>

    <div class="row">
        <div class="col-md-6" id="imgLogin">
            <img src="imagens/cadastro.png" width="370px" style="float: right; border-radius: 35px 0px 0px 35px;">
        </div>
        <div class="col-md-6" id="dadosLogin">
            <form action="" method="post" enctype="multipart/form-data">

                <img src="../imagens/logo.png" width="290px">

                <label for="nome">
                    <p class="paragrafo">Nome:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="text" placeholder=" Ex: João Silva" name="nome" required />

                <label for="email">
                    <p class="paragrafo">E-Mail:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="email" placeholder=" Ex: joao.silva@gmail.com" name="email" required />

                <label for="senha">
                    <p class="paragrafo">Senha:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="password" placeholder="Insira sua senha" name="senha" required />

                <label for="fotoPerfil">Foto de Perfil:<strong>*</strong></label>

                <input class="form-control" type="file" style="margin-top: 5px;" name="fotoPerfil" style="font-size: 15px; width: 320px;" accept=".jpg,.jpeg,.png">

                <label for="clubeFavorito">
                    <p>Time do Coração:<strong>*</strong></p>
                </label>
                <select name="clubeFavorito" id="clubeFavorito">
                    <option value="">Selecione um clube</option>
                    <?php foreach ($result as $reg) : ?>
                        <option value="<?= $reg['idClube']; ?>"><?= $reg['nome']; ?></option>
                    <?php endforeach; ?>
                </select>

                <input id="salvar" type="submit" value="CADASTRAR" name="submit">
                <h5>Já tem uma conta?<a href="login.php"> Faça Login</a></h5>

            </form>
        </div>
    </div>


</body>

</html>