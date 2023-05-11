<html>
    <head>
        <title>Área das Vendas</title>
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
            //Falta: Código para imprimir resumo da venda inserida; código para gerar um arquivo com as vendas do dia, vendas por cliente
            //Pesquisa, Alterações e exclusões de venda só acontecerão via BD
            ini_set('error_reporting', E_ALL); // mesmo resultado de: error_reporting(E_ALL);
            ini_set('display_errors', 0);

            include("conexao.php");

        ?>
        
        <form class="box" action="areaVenda.php?cond=1" method="POST">
            
            <fieldset id="tab_vendas">
                <legend>Dados sobre a Venda</legend>
                <label>Data: </label>
                <input type="date" id="data_venda" name="data_venda"><br>
                <label>Serviço Adquirido: </label>
                <select id="servico" name="servico">
                    <?php
                        $exibe = mysqli_query($conexao,"SELECT * FROM servico LIMIT 20")or die(mysqli_error());
                        while ($dados = mysqli_fetch_array($exibe)){
                            echo "<option value=".$dados["id_serv"].">".$dados["nome"]."</option><br>";
                        }
                    ?>
                </select><br>
                <label>Nome do Cliente: </label>
                <select id="cliente" name="cliente">
                    <?php
                        $exibe = mysqli_query($conexao,"SELECT * FROM cliente LIMIT 20")or die(mysqli_error());
                        while ($dados = mysqli_fetch_array($exibe)){
                            echo "<option value=".$dados["id_cliente"].">".$dados["nome"]."</option><br>";
                        }
                    ?>
                </select><br>
                <label>Modo de Pagamento:</label>
                <input type="radio" id="pag" name="pag" value="Pix">
                <label>Pix</label>
                <input type="radio" id="pag" name="pag" value="Dinheiro">
                <label>Dinheiro</label>
                <input type="radio" id="pag" name="pag" value="Débito">
                <label>Débito</label>
                <input type="radio" id="pag" name="pag" value="Credito">
                <label>Credito</label><br>
                
                <input type="submit"  value="Cadastrar">
            </fieldset>    
        </form>

        <form class="box" action="areaVenda.php?cond=2" method="POST">
            
            <fieldset id="tab_serv">
                <label>Pesquisar Vendas do dia: </label>
                <input type="date" id="pesquisa" name="pesquisa"><br>
                <input type="submit" value="Pesquisar">
            </fieldset>

        </form>
        
        <?php
            if($_GET[cond] == 1){
                $dataV = $_POST['data_venda'];
                $serv = $_POST['servico'];
                $cliente = $_POST['cliente'];
                $pag = $_POST['pag'];

                $busca_query = mysqli_query($conexao,"SELECT * FROM servico WHERE id_serv LIKE '".$serv."' ")or die(mysqli_error());//faz a busca com as palavras enviadas
                $dados = mysqli_fetch_array($busca_query);

                $valor = $dados["valor"];
            
                $sql = "INSERT INTO vendas (dataV, serv, nomeCliente, valor, pagamento) VALUES ( '$dataV', '$serv', '$cliente', '$valor', '$pag')";
                $rs = mysqli_query($conexao, $sql);
                if ($rs){
                    echo "<p>DADOS INSERIDOS COM SUCESSO!</p>";                 
                }    
            }
            
            if ($_GET[cond] == 2){
                $busca_query = mysqli_query($conexao,"SELECT * FROM vendas WHERE dataV LIKE '".$_POST["pesquisa"]."' ");//faz a busca com as palavras enviadas
                echo"<p>Vendas do Dia: ".$_POST["pesquisa"]."</p>";
                 while ($dados = mysqli_fetch_array($busca_query)){
                    echo "<div class='box'>";
                    $nomeC = $dados["nomeCliente"];
                    $buscaC = mysqli_query($conexao,"SELECT * FROM cliente WHERE id_cliente LIKE '".$dados["nomeCliente"]."' ");
                    $dadosC = mysqli_fetch_array($buscaC);
                
                    $buscaS = mysqli_query($conexao,"SELECT * FROM servico WHERE id_serv LIKE '".$dados["serv"]."' ");
                    $exibe = mysqli_fetch_array($buscaS);
                    
                    
                    echo "<p>Cliente: ".$dadosC["nome"]."</p>";
                    echo "<p>Serviço: ".$exibe["descricao"]."</p>";
                    echo "<p>Valor: ".$exibe["valor"]."</p>";
                    echo "<p>Pagamento: ".$dados["pagamento"]."</p>";
                    echo "<a href='areaVenda.php?cond=4&data=".$dados["dataV"]."&cliente=".$dados["nomeCliente"]."'>Excluir Venda</a>";
                    echo "</div>";
                 }
            }
            
            if($_GET[cond] == 4){
                $query3 = mysqli_query($conexao,"DELETE FROM vendas WHERE dataV='".$_GET["data"]."' && nomeCliente='".$_GET["cliente"]."'");
                
                if ($query3){
                    echo "<p>DADOS EXCLUIDOS COM SUCESSO!</p>";
                }
            }
            
        ?>
        
    </body>
</html>