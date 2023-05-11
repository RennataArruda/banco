<html>
    <head>
        <title>Área dos Clientes</title>
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
                $nome = $_POST['nome'];
                $cpf = $_POST["cpf"];
                $celular = $_POST["celular01"];
                $celular2 = $_POST["celular02"];
                $email = $_POST["email"];
                $profissao = $_POST["profissao"];
                $cep = $_POST["cep"];
                $rua = $_POST["rua"];
                $bairro = $_POST["bairro"];
                $num = $_POST["num"];
                $complemento = $_POST["comp"];
            
                $sql = "INSERT INTO cliente (nome, cpf, profissao) VALUES ( '$nome', '$cpf', '$profissao')";
                $rs = mysqli_query($conexao, $sql);
                if ($rs){
                    $busca_query = mysqli_query($conexao,"SELECT * FROM cliente where nome LIKE '".$nome."' ")or die(mysqli_error());
                    $dados = mysqli_fetch_array($busca_query);
                    
                    $sql1 = "INSERT INTO contato (id_cliente, contato1, contato2, email) VALUES ( '".$dados["id_cliente"]."', '$celular', '$celular2', '$email')";
                    $rs1 = mysqli_query($conexao, $sql1);
                    
                    if ($rs1){
                        
                        $sql2 = "INSERT INTO endereco (id_cliente, cep, bairro, rua, num, comp) VALUES ( '".$dados["id_cliente"]."', '".$cep."', '".$bairro."', '".$rua."', '".$num."', '".$complemento."')";
                        $rs2 = mysqli_query($conexao, $sql2);
                    
                        if ($rs2){
                        echo "<p>DADOS INSERIDOS COM SUCESSO! CADASTRE O <a href='cadAnimal.php'>ANIMAL</a></p>";
                        }
                    }
                    
                    
                }    
                
            }   
            //alterar SQL
            if($_GET[cond] == 3){                
                if ($_GET[tabela] == 1){
                    $nome = $_POST['nome'];
                    $cpf = $_POST["cpf"];
                    $profissao = $_POST["profissao"];

                    $sql = "UPDATE cliente SET nome = '".$nome."', cpf = '".$cpf."', profissao = '".$profissao."' WHERE id_cliente = '".$_GET["id_cliente"]."'";
        
                    $rs = mysqli_query($conexao, $sql);
                }else if ($_GET[tabela] == 2){
                    $celular = $_POST["celular01"];
                    $celular2 = $_POST["celular02"];
                    $email = $_POST["email"];

                    $sql = "UPDATE contato SET contato1 = '".$celular."', contato2 = '".$celular2."', email = '".$email."' WHERE id_cliente = '".$_GET["id_cliente"]."'";
        
                    $rs = mysqli_query($conexao, $sql);
                }else if ($_GET[tabela] == 3){
                    $cep = $_POST["cep"];
                    $rua = $_POST["rua"];
                    $bairro = $_POST["bairro"];
                    $num = $_POST["num"];
                    $complemento = $_POST["comp"];

                    $sql = "UPDATE endereco SET cep = '".$cep."', bairro = '".$bairro."', rua = '".$rua."', num = '".$num."', comp = '".$complemento."' WHERE id_cliente = '".$_GET["id_cliente"]."'";
        
                    $rs = mysqli_query($conexao, $sql);
                }
                
                if ($rs){
                    echo "<p>DADOS ATUALIZADOS COM SUCESSO!</p>";
                }
            }
            //excluir SQL
            if($_GET[cond] == 4){
                $query3 = mysqli_query($conexao,"DELETE FROM cliente WHERE id_cliente=".$_GET["id_cliente"]."");
                $query4 = mysqli_query($conexao,"DELETE FROM contato WHERE id_cliente=".$_GET["id_cliente"]."");
                $query5 = mysqli_query($conexao,"DELETE FROM endereco WHERE id_cliente=".$_GET["id_cliente"]."");
                $query6 = mysqli_query($conexao,"DELETE FROM animal WHERE id_dono=".$_GET["id_cliente"]."");
                
                if ($query3 && $query4 && $query5 && $query6){
                    echo "<p>DADOS EXCLUIDOS COM SUCESSO!</p>";
                }
            }
            
