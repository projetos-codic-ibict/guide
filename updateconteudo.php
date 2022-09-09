<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$titulo = $descricao = $secao = "";
$titulo_err = $descricao_err = $secao_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_titulo = trim($_POST["titulo"]);
    $titulo = $input_titulo;
    /*if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }*/
    
    // Validate address address
    $input_descricao = trim($_POST["descricao"]);
    $descricao = $input_descricao;
    /*if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }*/
    
    // Validate salary
    //$input_salary = trim($_POST["salary"]);
    //$salary = $input_salary;
   /* if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }*/
    $input_secao= trim($_POST["secao"]);
    $secao = $input_secao;
    // Check input errors before inserting in database
    if(empty($titulo_err) && empty($descricao_err)){
        // Prepare an update statement
        $sql = "UPDATE conteudo SET titulo=?, descricao=?, secao_index=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssii", $param_titulo, $param_descricao, $param_secao, $param_id);
            
            // Set parameters
            $param_titulo = $titulo;
            $param_descricao = $descricao;
            $param_secao = $secao;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM conteudo WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $titulo = $row["titulo"];
                    $descricao = $row["descricao"];
                    $secao = $row["secao_index"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        #mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atualizar Conteúdo</title>
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
                    <script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>
                    <script type="text/javascript">
                            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
                    </script>
                    <h2 class="mt-5">Atualiza Registro</h2>
                    <p>Edite e confirme as alterações realizadas.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <!--<div class="form-group">
                            <label>titulo</label>
                            <input type="text" name="titulo" class="form-control" value="<#?php echo $titulo; ?>">
                            
                        </div>-->
                        <h1>Título</h1>
                        <textarea name="titulo" cols="40"><?php echo $titulo;?></textarea><br>
                        <!--<div class="form-group">
                            <label>descricao</label>
                            <input type="text" name="descricao" class="form-control " value="<#?php echo $descricao; ?>">
                        </div>-->
                        <h1>Descrição</h1>
                        <textarea name="descricao" cols="40"><?php echo $descricao;?></textarea><br>
                        <!--<div class="form-group">
                            <label>Seção</label>
                            <input type="integer" name="secao" class="form-control " value="<#?php echo $secao; ?>">
                        </div>-->
                        <?php
                                $sql0 = "SELECT * FROM secao";
                                $stmt0 = mysqli_prepare($link, $sql0);
                                mysqli_stmt_execute($stmt0);
                                $result0 = mysqli_stmt_get_result($stmt0);
                                
                        ?>
                        <p>     
                        <select name="secao">
                            
                            <?php 
                                
                                echo "<option value=".$secao.">".$row1[$secao]."</option>";
                                while ($row0 = mysqli_fetch_array($result0)) {
                                    echo "<option value='".$row0[0]."'>".$row0[2]."</option>";
                                    #echo $row0[0];
                                    #echo $row0[$row0[0]];
                                }
                            ?>    
                        </select>
                        </p> 
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>