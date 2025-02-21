<?php

include_once '../config.php';

$sql = "SELECT * FROM tecnicos ORDER BY tecnicos.nome ASC";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM clubes ORDER BY clubes.nome ASC";
$result2 = $conn->query($sql2);

$sql3 = "SELECT contratotecnicos.id, tecnicos.nome AS tecnico, clubes.nome AS clube, contratotecnicos.incioContrato, contratotecnicos.fimContrato FROM contratotecnicos JOIN tecnicos ON tecnicos.idTecnico = contratotecnicos.idTecnico JOIN clubes ON clubes.idClube = contratotecnicos.idClube ORDER BY contratotecnicos.id;";
$result3 = $conn->query($sql3);

session_start();
include_once '../config.php';
if(isset($_SESSION['login'])){

    if($_SESSION['login']){
        $login = true;
        $id = $_SESSION['id'];  
        $sql_usu = "SELECT * FROM usuario WHERE id = $id";
        $res_usu = $conn->query($sql_usu);
        $res_usu->execute();
    
        if($res_usu->rowCount() > 0){
            $reg_usu = $res_usu->fetch(PDO::FETCH_ASSOC);
        }
    }
}else{
    $login = false;
}

if(isset($_POST['submit'])){
    $idTecnico = $_POST['idTecnico'];
    $idClube = $_POST['idClube'];
    $icon = $_POST['inicioContrato'];
    $fcon = $_POST['fimContrato'];

    $sql_contrato = "INSERT INTO contratotecnicos(id,idClube,idTecnico,incioContrato,fimContrato) VALUES('','$idClube','$idTecnico','$icon','$fcon')";
    $res_contrato = $conn->query($sql_contrato);

    header('Location: contratotecnicos.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contratos de Jogadores | TwoFootball</title>
    <link rel="stylesheet" href="styles/contratos.css">
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
        <?php
            if($login){
                echo '<a href="../usuario/usuario.php">';
                echo '<div>';
                echo '<img src="../imagens/FotoPerfil/'.$reg_usu['fotoPerfil']. '" alt="">';
                echo '</div>
                <h5 id="nomeUsuario" class="Username menuText">'.$reg_usu['nome'].'</h5>
                </a>';
            }else{
                echo '<a href="login.php">
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

    <div class="row">
        <div class="col-md-6" id="adicionarJogador">
            <form action="" method="post">

                <img src="../imagens/logo.png">

                <label for="idTecnico" style="padding-top: 10px;">
                    <p class="paragrafo">Técnico:<strong>*</strong></p>
                </label>
                <select name="idTecnico">
                    <?php foreach ($result as $reg) : ?>
                        <option value="<?= $reg['idTecnico']; ?>"><?= $reg['nome']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="idClube">
                    <p class="paragrafo">Clube:<strong>*</strong></p>
                </label>
                <select name="idClube">
                    <?php foreach ($result2 as $reg2) : ?>
                        <option value="<?= $reg2['idClube']; ?>"><?= $reg2['nome']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="inicioContrato">
                    <p class="paragrafo">Início do Contrato:<strong>*</strong></p>
                </label>
                <input type="date" name="inicioContrato">

                <label for="fimContrato">
                    <p class="paragrafo">Fim do Contrato:<strong>*</strong></p>
                </label>
                <input type="date" name="fimContrato" style="margin-bottom: 25px;">

                <?php
                if($login){
                    echo '<input id="adicionar" type="submit" value="ADICIONAR" style="margin-top: -5px;" name="submit">';
                }else{
                    echo '<input id="adicionar" type="submit" value="ADICIONAR" name="alertar" style="margin-top: -5px;" onclick="alertLogin()">';
                }
                ?>

                <script>
                    function alertLogin(){
                        alert("Faça login antes de adicionar itens!")
                    }
                </script>

            </form>
        </div>
        <div class="col-md-6" id="tabelaJogador">
            <div id="tabelaRegistros">
                <table>
                    <thead id="topoTable">
                        <tr>
                            <th>Técnico</th>
                            <th>Clube</th>
                            <th>Início Contrato</th>
                            <th>Fim Contrato</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody id="corpoTable">
                        <?php foreach ($result3 as $reg3) : ?>
                            <tr>
                                <td><?= $reg3['tecnico']; ?></td>
                                <td><?= $reg3['clube']; ?></td>
                                <td><?= $reg3['incioContrato']; ?></td>
                                <td><?= $reg3['fimContrato']; ?></td>

                                <td>
                                    <a href="editar/editarContratoTecnicos.php?id=<?= $reg3['id']; ?>" class="btn btn-warning">EDITAR /<br>DELETAR</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>