<?php
session_start();
include_once '../config.php';

$sql = "SELECT * FROM clubes ORDER BY clubes.nome ASC";
$result = $conn->query($sql);

if($_SESSION['login']){
    $login = true;
    $id = $_SESSION['id'];  
    $sql_usu = "SELECT * FROM usuario WHERE id = $id";
    $res_usu = $conn->query($sql_usu);
    $res_usu->execute();

    if($res_usu->rowCount() > 0){
        $reg_usu = $res_usu->fetch(PDO::FETCH_ASSOC);
    }

    $sql_time = "SELECT * FROM clubes WHERE idClube = ".$reg_usu['clubeFavorito'];
    $res_clube = $conn->query($sql_time);
    $res_clube->execute();

    if($res_clube->rowCount()>0){
        $reg_time = $res_clube->fetch(PDO::FETCH_ASSOC);
    }
}

if(isset($_POST['editarDados'])){
    $email = $_POST['email'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql_dados = "UPDATE usuario SET nome = '$nome',senha = '$senha', email = '$email' WHERE id = $id";
    $res_dados = $conn->query($sql_dados);
    $res_dados->execute();
    $_SESSION['id'] = $id;

    header('Refresh: 0');

}

if(isset($_POST['imagemPerfil'])){
    $extensao = strtolower(substr($_FILES['fotoPerfil']['name'], -4));
    $novo_nome = md5(time()).$extensao;
    $diretorio = "../imagens/FotoPerfil/";
    move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $diretorio.$novo_nome);

    $sql_imagem = "UPDATE usuario SET fotoPerfil = '$novo_nome'";
    $res_imagem = $conn->query($sql_imagem);
    $res_imagem->execute();

    $_SESSION['id'] = $id;
    header('Refresh: 0');
}

if(isset($_POST['editarTimeCoracao'])){
    $favorito = $_POST['clubeFavorito'];

    $sql_favorito = "UPDATE usuario SET clubeFavorito = '$favorito'";
    $res_favorito = $conn->query($sql_favorito);
    $res_favorito->execute();

    $_SESSION['id'] = $id;
    header('Refresh: 0');
}

