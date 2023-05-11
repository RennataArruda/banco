<html>
    <head>
        <title>Cadastro do Animal</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="estilos-css.css"/>
        <link rel="icon" href="img/logo1234.png"/>
    </head>
    <body>
        <nav id= "menu">
            <ul>
                <li><a href="areaCliente.php">Cliente</a></li>
                <li><a href="cadAnimal.php">Animal</a></li>
                <li><a href="areaProd.php">Serviços</a></li>
                <li><a href="areaVenda.php">Vendas</a></li>
            </ul>
        </nav>
        <?php
            ini_set('error_reporting', E_ALL); // mesmo resultado de: error_reporting(E_ALL);
            ini_set('display_errors', 0);
            include('conexao.php');
            //Incluir Animal
            if ($_GET[cond] == 1){
                $nomeDono = $_POST['nome_dono'];
                $nomeAnimal = $_POST['nome_ani'];
                $tipo = $_POST['tipo_ani'];
                $raca = $_POST["raca"];
                $idade = $_POST["idade"];
                $obs = $_POST["obs"];

                $busca_query = mysqli_query($conexao,"SELECT * FROM cliente where nome LIKE '".$nomeDono."' ")or die(mysqli_error());
                $dados = mysqli_fetch_array($busca_query);

                $sql = "INSERT INTO animal (id_dono, nomeAni, tipo, raca, idade, obs) VALUES ( '".$dados["id_cliente"]."', '$nomeAnimal', '$tipo', '$raca', '$idade', '$obs')";
            
                $rs = mysqli_query($conexao, $sql);
                if ($rs){
                    echo "<p>DADOS INSERIDOS COM SUCESSO!</p>";
                    echo "<p><a href='index.php'>MENU</a></p>";
                }
            }
            //Alterar dados
            if ($_GET[cond] == 3){
                $nomeAnimal = $_POST['nome_ani'];
                $tipo = $_POST['tipo_ani'];
                $raca = $_POST["raca"];
                $idade = $_POST["idade"];
                $obs = $_POST["obs"];

                $sql = "UPDATE animal SET nomeAni = '".$nomeAnimal."', tipo = '".$tipo."', raca = '".$raca."', idade = '".$idade."', obs = '".$obs."' WHERE id_dono = '".$_GET["id_dono"]."' AND nomeAni LIKE '".$nomeAnimal."'";
        
                $rs = mysqli_query($conexao, $sql);

                if ($rs){
                    echo "<p>DADOS ATUALIZADOS COM SUCESSO!</p>";
                }

            }

            //Excluir dados
            if ($_GET[cond] == 4){
                $query3 = mysqli_query($conexao,"DELETE FROM animal WHERE id_dono= '".$_GET["id_dono"]."' AND nomeAni LIKE '".$_GET["nomePet"]."'");
                
                if ($query3){
                echo "<p>OS DADOS FORAM EXCLUIDOS</p>";
                }
            }
            
        ?>

        <form class="box" action="cadAnimal.php?cond=1" method="POST">
            
            <fieldset id="animal">
                <label>
                <a href="cadAnimal.php?cond=5">Ver Lista de Clientes</a>
                </label><br>
                <legend>Dados sobre o animal</legend>
                <label>Nome do Dono: </label>
                <select id="nome_dono" name="nome_dono">
                    <?php
                        $exibe = mysqli_query($conexao,"SELECT * FROM cliente LIMIT 20")or die(mysqli_error());
                        while ($dados = mysqli_fetch_array($exibe)){
                            echo "<option value=".$dados["nome"].">".$dados["nome"]."</option><br>";
                        }
                    ?>
                </select><br>
                <!--<input type="text" id="nome_dono" name="nome_dono"><br>-->
                <label>Nome do Pet: </label>
                <input type="text" id="nome_ani" name="nome_ani">
                <label>Tipo: </label>
                <input type="radio" id="tipo" name="tipo_ani" value="Cachorro">
                <label>Cachorro</label>
                <input type="radio" id="tipo" name="tipo_ani" value="Gato">
                <label>Gato</label><br>
                
                <label>Raça: </label>
                <input type="text" id="raca" name="raca">

                <label>Idade:</label>
                <input type="radio" id="idade" name="idade" value="Filhote">
                <label>Filhote</label>
                <input type="radio" id="idade" name="idade" value="Adolescente">
                <label>Adolescente</label>
                <input type="radio" id="idade" name="idade" value="Adulto">
                <label>Adulto</label>
                <input type="radio" id="idade" name="idade" value="Idoso">
                <label>Idoso</label><br>

                <label>Observações</label><br>
                <input type="text" id="obs" name="obs"></textarea><br>
                <input type="submit" value="Cadastrar">
            </fieldset>

        </form>

        <form class="box" action="cadAnimal.php?cond=2" method="POST">
            
            <fieldset id="PesquisaAnimal">
                <label>Pesquisar pelo nome do dono: </label>
                <select id="nome_dono" name="nome_dono">
                    <?php
                        $exibe = mysqli_query($conexao,"SELECT * FROM cliente LIMIT 20")or die(mysqli_error());
                        while ($dados = mysqli_fetch_array($exibe)){
                            echo "<option value=".$dados["nome"].">".$dados["nome"]."</option><br>";
                        }
                    ?>
                </select><br>
                <!--<input type="text" id="pesquisa" name="pesquisa"><br>-->
                <input type="submit" value="Pesquisar">
            </fieldset>

        </form>

        <?php
            if ($_GET[cond] == 2){
                $busca_query = mysqli_query($conexao,"SELECT * FROM cliente where nome LIKE '".$_POST["nome_dono"]."' ")or die(mysqli_error());//faz a busca com as palavras enviadas
                $dados = mysqli_fetch_array($busca_query);
                $envia = $dados["id_cliente"];

                $busca_query_ani = mysqli_query($conexao,"SELECT * FROM animal where id_dono LIKE '".$envia."' ")or die(mysqli_error());
                while ($dadosAni = mysqli_fetch_array($busca_query_ani)){
                    echo "<p>Código do Pet: ".$dadosAni["id_animal"]."</p>";
                    echo "<p>Nome do Dono: ".$dados["nome"]."</p>";
                    echo "<form  class='box' action='cadAnimal.php?cond=3&id_dono=".$envia."' method='POST'>";
                    echo "<fieldset id='animal'>";
                    echo "<legend>Dados sobre o animal</legend>";
                    echo "<label>Nome do Pet: </label>";
                    echo "<input type='text' value='".$dadosAni["nomeAni"]."'id='nome' name='nome_ani'><br>";
                    echo "<label>Tipo: </label>";
                    if ($dadosAni["tipo"] == "Cachorro"){
                        echo "<input type='radio' id='tipo' name='tipo_ani' value='Cachorro' checked >";
                    }else {
                        echo "<input type='radio' id='tipo' name='tipo_ani' value='Cachorro'>";
                    }
                    echo "<label>Cachorro</label>";
                    if ($dadosAni["tipo"] == "Gato"){
                        echo "<input type='radio' id='tipo' name='tipo_ani' value='Gato' checked >";
                    }else {
                        echo "<input type='radio' id='tipo' name='tipo_ani' value='Gato' >";
                    }
                    echo "<label>Gato</label><br>";
                    echo "<label>Raça: </label>";
                    echo "<input type='text' value = '".$dadosAni["raca"]."' id='raca' name='raca'>";
                    if ($dadosAni["idade"] == "Filhote"){
                        echo "<input type='radio' id='idade' name='idade' value='Filhote' checked>";
                    }else {
                        echo "<input type='radio' id='idade' name='idade' value='Filhote'>";
                    }
                    echo "<label>Filhote</label>";
                    if ($dadosAni["idade"] == "Adolescente"){
                        echo "<input type='radio' id='idade' name='idade' value='Adolescente' checked>";
                    }else {
                        echo "<input type='radio' id='idade' name='idade' value='Adolescente'>";
                    }
                    echo "<label>Adolescente</label>";
                    if ($dadosAni["idade"] == "Adulto"){
                        echo "<input type='radio' id='idade' name='idade' value='Adulto' checked>";
                    }else {
                        echo "<input type='radio' id='idade' name='idade' value='Adulto'>";
                    }
                    echo "<label>Adulto</label>";
                    
                    if ($dadosAni["idade"] == "Idoso"){
                        echo "<input type='radio' id='idade' name='idade' value='Idoso' checked>";
                    }else {
                        echo "<input type='radio' id='idade' name='idade' value='Idoso'>";
                    }
                    echo "<label>Idoso</label><br>";
                    echo "<label>Observação: </label>";
                    echo "<input type='text' value='".$dadosAni["obs"]."' id='obs' name='obs'> <br>";
                    echo "</fieldset>";
                    echo "<input type='submit' value='Alterar'></form>";
                    echo "<a href='cadAnimal.php?cond=4&id_dono=".$envia."&nomePet=".$dadosAni["nomeAni"]."'>Excluir</a></form>";
                }
            }

            //exibir nomes de cliente
            if($_GET[cond] == 5){
                $exibe = mysqli_query($conexao,"SELECT * FROM cliente LIMIT 20")or die(mysqli_error());
                echo "<div class='box'>";
                while ($dados = mysqli_fetch_array($exibe)){
                    echo "<p>".$dados["nome"]."</p>";
                }
                echo "</div>";
                
            }
        ?>
        
    </body>
</html>