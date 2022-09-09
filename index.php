<!--Obtido da referência https://www.tutorialrepublic.com/php-tutorial/php-mysql-crud-application.php
Configurado e alterado-->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                    <img src="https://lattesdata.cnpq.br/logos/1/logo_lattesdata_200.png" alt="LattesData - CNPQ logo" style="user-select: auto;">
                        <h2 class="pull-left">Guia</h2>
                        <a href="listsecao.php" class="btn btn-success pull-right"><i class="fa fa-list"></i> Listar seções</a>
                        <a href="listconteudo.php" class="btn btn-success pull-right"><i class="fa fa-list"></i> Listar conteúdos</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM secao order by ordem";
                    
                    if($result = mysqli_query($link, $sql)){
                        
                        if(mysqli_num_rows($result) > 0){
                            #$result2 = mysqli_query($link, $sql2);
                            #$row = mysqli_fetch_array($result);
                            while($row = mysqli_fetch_array($result)){
                                #$row2 = mysqli_fetch_array($result2);
                                #echo "<h1>Name</h1>";
                                echo "<h1>" . $row['nome'] . "</h1>";
                                
                            

                                $sql2 = "SELECT * FROM conteudo WHERE secao_index= ?";

                                $stmt = mysqli_prepare($link, $sql2);
                                $param_id = $row['id'];
                                mysqli_stmt_bind_param($stmt, "i", $param_id);
                                mysqli_stmt_execute($stmt);
                                $result2 = mysqli_stmt_get_result($stmt); 
                                #$row2 = mysqli_fetch_array($result2);
                                //echo "<h1>" . $row2['titulo'] . "</h1>";
                                //echo "<th>" . $row2['descricao'] . "</th>";   
                                // Set parameters
                                
                                while($row2 = mysqli_fetch_array($result2)){
                                    echo "<h1>" . $row2['titulo'] . "</h1>";
                                    echo "<th>" . $row2['descricao'] . "</th>";
                                    #$sql2 = "SELECT * FROM conteudo ";
                                }
                                
                                mysqli_free_result($result2);
                            }
                        }
                              
                        // Free result set
                        mysqli_free_result($result);
                        
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>