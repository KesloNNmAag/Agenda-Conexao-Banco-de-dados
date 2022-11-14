<?php

Class Pessoa {
    private $pdo;
    //conexão com o banco 
    public function __construct($dbname, $host, $user, $senha)
    {
        try
        {
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);

        } 
        catch (PDOException $e) {
            echo "Erro com banco de dados: ".$e->getMessage();
            exit();
        }
        catch (Exception $e) {
            echo "Erro genérico: ".$e->getMessage();
            exit();
        }

    }

    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY ds_nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }


    // cadastrar pessoa no banco de dados

    public function cadastrarPessoa($nome, $sexo, $dt_nasc, $telefone, $email)
    {
        //verificar se o email ja esta cadastrado

        $cmd = $this->pdo->prepare("SELECT id_pessoa from tb_pessoa WHERE ds_email = :e");

        $cmd->bindValue(":e",$email);
        $cmd->execute();
        if($cmd->rowCount() > 0) //email existe?
        {
            return false;
        } else //email não encontrado
        {
            $cmd = $this->pdo->prepare("INSERT INTO tb_pessoa (ds_nome, cd_sexo, dt_nasc, nr_telefone, ds_email) VALUES (:n, :g, :dtn, :t, :e)");

            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":g", $sexo);
            $cmd->bindValue(":dtn", $dt_nasc);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
    }

    public function excluirPessoa($id_pessoa)
    {
        $cmd = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE id_pessoa = :id_pessoa");

        $cmd->bindValue(":id_pessoa",$id_pessoa);
        $cmd->execute();
    }




}












?>