?> 
        <form class="box" action="areaCliente.php?cond=1" method="POST">
            
            <h1>Dados do Cliente</h1>
            <fieldset id="tab_cliente">
                <legend>Informações Pessoais</legend>
                <label>Nome Completo: </label>
                <input type="text" id="nome" name="nome">
                <label>CPF: </label>
                <input type="text" id="cpf" name="cpf"> <br>
                <label>Profissão: </label>
                <input type="text" id="prof" name="profissao"><br>
            </fieldset>

            <fieldset id="tab_cliente">
                <legend>Contatos do Cliente</legend>
                <label>Celular: </label>
                <input type="tel" id="celular" name="celular01">

                <label>Número para Recados: </label>
                <input type="tel" id="celular02" name="celular02"><br>

                <label>E-mail: </label>
                <input type="email" id="email" name="email">
            </fieldset>

            <fieldset id="tab_cliente">
                <legend>Endereço</legend>
                <label>CEP: </label>
                <input type="text" id="cep" name="cep">
                <label>Bairro: </label>
                <input type="text" id="bairro" name="bairro"><br>
                <label>Rua: </label>
                <input type="text" id="rua" name="rua">
                <label>Numero: </label>
                <input type="text" id="num" name="num"><br>
                <label>Complemento: </label>
                <input type='text' name='comp'><br>
            </fieldset>
            <input type="submit" value="Cadastrar">

        </form>
        
        <form class="box" action="areaCliente.php?cond=2" method="POST">
            
            <fieldset id="tab_cliente">
                <label>Pesquisar Nome do Cliente: </label>
                <input type="text" id="pesquisa" name="pesquisa"><br>
                <input type="submit" value="Pesquisar">
            </fieldset>
            <p>
                <a href="areaCliente.php?cond=5">Ver Lista de nomes de clientes cadastrados</a>
            </p>

        </form>
        <?php

        if($_GET[cond] == 2){

        $busca_query = mysqli_query($conexao,"SELECT * FROM cliente where nome LIKE '".$_POST["pesquisa"]."' ")or die(mysqli_error());//faz a busca com as palavras enviadas
        $dados = mysqli_fetch_array($busca_query);
        $envia = $dados["id_cliente"];

        $busca_query_end = mysqli_query($conexao,"SELECT * FROM endereco where id_cliente LIKE '".$envia."' ")or die(mysqli_error());
        $dadosEnd = mysqli_fetch_array($busca_query_end);

        $busca_query_contato = mysqli_query($conexao,"SELECT * FROM contato where id_cliente LIKE '".$envia."' ")or die(mysqli_error());
        $dadosContato = mysqli_fetch_array($busca_query_contato);

            if($dados) {
                echo"<p>Código: ".$dados["id_cliente"]."</p>";
                echo "<form  class='box' action='areaCliente.php?cond=3&id_cliente=".$envia."&tabela=1' method='POST'>";
                echo "<fieldset id='tab_cliente'>";
                echo "<legend>Informações Pessoais</legend>";
                echo "<label>Nome Completo: </label>";
                echo "<input type='text' value='".$dados["nome"]."'id='nome' name='nome'>";
                echo "<label>CPF: </label>";
                echo "<input type='text' value='".$dados["cpf"]."' id='cpf' name='cpf'> <br>";
                echo "<label>Profissão: </label>";
                echo "<input type='text' value='".$dados["profissao"]."' id='prof' name='profissao'><br>";
                echo "</fieldset>";
                echo "<input type='submit' value='Alterar'></form>";

                echo "<form class='box'  action='areaCliente.php?cond=3&id_cliente=".$envia."&tabela=2' method='POST'>";
                echo "<fieldset id='tab_cliente'>
                    <legend>Contatos</legend>
                    <label>Celular: </label>
                    <input type='tel' value='".$dadosContato["contato1"]."' id='celular' name='celular01'>
                    <label>Número para Recados: </label>
                    <input type='tel' value='".$dadosContato["contato2"]."' id='celular02' name='celular02'><br>
                    <label>E-mail: </label>
                    <input type='email' value='".$dadosContato["email"]."' id='email' name='email'>
                    </fieldset>";
                echo "<input type='submit' value='Alterar'></form>";

                echo "<form  class='box' action='areaCliente.php?cond=3&id_cliente=".$envia."&tabela=3' method='POST'>";
                echo "<fieldset id='tab_cliente'>
                    <legend>Endereço</legend>
                    <label>CEP: </label>
                    <input type='text' value='".$dadosEnd["cep"]."'id='cep' name='cep'>
                    <label>Bairro: </label>
                    <input type='text' value='".$dadosEnd["bairro"]."' id='bairro' name='bairro'><br>
                    <label>Rua: </label>
                    <input type='text' value='".$dadosEnd["rua"]."' id='rua' name='rua'>
                    <label>Numero: </label>
                    <input type='text' value='".$dadosEnd["num"]."' id='num' name='num'><br>
                    <label>Complemento: </label>
                    <input type='text'value='".$dadosEnd["comp"]."' name='comp'><br>
                    </fieldset>";
                echo "<input type='submit' value='Alterar'>";
                echo "<a href='areaCliente.php?cond=4&id_cliente=".$envia."'>Excluir</a></form>";
                
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