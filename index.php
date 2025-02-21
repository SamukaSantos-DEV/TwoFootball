<?php
session_start();
include_once 'config.php';
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

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | TwoFootball</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/sidebar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="imagens/logoNoTitle.png" type="image/png">
</head>

<?php
require_once 'config.php';

$sql = "SELECT jogadores.fotoPerfil, jogadores.nome, jogadores.idade, jogadores.numCamisa, jogadores.posicao, clubes.logo FROM jogadores JOIN contratojogadores ON contratojogadores.idJogador = jogadores.idJogador JOIN clubes ON contratojogadores.idClube = clubes.idClube WHERE contratojogadores.id = ( SELECT MAX(id) FROM contratojogadores WHERE idJogador = jogadores.idJogador ) ORDER BY contratojogadores.id DESC, jogadores.nome;";
$result = $conn->query($sql);
$sql2 = "SELECT clubes.logo, clubes.nome, clubes.dataFundacao, localizacao.nome AS localizacao, tecnicos.nome AS tecnico FROM clubes JOIN contratotecnicos ON contratotecnicos.idClube = clubes.idClube JOIN tecnicos ON contratotecnicos.idTecnico = tecnicos.idTecnico JOIN localizacao ON localizacao.idLocalizacao = clubes.idLocalizacao WHERE contratotecnicos.id = (SELECT MAX(id) FROM contratotecnicos WHERE contratotecnicos.idTecnico = tecnicos.idTecnico) ORDER BY contratotecnicos.id DESC, tecnicos.nome;";
$result2 = $conn->query($sql2);
?>

<body>

    <nav id="menu" class="menu" onmouseenter="abrir()" onmouseleave="abrir()">
        <div class="actionbar">
            <div>
                <button id="openMenuSideBar"><img src="imagens/logoNoTitle.png" width="40px"></button>
                <h3 class="menuText" id="sidebarTitle">TWOFOOTBALL</h3>
                <i class="fas fa-chevron-right" style="margin-left: -5px;"></i>
            </div>
        </div>
        <ul class="optionsBar">
            <li class="menuItem">
                <a href="#" class="menuOption" style="color: black;">
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
                <a href="paginas/jogadores.php" class="menuOption">
                <button id="productManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sprint
                    </span>
                    <h5 class="menuText">Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/clube.php">
                <button id="constantManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports_soccer
                    </span>
                    <h5 class="menuText">Clubes</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/tecnico.php">
                <button id="orderManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        sports
                    </span>
                    <h5 class="menuText">Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/campeonato.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        emoji_events
                    </span>
                    <h5 class="menuText">Campeonatos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/contratojogadores.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Jogadores</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/contratotecnicos.php">
                <button id="tagManagerBtn" class="menuOption">
                    <span class="material-symbols-outlined">
                        contract
                    </span>
                    <h5 class="menuText">Contratos | Técnicos</h5>
                </button>
                </a>
            </li>
            <li class="menuItem">
                <a href="paginas/desenvolvedores.php">
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
                echo '<a href="usuario/usuario.php">';
                echo '<div>';
                echo '<img src="imagens/FotoPerfil/'.$reg_usu['fotoPerfil']. '" alt="">';
                echo '</div>
                <h5 id="nomeUsuario" class="Username menuText">'.$reg_usu['nome'].'</h5>
                </a>';
            }else{
                echo '<a href="paginas/login.php">
                <div>
                    <img src="imagens/usuarioNoLogin.png" alt="">
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

    <div class="row" id="inicio">

        <div class="col-md-6" id="divInicio">
            <h1>Explore o Futebol</h1>
            <p class="sobre">Na TwoFootball, você tem acesso à informações sempre atualizadas sobre o mundo do futebol, o melhor esporte do mundo! Aqui, você pode ver informações dos jogadores, clubes, técnicos e campeonatos, além de ter um acesso VIP aos mais recentes e mais antigos contratos de jogadores e técnicos no futebol mundial.</p>
            <a id="aDashboard" href="paginas/jogadores.php">
                <p id="linkDashboard">EXPLORAR AS TABELAS</p>
            </a>
        </div>

        <div class="col-md-6" id="divDashboard">
            <div class="dashboard1">
                <img src="imagens/conhecaosclubes.png" width="480px">
            </div>
        </div>

    </div>

    <div class="row" id="inicio2">

        <div class="col-md-6" id="divPlayersImg">
            <div class="dashboard1">
                <img src="imagens/conhecaosjogadores.png" width="550px">
            </div>
        </div>

        <div class="col-md-6" id="divPlayers">
            <h1>Conheça os Jogadores</h1>
            <p class="sobre">Na TwoFootball, você tem um acesso à todas as tabelas de todos jogadores do futebol. Com elas, você consegue observar todas as informações dos jogadores, em que nelas você mesmo tem a opção de alterá-las ou até mesmo criar seu próprio jogador (Ou até mesmo se cadastrar como um jogador!). Você terá a liberdade de explorar e criar uma vasta gama de jogadores, então VAI PRA CIMA!</p>
            <a id="aDashboard" href="paginas/jogadores.php">
                <p id="linkDashboard">EXPLORAR AS TABELAS</p>
            </a>
        </div>

    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-6" id="rowTabelaJogadores">
            <h5>Principais Jogadores Atualmente</h5>
            <center>
                <div id="tabelaRegistros">
                    <table>
                        <thead id="topoTable">
                            <tr>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Idade</th>
                                <th>Número</th>
                                <th>Posição</th>
                                <th>Clube</th>
                            </tr>
                        </thead>

                        <tbody id="corpoTable">
                            <?php foreach ($result as $reg) : ?>
                                <tr>
                                    <td><img src="imagens/FotoJogador/<?= $reg['fotoPerfil']; ?>" width="70px"></td>
                                    <td><?= $reg['nome']; ?></td>
                                    <td><?= $reg['idade']; ?></td>
                                    <td><?= $reg['numCamisa']; ?></td>
                                    <td><?= $reg['posicao']; ?></td>
                                    <td><img src="imagens/FotosClube/<?= $reg['logo']; ?>" width="62px"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </div>

        <div class="col-md-6" id="rowTabelaJogadores">
            <h5>Principais Clubes</h5>
            <center>
                <div id="tabelaRegistros">
                    <table>
                        <thead id="topoTable">
                            <tr>
                                <th>Escudo</th>
                                <th>Clube</th>
                                <th>Fundação</th>
                                <th>Localização</th>
                                <th>Técnico Atual</th>
                            </tr>
                        </thead>

                        <tbody id="corpoTable">
                            <?php foreach ($result2 as $reg2) : ?>
                                <tr>
                                    <td><img src="imagens/FotosClube/<?= $reg2['logo']; ?>" width="70px"></td>
                                    <td><?= $reg2['nome']; ?></td>
                                    <td><?= $reg2['dataFundacao']; ?></td>
                                    <td><?= $reg2['localizacao']; ?></td>
                                    <td><?= $reg2['tecnico']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </center>
        </div>
    </div>

    <div id="rodape">
        <h1>Com gratidão, grupo JJBS!</h1>
        <p>Site inspirado no WebSite e App ONEFOOTBALL</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>