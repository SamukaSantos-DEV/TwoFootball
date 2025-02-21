<?php
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

$sql = "SELECT tecnicos.idTecnico, tecnicos.fotoPerfil, tecnicos.nome, COALESCE(clubes.nome, 'Nenhum') AS clube, clubes.logo FROM tecnicos LEFT JOIN contratotecnicos ON contratotecnicos.idTecnico = tecnicos.idTecnico LEFT JOIN clubes ON contratotecnicos.idClube = clubes.idClube ORDER BY COALESCE(tecnicos.nome, 0) ASC, tecnicos.nome;";
$result = $conn->query($sql);

if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $extensao = strtolower(substr($_FILES['fotoPerfil']['name'], -4));
    $novo_nome = md5(time()).$extensao;
    $diretorio = "../imagens/FotoTecnico/";
    move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $diretorio.$novo_nome);
    
    $sql_tec = "INSERT INTO tecnicos(idTecnico,nome,fotoPerfil) VALUES('','$nome','$novo_nome')";
    $res_tec = $conn->query($sql_tec);

    header('Location: tecnico.php');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnico | TwoFootball</title>
    <link rel="stylesheet" href="styles/tecnico.css">
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
        <div class="col-md-6" id="adicionarTecnico">
            <form action="" method="post" enctype="multipart/form-data">

            <img src="../imagens/logo.png" width="300px" style="margin-top: 10px; margin-left: 20px;">

                <label for="nome" style="padding-top: 10px;">
                    <p class="paragrafo">Nome:<strong>*</strong></p>
                </label>
                <input class="cxdt" type="text" placeholder=" Ex: Marcelo Fernandes" name="nome" required />

                <label for="fotoPerfil">Foto:<strong>*</strong></label>

                <input class="form-control" type="file" style="margin-top: 5px; margin-left: 13px; margin-bottom: 15px;" name="fotoPerfil" style="font-size: 15px; width: 320px;" accept=".jpg,.jpeg,.png">
                
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
        <div class="col-md-6" id="tabelaTecnico">
            <div id="tabelaRegistros">
                <table>
                    <thead id="topoTable">
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Clube</th>
                            <th>Foto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody id="corpoTable">
                        <?php foreach ($result as $reg) : ?>
                            <tr>
                                <td><img src="../imagens/FotoTecnico/<?= $reg['fotoPerfil']; ?>" width="50px"></td>
                                <td><?= $reg['nome']; ?></td>
                                <td><?= $reg['clube']; ?></td>
                                <td><img src="../imagens/FotosClube/<?= $reg['logo']; ?>" alt="Sem Clube" width="50px"></td>

                                <td>
                                    <a href="editar/editarTecnico.php?idTecnico=<?= $reg['idTecnico']; ?>" class="btn btn-warning">EDITAR / DELETAR</a>
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
