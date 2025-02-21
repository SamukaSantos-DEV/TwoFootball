<?php

include_once '../config.php';

$sql = "SELECT * FROM localizacao ORDER BY localizacao.nome ASC";
$result = $conn->query($sql);

$sql2 = "SELECT campeonato.idCampeonato, campeonato.logo, campeonato.nome AS campeonato, localizacao.nome AS localizacao FROM campeonato JOIN localizacao ON localizacao.idLocalizacao = campeonato.idLocalizacao ORDER BY campeonato.nome ASC;";
$result2 = $conn->query($sql2);

session_start();
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
    $nome = $_POST['nome'];
    $localizacao = $_POST['localizacao'];

    if(!empty($_FILES['fotoPerfil'])){
        $extensao = strtolower(substr($_FILES['fotoPerfil']['name'], -4));
        $novo_nome = md5(time()).$extensao;
        $diretorio = "../imagens/FotoCampeonato/";
        move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $diretorio.$novo_nome);
        
        $sql_jogador = "INSERT INTO campeonato (idCampeonato, logo, nome, idLocalizacao) VALUES ('', '$novo_nome', '$nome', '$localizacao');";
        $res_jogador = $conn->query($sql_jogador);

        header('Location: campeonato.php');
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campeonato | TwoFootball</title>
    <link rel="stylesheet" href="styles/campeonato.css">
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
        <div class="col-md-6" id="adicionarCampeonato">
            <form action="" method="post" enctype="multipart/form-data" style="height: 398px;">
            
            <img src="../imagens/logo.png" width="500px" style="margin-bottom: 2px;">

                <label for="fotoPerfil" style="margin-top: 5px;">Logo:<strong>*</strong></label>

                <input class="form-control" type="file" style="margin-top: 5px; margin-left: 13px; margin-bottom: 15px;" name="fotoPerfil" style="font-size: 15px; width: 320px;" accept=".jpg,.jpeg,.png">

                <label for="nome" style="padding-top: 0px;">
                    <p class="paragrafo">Nome:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="text" name="nome" placeholder="Ex: Champions League" required />

                <label for="localizacao">
                    <p>Localização:<strong>*</strong></p>
                </label>
                <select name="localizacao">
                    <option value="">Selecione uma opção</option>
                    <?php foreach ($result as $reg) : ?>
                        <option value="<?= $reg['idLocalizacao']; ?>"><?= $reg['nome']; ?></option>
                    <?php endforeach; ?>
                </select>

                <?php
                if($login){
                    echo '<input id="adicionar" type="submit" value="ADICIONAR" style="margin-top: 0px;" name="submit">';
                }else{
                    echo '<input id="adicionar" type="submit" value="ADICIONAR" name="alertar" style="margin-top: 0px;" onclick="alertLogin()">';
                }
                ?>

                <script>
                    function alertLogin(){
                        alert("Faça login antes de adicionar itens!")
                    }
                </script>

                </form>
        </div>
        <div class="col-md-6" id="tabelaCampeonato">
            <div id="tabelaRegistros">
                <table>
                    <thead id="topoTable">
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody id="corpoTable">
                        <?php foreach ($result2 as $reg2) : ?>
                            <tr>
                                <td><img src="../imagens/FotoCampeonato/<?= $reg2['logo']; ?>" width="50px"></td>
                                <td><?= $reg2['campeonato']; ?></td>
                                <td><?= $reg2['localizacao']; ?></td>

                                <td>
                                    <a href="editar/editarCampeonato.php?idCampeonato=<?= $reg2['idCampeonato']; ?>" class="btn btn-warning">EDITAR / DELETAR</a>
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