<?php

                            // local , usuario , senha , banco
$conexao = mysqli_connect('localhost', 'id18678699_root', 'unematsinopA@.1', 'id18678699_aulasbd');

if (mysqli_connect_errno())
{
    
    echo "Falha ao conectar ao MySQL: " . mysqli_connect_error();
}

?>