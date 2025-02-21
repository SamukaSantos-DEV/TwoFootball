<?php

include_once '../../config.php';

$sqll = "SELECT * FROM localizacao ORDER BY localizacao.nome ASC";
$resultl = $conn->query($sqll);

session_start();
if (isset($_SESSION['login'])) {

    if ($_SESSION['login']) {
        $login = true;
        $id = $_SESSION['id'];
        $sql_usu = "SELECT * FROM usuario WHERE id = $id";
        $res_usu = $conn->query($sql_usu);
        $res_usu->execute();

        if ($res_usu->rowCount() > 0) {
            $reg_usu = $res_usu->fetch(PDO::FETCH_ASSOC);
        }
    }
} else {
    $login = false;
}

$idj = filter_input(INPUT_GET, 'idCampeonato');
if ($idj) {
    $sql = "SELECT * 
            FROM campeonato   
            WHERE idCampeonato = $idj";

    $result = $conn->query($sql);
    $result->execute();
    if ($result->rowCount() > 0) {
        $reg_update = $result->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: ../campeonato.php");
        exit;
    }
} else {
    header("Location: ../campeonato.php");
    exit;
}


$sql_jogador = "SELECT * FROM campeonato WHERE idCampeonato = $idj";
$res_jogador = $conn->query($sql_jogador);
$res_jogador->execute();

if ($res_jogador->rowCount() > 0) {
    $reg_update = $res_jogador->fetch(PDO::FETCH_ASSOC);
}

$localizacao = $reg_update['idLocalizacao'];
$sqlLocal = "SELECT localizacao.nome FROM localizacao WHERE localizacao.idLocalizacao = '$localizacao'";
$resultadoLocal = $conn->query($sqlLocal);
$resultadoLocal->execute();

if ($resultadoLocal->rowCount() > 0) {
    $sla = $resultadoLocal->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $localizacao = $_POST['localizacao'];

    $SQLdados = "UPDATE campeonato SET nome = '$nome', idLocalizacao = '$localizacao' WHERE idCampeonato = $idj";

    $resDados = $conn->query($SQLdados);
    $resDados->execute();
    header('Location: ../campeonato.php');
}

