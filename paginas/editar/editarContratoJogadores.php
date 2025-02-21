<?php

include_once '../../config.php';

$sql = "SELECT * FROM jogadores ORDER BY jogadores.nome ASC";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM clubes ORDER BY clubes.nome ASC";
$result2 = $conn->query($sql2);

$sql3 = "SELECT contratojogadores.id, jogadores.nome AS jogador, clubes.nome AS clube, contratojogadores.inicioContrato, contratojogadores.fimContrato FROM contratojogadores JOIN jogadores ON jogadores.idJogador = contratojogadores.idJogador JOIN clubes ON clubes.idClube = contratojogadores.idClube ORDER BY jogadores.nome ASC;";
$result3 = $conn->query($sql3);

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

$idt = filter_input(INPUT_GET, 'id');
if ($idt) {
    $sql = "SELECT * 
            FROM contratojogadores   
            WHERE id = $idt";

    $result = $conn->query($sql);
    $result->execute();
    if ($result->rowCount() > 0) {
        $reg_update = $result->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: ../contratojogadores.php");
        exit;
    }
} else {
    header("Location: ../contratojogadores.php");
    exit;
}

$sql_jog = "SELECT * FROM contratojogadores WHERE id = $idt";
$res_jog = $conn->query($sql_jog);

if($res_jog->rowCount()>0){
    $reg_jog = $res_jog->fetch(PDO::FETCH_ASSOC);
}

$sql_nomedovagabundo = "SELECT * FROM jogadores WHERE idJogador = ".$reg_jog['idJogador'];
$res_vagabundo = $conn->query($sql_nomedovagabundo);

if($res_vagabundo->rowCount()>0){
    $vaga = $res_vagabundo->fetch(PDO::FETCH_ASSOC);
}

$sql_nomedovagabundo2 = "SELECT * FROM clubes WHERE idClube = ".$reg_jog['idClube'];
$res_vagabundo2 = $conn->query($sql_nomedovagabundo2);
if($res_vagabundo2->rowCount()>0){
    $vaga2 = $res_vagabundo2->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['submit'])){
    $jogador = $_POST['idJogador'];
    $clube = $_POST['idClube'];
    $inicio = $_POST['inicioContrato'];
    $fim = $_POST['fimContrato'];

    $sql_edita = "UPDATE contratojogadores SET idJogador = $jogador,idClube = $clube, inicioContrato = '$inicio', fimContrato = '$fim' WHERE id = $idt";
    $res_edita = $conn->query($sql_edita);

    header('Location: ../contratojogadores.php');

}

if(isset($_POST['submita'])){
    $sql_del = "DELETE FROM contratojogadores WHERE id = $idt";
    $res_del = $conn->query($sql_del);

    header('Location: ../contratojogadores.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contratos dos Jogadores | TwoFootball</title>
    <link rel="stylesheet" href="styles/editarContratos.css">
    <link rel="stylesheet" href="../../styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../../imagens/logoNoTitle.png" type="image/png">
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


            <img src="../../imagens/logo.png">

            <label for="idJogador" style="padding-top: 10px;">
                <p class="paragrafo">Jogador:<strong>*</strong></p>
            </label>
            <select name="idJogador">
            <option value="<?= $reg_jog['idJogador']; ?>"><?= $vaga['nome']; ?></option>
                <?php foreach ($result as $reg) : ?>
                    <option value="<?= $reg['idJogador']; ?>"><?= $reg['nome']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="idClube">
                <p class="paragrafo">Clube:<strong>*</strong></p>
            </label>
            <select name="idClube">
            <option value="<?= $reg_jog['idClube']; ?>"><?= $vaga2['nome']; ?></option>
                <?php foreach ($result2 as $reg2) : ?>
                    <option value="<?= $reg2['idClube']; ?>"><?= $reg2['nome']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="inicioContrato">
                <p class="paragrafo">Início do Contrato:<strong>*</strong></p>
            </label>
            <input type="date" value="<?=$reg_jog['inicioContrato']?>" name="inicioContrato">

            <label for="fimContrato">
                <p class="paragrafo">Fim do Contrato:<strong>*</strong></p>
            </label>
            <input type="date" name="fimContrato" value="<?=$reg_jog['fimContrato']?>" style="margin-bottom: 40px;">

            <?php
            if ($login) {
                echo ' <input id="adicionar" type="submit" value="EDITAR CONTRATO" name="submit" style="margin-top: 5px;">
                <input id="adicionar" type="submit" value="APAGAR CONTRATO" name="submita" style="margin-top: 5px;">';
            } else {
                echo ' <input id="adicionar" type="submit" value="EDITAR CONTRATO" name="submit" style="margin-top: 5px;" disabled>
                <input id="adicionar" type="submit" value="APAGAR CONTRATO" name="submita" style="margin-top: 5px;" disabled>';
            }
            ?>

        </form>
    </div>

</body>

</html>