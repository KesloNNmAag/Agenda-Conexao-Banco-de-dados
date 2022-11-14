<?php
require_once 'classe.php';
$p = new Pessoa("agenda", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Pessoa</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php 
        if(isset($_POST['nome']))
        {
            $nome = addslashes($_POST['nome']);
            $sexo = addslashes($_POST['genero']);
            $dt_nasc = addslashes($_POST['dt_nasc']);
            $telefone = addslashes($_POST['telefone']);            
            $email = addslashes($_POST['email']);

            if(!empty($nome) && !empty($sexo) && !empty($dt_nasc) && !empty($telefone) && !empty($email)) {
                //parte cadastro
                if(!$p->cadastrarPessoa($nome, $sexo, $dt_nasc, $telefone, $email))
                {
                    echo "Email já está cadastrado";
                }

            }
            else
            {
                echo "Preencha todos os campos";
            }
        }



    ?>
    <section id="esquerda">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome"><br>
            <label for="genero">Gênero </label><br>
            <input type="radio" value="Masculino" name="genero">Masculino
            <input type="radio" value="Feminino" name="genero">Feminino
            <input type="radio" value="Prefiro não informar" name="genero">Prefiro não informar <br>
            <label for="dt_nasc">Data de Nascimento</label>
            <input type="date" name="dt_nasc" id="dt_nasc"><br>
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone"><br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email"><br>
            <input type="submit" value="Cadastrar ">

        </form>
    </section>

    <section id="direita">
        <table>
            <tr id="titulo">
                <td>ID</td>
                <td>NOME</td>
                <td>GÊNERO</td>
                <td>DATA DE NASCIMENTO</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>

            <?php
            $dados = $p->buscarDados();
            if (count($dados) > 0) 
            {
                for ($i = 0; $i < count($dados); $i++) 
                {
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) 
                    {
                        if ($k != "nome") 
                        {
                            echo "<td>".$v."</td>";
                        }
                    }
                   ?> 
                   <td>
                     <a href="">Editar</a>
                     <a href="index.php?id=<?php echo $dados[$i]['id_pessoa']; ?>">Excluir</a> 
                    </td>
                    <?php
                    echo "</tr>";
                }

            }
            else
            {
                echo "Ainda não há pessoas cadastradas";
            }

            ?>



        </table>
    </section>
</body>

</html>

<?php

if(isset($_GET['id_pessoa']))
    {
        $id = addslashes($_GET['id_pessoa']);
        $p->excluirPessoa($id);
        $header("location: index.php");
    }


?>