if (isset($_POST['editarImagem'])) {
    $extensao = strtolower(substr($_FILES['fotoPerfil']['name'], -4));
    $novo_nome = md5(time()) . $extensao;
    $diretorio = "../../imagens/FotoCampeonato/";
    move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $diretorio . $novo_nome);

    $sql_foto = "UPDATE campeonato SET logo = '$novo_nome' WHERE idCampeonato = $idj";
    $res_foto = $conn->query($sql_foto);
    $res_foto->execute();

    header('Location: ../campeonato.php');
}
if (isset($_POST['submita'])) {

    $sql_delJogador = "DELETE FROM campeonato WHERE idCampeonato = $idj";
    $res_delJogador = $conn->query($sql_delJogador);
    $res_delJogador->execute();

    header('Location: ../campeonato.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Campeonatos | TwoFootball</title>
    <link rel="stylesheet" href="styles/editarCampeonato.css">
    <link rel="stylesheet" href="../../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../../imagens/logoNoTitle.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>

    <nav style="margin-top: 0px;" id="menu" class="menu" onmouseenter="abrir()" onmouseleave="abrir()">
        <div class="actionbar">
            <div>
                <button id="openMenuSideBar"><img src="../../imagens/logoNoTitle.png" width="40px"></button>
                <h3 class="menuText" id="sidebarTitle">TWOFOOTBALL</h3>
                <i class="fas fa-chevron-right" style="margin-left: -5px;"></i>
            </div>
        </div>
        <ul class="optionsBar">
            <li class="menuItem">
                <a href="../../index.php" class="menuOption" style="color: black;">
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
                <a href="../../paginas/jogadores.php" class="menuOption">
                    <button id="productManagerBtn" class="menuOption">
                        <span class="material-symbols-outlined">
                            sprint
                        </span>
                        <h5 class="menuText">Jogadores</h5>
                    </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../../paginas/clube.php">
                <button id="constantManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports_soccer
                    </span>
                    <h5 class="menuText">Clubes</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../../paginas/tecnico.php">
                <button id="orderManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports
                    </span>
                    <h5 class="menuText">Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../../paginas/campeonato.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        emoji_events
                    </span>
                    <h5 class="menuText">Campeonatos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../../paginas/contratojogadores.php">
                    <button id="tagManagerBtn" class="menuOption">
                        <span class="material-symbols-outlined">
                            contract
                        </span>
                        <h5 class="menuText">Contratos | Jogadores</h5>
                    </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../../paginas/contratotecnicos.php">
                    <button id="tagManagerBtn" class="menuOption">
                        <span class="material-symbols-outlined">
                            contract
                        </span>
                        <h5 class="menuText">Contratos | Técnicos</h5>
                    </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="../desenvolvedores.php">
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
            if ($login) {
                echo '<a href="../../usuario/usuario.php">';
                echo '<div>';
                echo '<img src="../../imagens/FotoPerfil/' . $reg_usu['fotoPerfil'] . '" alt="">';
                echo '</div>
                <h5 id="nomeUsuario" class="Username menuText">' . $reg_usu['nome'] . '</h5>
                </a>';
            } else {
                echo '<a href="../login.php">
                <div>
                    <img src="../../imagens/usuarioNoLogin.png" alt="">
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

    <div id="formulario">
        <form action="" method="post">

            <img src="../../imagens/logo.png" style="margin-left: 50px; margin-bottom: -5px;" width="400px">

            <label for="fotoPerfil" style="margin-top: 5px; margin-bottom: 5px;">Logo:<strong>*</strong></label>

            <p id="abrirEditarFoto" onclick="abrirEditarFoto()" style="cursor: pointer;">Clique aqui para editar a foto*</p>

            <label for="nome" style="padding-top: 0px;">
                <p class="paragrafo">Nome:<strong>*</strong></p>
            </label>
            <input class="cxdt" type="text" name="nome" placeholder="Ex: Champions League" value="<?= $reg_update['nome'] ?>" required />

            <label for="localizacao">
                <p>Localização:<strong>*</strong></p>
            </label>
            <select name="localizacao">
                <option value="<?= $reg_update['idLocalizacao']; ?>">
                    <?= $sla['nome'] ?>
                </option>
                <?php foreach ($resultl as $regl) : ?>
                    <option value="<?= $regl['idLocalizacao']; ?>"><?= $regl['nome']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php
            if ($login) {
                echo ' <input id="adicionar" type="submit" value="EDITAR CAMPEONATO" name="submit" style="margin-top: 5px;">
                <input id="adicionar" type="submit" value="APAGAR CAMPEONATO" name="submita" style="margin-top: 5px;">';
            } else {
                echo ' <input id="adicionar" type="submit" value="EDITAR CAMPEONATO" name="submit" style="margin-top: 5px;" disabled>
                <input id="adicionar" type="submit" value="APAGAR CAMPEONATO" name="submita" style="margin-top: 5px;" disabled>';
            }
            ?>

        </form>
    </div>

    <script>
        function abrirEditarFoto(){
            document.getElementById('editarFoto').style.display = 'block';
        }
        function fecharEditarFoto(){
            document.getElementById('editarFoto').style.display = 'none';
        }
    </script>

    <div id="editarFoto">
        <form action="" method="post" enctype="multipart/form-data">
            <img src="../../imagens/logo.png" style="margin-left: 100px; margin-bottom: -5px;" width="300px">
            <img src="../../usuario/uploads/x.png" style="margin-left: 40px; margin-bottom: -5px; cursor: pointer;" width="30px" onclick="fecharEditarFoto()">
            <label for="editarFoto">Escolha um arquivo:</label>
            <input class="form-control" type="file" style="margin-top: 5px; margin-left: 13px; margin-bottom: 15px; width: 480px;" name="fotoPerfil" accept=".jpg,.jpeg,.png">
            <input id="adicionar" type="submit" value="EDITAR FOTO" name="editarImagem">
        </form>
    </div>

</body>

</html>