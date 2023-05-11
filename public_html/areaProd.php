<html>
    <head>
        <title>Área dos Serviços</title>
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

            include("conexao.php");
            
            //inserir SQL
            if($_GET[cond] == 1){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];
                $valor = $_POST["valor"];
                
            
                $sql = "INSERT INTO servico (nome, descricao, valor) VALUES ( '$nome', '$descricao', '$valor')";
                $rs = mysqli_query($conexao, $sql);
                if ($rs){
                    echo "<p>DADOS INSERIDOS COM SUCESSO!</p>";                 
                }    
                
            }   
            //alterar SQL
            if($_GET[cond] == 3){                
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];
                $valor = $_POST["valor"];

                $sql = "UPDATE servico SET nome = '".$nome."', descricao = '".$descricao."', valor = '".$valor."' WHERE id_serv = '".$_GET["id_serv"]."'";
       
                $rs = mysqli_query($conexao, $sql);
                
                if ($rs){
                    echo "<p>DADOS ATUALIZADOS COM SUCESSO!</p>";
                }
            }
            //excluir SQL
            if($_GET[cond] == 4){
                $query3 = mysqli_query($conexao,"DELETE FROM servico WHERE id_serv=".$_GET["id_serv"]."");
                
                if ($query3){
                    echo "<p>DADOS EXCLUIDOS COM SUCESSO!</p>";
                }
            }
        ?>

        <form class="box" action="areaProd.php?cond=1" method="POST">
            
            <fieldset>
                <legend>Dados sobre os Serviços</legend>
                <label>Nome do Serviço: </label>
                <input type="text" id="nome" name="nome">

                <label>Descrição: </label>
                <input type="text" id="descricao" name="descricao">

                <label>Valor: </label>
                <input type="number" id="valor" name="valor"> <br>

                <input type="submit" value="Cadastrar">
            </fieldset>
        </form>

        <form class="box" action="areaProd.php?cond=2" method="POST">
            
            <fieldset id="tab_serv">
                <label>Pesquisar Serviço: </label>
                <input type="text" id="pesquisa" name="pesquisa"><br>
                <input type="submit" value="Pesquisar">
            </fieldset>
            <p>
                <a href="areaProd.php?cond=5">Ver Lista de Serviços cadastrados</a>
            </p>

        </form>

        <?php

        if($_GET[cond] == 2){

        $busca_query = mysqli_query($conexao,"SELECT * FROM servico where nome LIKE '".$_POST["pesquisa"]."' ")or die(mysqli_error());//faz a busca com as palavras enviadas
        $dados = mysqli_fetch_array($busca_query);
        $envia = $dados["id_serv"];

            if($dados) {
                echo"<p>Código: ".$dados["id_serv"]."</p>";
                echo "<form  class='box' action='areaProd.php?cond=3&id_serv=".$envia."&tabela=1' method='POST'>";
                echo "<fieldset id='tab_serv'>";
                echo "<legend>Informações sobre o Serviço</legend>";
                echo "<label>Nome: </label>";
                echo "<input type='text' value='".$dados["nome"]."'id='nome' name='nome'>";
                echo "<label>Descrição: </label>";
                echo "<input type='text' value='".$dados["descricao"]."' id='descricao' name='descricao'> <br>";
                echo "<label>Valor: </label>";
                echo "<input type='number' value='".$dados["valor"]."' id='valor' name='valor'><br>";
                echo "</fieldset>";
                echo "<input type='submit' value='Alterar'></form>";
                echo "<a href='areaProd.php?cond=4&id_serv=".$envia."'>Excluir</a></form>";
                
            }
            
        }
 
        //exibir nomes de cliente
            if($_GET[cond] == 5){
                $exibe = mysqli_query($conexao,"SELECT * FROM servico LIMIT 20")or die(mysqli_error());
                echo "<div class='box'>";
                while ($dados = mysqli_fetch_array($exibe)){
                    echo "<p>".$dados["nome"]."</p><br>";
                }
                echo "</div>";
                
            }       

    ?>

    </body>
</html>