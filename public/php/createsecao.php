<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$ordem = $nome = "";
$ordem_err = $nome_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    

    
    $ordem = trim($_POST["ordem"]);
    $nome = trim($_POST["nome"]);

    // Check input errors before inserting in database
    if(empty($ordem_err) && empty($nome_err) ){
        // Prepare an insert statement
        $sql = "INSERT INTO secao (ordem, nome) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $param_ordem, $param_nome);
            
            // Set parameters
            $param_ordem = $ordem;
            $param_nome = $nome;
            
            // Attempt to execute the prepared statement
            if($results=mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                echo $results;
                exit();
            } else{
                echo $results;
                echo "Erro! A operação não foi realizada.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Seção</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Adicionar Seção</h2>
                    <p>Preencher para inserir nova seção no banco.</p>
                    <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script> 
                    <script type="text/javascript">
                    
                            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                    </script>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Ordem</label>
                            <input type="text" name="ordem" class="form-control" value="<?php echo $ordem; ?>">
                           
                        </div>
                        
                        <h1>Nome</h1>
                        <textarea name="nome" cols="40"><?php echo $nome;?></textarea><br>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancela</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>