<!doctype html>
<html lang="en" class="bg-dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Foundation CRUD Application</title> <!----->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container rounded pt-3 pb-3 mt-3 mb-5 bg-dark">
      
      <?php include "connection.php"; ?>
      
    <div>
       <ul class="nav navbar-dark bg-dark w-100 fixed-top">
            <li class="nav-item active">
                <a href="index.php" class="nav-link text-light">Index</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">SCPs</a>
                <ul class="dropdown-menu bg-dark">
                  <?php foreach($result as $link):?>
                    <li class="nav-item active">
                        <a href="index.php?link=<?php echo $link['scp_name'];?>" class="nav-link text-light"><?php echo $link['scp_name'];?></a>
                    </li>
                    <?php endforeach;?>
                </ul>
              </li>
            
            
            <li class="nav-item active">
                <a href="create.php" class="nav-link text-light">Contribute to the SCP Foundation Database</a>
            </li>
        </ul>

    </div>
      <br><br>
    <h1 class="text-white">SCP Foundation CRUD Application!</h1>
    <div>
        <?php
        
            if(isset($_GET['link']))
            {
                $scp_name = $_GET['link'];
                
                // prepared statment
                $stmt = $connection->prepare("select * from scp where scp_name = ?");
                if(!$stmt)
                {
                    echo "<p>Error SQL statment</p>";
                }
                $stmt->bind_param("s", $scp_name);
                if($stmt->execute())
                {
                    $result = $stmt->get_result();
                    //Check if record has been retreived 
                    if($result->num_rows > 0)
                    {
                        $array = array_map('htmlspecialchars', $result->fetch_assoc());
                        $update = "update.php?update=" . $array['id'];
                        $delete = "index.php?delete=" . $array['id'];
                        
                        echo 
                        "
                            <div class='card card-body shadow mb-3'>
                                <h2 class='card-title text-center'>{$array['scp_name']}</h2>
                                <h4 class='text-muted'>Class: {$array['scp_classification']}</h4>
                                <p><img src='{$array['scp_image']}' alt='{$array['scp_name']}' class='w-75 rounded mx-auto d-block img-fluid'></a></p>
                                <p>{$array['scp_description']}</p>
                                <p>
                                    <a href='{$update}' class='btn btn-info'>Update Record</a>
                                    <a href='{$delete}' class='btn btn-warning'>Delete Record</a>

                                </p>
                            </div>
                        
                        ";

                    }
                    else
                    {
                        echo "<p>No record found for scp name: {$array['scp_name']}</p>";
                    }
                }
                else
                {
                    echo "<p>Error executing the statement</p>";
                }
            }
            else
            {
                echo "
                <div class='card card-body shadow mb-3'>
                <h1 class='text-center'>Welcome to the SCP foundation CRUD Application</h1>
                <p><img src='images/SCPlogo.png' alt='SCP foundation CRUD Application' class='img-fluid'></p>
                </div>
                ";
            }
            
            // delete record
            if(isset($_GET['delete']))
            {
                $delID = $_GET['delete'];
                $delete = $connection->prepare("delete from scp where id=?");
                $delete->bind_param("i", $delID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Record Deleted...</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'> Error deleting record: {$delete->error}</div>";
                }
            }
        
        ?>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>