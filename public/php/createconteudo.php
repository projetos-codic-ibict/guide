<?php
// Include config file
require_once "config.php";
try{
    // Define variables and initialize with empty values
    $titulo = $descricao = $secao = $area1 = $categories = "";
    $titulo_err = $descricao_err = $secao_err = "";
    
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate name
        /*$input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Please enter a valid name.";
        } else{
            $name = $input_name;
        }
        
        // Validate address
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Please enter an address.";     
        } else{
            $address = $input_address;
        }
        
        // Validate salary
        $input_salary = trim($_POST["salary"]);
        if(empty($input_salary)){
            $salary_err = "Please enter the salary amount.";     
        } elseif(!ctype_digit($input_salary)){
            $salary_err = "Please enter a positive integer value.";
        } else{
            $salary = $input_salary;
        }
        */

        
        $titulo = trim($_POST["titulo"]);
        #$titulo = htmlspecialchars($titulo);
        $descricao = trim($_POST["descricao"]);
        $secao = trim($_POST["secao"]);
        #$categories = trim($_POST["categories"]);

        $sql0 = "SELECT * FROM secao";
        $stmt0 = mysqli_prepare($link, $sql0);
        mysqli_stmt_execute($stmt0);
        $result0 = mysqli_stmt_get_result($stmt0);

        // Check input errors before inserting in database
        if(empty($titulo_err) && empty($descricao_err) ){
            // Prepare an insert statement
            $sql = "INSERT INTO conteudo (titulo, descricao, secao_index) VALUES (?, ?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssi", $param_titulo, $param_descricao, $param_secao);
                
                // Set parameters
                
                $param_titulo = $titulo;
                $param_descricao = $descricao;
                $param_secao = $secao;
                
                // Attempt to execute the prepared statement
                if($results=mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    header("location: index.php");
                    echo $results;
                    exit();
                } else{
                    try{
                        $results=mysqli_stmt_execute($stmt);
                    }catch(Exception $erro){
                        echo $erro->getmessage();
                    }
                    
                    echo $results;
                    echo $titulo;
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
        
        // Close connection
        mysqli_close($link);
    }
}catch(Exception $erro){
    echo $erro->getmessage();
}
?>
 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Seção</title>
    <link rel="stylesheet" type="text/css" href="css/customFont.css" />
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
                    <h2 class="mt-5">Adicionar Conteúdo</h2>
                    <p>Preencher para inserir novo conteúdo no banco.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script> 
                    <script type="text/javascript">
                    
                            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                    </script>
                        <h1>Título</h1>
                        <textarea name="titulo" cols="40"><?php echo $titulo;?></textarea><br>
                        <h1>Descrição</h1>
                        <textarea name="descricao" cols="40"><?php echo $descricao;?></textarea><br>
                        
                        
                        <?php
                                $sql0 = "SELECT * FROM secao";
                                $stmt0 = mysqli_prepare($link, $sql0);
                                mysqli_stmt_execute($stmt0);
                                $result0 = mysqli_stmt_get_result($stmt0);
                                echo $secao;
                        ?>  
                        <p>     
                        <select name="secao">
                            <option value="Secao">Selecionar Seção</option>
                            <?php
                               
                                while ($row0 = mysqli_fetch_array($result0)) {
                                    echo "<option value='".$row0[0]."'>".$row0[2]."</option>";
                                    
                                }
                            ?>       
                        </select>
                        </p> 
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>