if(isset($_POST['sair'])){
    unset($_SESSION['id']);
    unset($_SESSION['login']);

    session_destroy();
    session_abort();

    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | TwoFootball</title>
    <link rel="stylesheet" href="usuario.css">
    <link rel="stylesheet" href="../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../imagens/logoNoTitle.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

    <nav id="menu" class="menu" onmouseenter="abrir()" onmouseleave="abrir()" style="margin-top: 0px;">
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
                <a href="../paginas/jogadores.php" class="menuOption">
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
                <a href="../paginas/desenvolvedores.php">
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
            <?php
            if($login){
                echo '<a href="usuario.php">';
                echo '<div>';
                echo '<img src="../imagens/FotoPerfil/'.$reg_usu['fotoPerfil']. '" alt="">';
                echo '</div>
                <h5 id="nomeUsuario" class="Username menuText">'.$reg_usu['nome'].'</h5>
                </a>';
            }else{
                echo '<a href="../paginas/login.php">
                <div>
                    <img src="../imagens/usuarioNoLogin.png" alt="">
                </div>
                <h5 id="nomeUsuario" class="Username menuText">Fazer Login</h5>
            </a>';
            }
            ?>
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

    <div id="all">
        <div id="infoUsuario" style="pointer-events: none;">
            <img src="../imagens/FotoPerfil/<?=$reg_usu['fotoPerfil']?>" alt="foto de perfil do usuario">
        </div>
        <h1 style="text-align: center; font-family: 'Poppins'; font-weight: bolder; margin-top: 5px;"><?=$reg_usu['nome']?></h1>
        <h3 style="text-align: center; font-family: 'Poppins'; font-weight: normal; margin-top: 5px;"><?=$reg_time['nome']?></h3>
        <h5 style="text-align: center; font-family: 'Poppins'; font-weight: lighter; margin-top: -7px;"><?=$reg_usu['email']?></h5>


        <div class="dropdown">
            <span style="user-select: none;">CONFIGURAÇÕES</span>
            <div class="dropdown-content" style="margin-top: 15px;">
                <p onclick="abrirEditorDados()">Editar Dados</p>
                <p onclick="abrirImagemPerfil()">Editar Imagem de Perfil</p>
                <p onclick="abrirTime()">Editar Time do Coração</p>
                <form method="post">
                <input type="submit" name="sair" id="botaoSair" value="SAIR"></input>
                </form>
            </div>
        </div>
    </div>

    <script>
        function abrirEditorDados() {
            document.getElementById('editorDados').style.display = "block";
        }

        function fecharEditorDados() {
            document.getElementById('editorDados').style.display = "none";
        }

        function abrirImagemPerfil() {
            document.getElementById('imagemPerfil').style.display = "block";
        }

        function fecharImagemPerfil() {
            document.getElementById('imagemPerfil').style.display = "none";
        }

        function abrirTime() {
            document.getElementById('timeCoracao').style.display = "block";
        }

        function fecharTime() {
            document.getElementById('timeCoracao').style.display = "none";
        }
    </script>

    <div id="editorDados">
        <form action="" method="POST">

            <img src="../imagens/logo.png" width="300px" style="margin: -5px 0px 0px 15px;">
            <img src="uploads/x.png" width="30px" style="margin: -5px 0px 0px 5px; cursor: pointer;" onclick="fecharEditorDados()">

            <label for="nome" style="margin-top: 0px;">
                <p class="paragrafo">Nome:<strong>*</strong></p>
            </label>
            <input class="cxdt" type="text" value="<?=$reg_usu['nome']?>" placeholder="<?=$reg_usu['nome']?>" name="nome" required />

            <label for="email">
                <p class="paragrafo">E-Mail:<strong>*</strong></p>
            </label>
            <input class="cxdt" type="email" value="<?=$reg_usu['email']?>" placeholder="<?=$reg_usu['email']?>" name="email" required />

            <label for="senha">
                <p class="paragrafo">Senha:<strong>*</strong></p>
            </label>
            <input class="cxdt" type="password" value="<?=$reg_usu['senha']?>" placeholder="<?=$reg_usu['senha']?>" name="senha" required />

            <input id="editarDados" type="submit" value="EDITAR DADOS" name="editarDados">
        </form>
    </div>

    <div id="imagemPerfil">

        <form action="" method="post" enctype="multipart/form-data">

            <img src="../imagens/logo.png" width="300px" style="margin: -5px 0px 0px 120px;">
            <img src="uploads/x.png" width="30px" style="margin: -5px 0px 0px 90px; cursor: pointer;" onclick="fecharImagemPerfil()">

            <label for="fotoPerfil" style="margin-top: 0px;">Foto de Perfil:<strong>*</strong></label>

            <input class="form-control" type="file" style="margin-top: 5px;" name="fotoPerfil" style="font-size: 15px; width: 320px;" accept=".jpg,.jpeg,.png" required>
            <input id="imagemPerfilButton" type="submit" value="EDITAR FOTO" name="imagemPerfil">
        </form>
    </div>

    <div id="timeCoracao">
        <form action="" method="POST">

            <img src="../imagens/logo.png" width="300px" style="margin: -5px 0px 0px 15px;">
            <img src="uploads/x.png" width="30px" style="margin: -5px 0px 0px 5px; cursor: pointer;" onclick="fecharTime()">

            <label for="clubeFavorito">
                <p>Time do Coração:<strong>*</strong></p>
            </label>
            <select name="clubeFavorito" id="clubeFavorito">
            <option value="<?= $reg_time['idClube'] ?>"><?= $reg_time['nome']; ?></option>
                <?php foreach ($result as $reg) : ?>
                    <option value="<?= $reg['idClube']; ?>"><?= $reg['nome']; ?></option>
                <?php endforeach; ?>
            </select>

            <input id="editarTimeCoracao" type="submit" value="EDITAR TIME" name="editarTimeCoracao">
        </form>
    </div>



</body>

</html>