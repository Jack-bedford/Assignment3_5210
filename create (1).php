<!doctype html>
<html lang="en" class="bg-dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Foundation CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container rounded pt-3 pb-3 mt-3 mb-5 bg-light">
      <?php 
            
            
            include "connection.php";
            
            if(isset($_POST['submit']))
            {
                // write a prepared statement to insert data
                $insert = $connection->prepare("insert into scp(scp_name, scp_classification, scp_image, scp_description) values(?,?,?,?)");
                $insert->bind_param("ssss", $_POST['scp_name'], $_POST['scp_classification'], $_POST['scp_image'], $_POST['scp_description']);
                
                if($insert->execute())
                {
                    echo "
                        <div class='alert alert-success p-3'>Record successfully created</div>
                    
                    ";
                }
                else
                {
                   echo "
                        <div class='alert alert-danger p-3'>Error: {$insert->error}</div>
                    
                    "; 
                }
            }
      
      
      ?>
    <h1>Create a Record of a new SCP subject</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="create.php" class="form-group">
            <label>Enter SCP name(number)</label>
            <br>
            <input type="text" name="scp_name" placeholder="E.g: 001" class="form-control" required>
            <br>
            <label>Enter SCP Classification(Safe,Eculid,Keter)</label>
            <br>
            <input type="text" name="scp_classification" placeholder="classification..." class="form-control">
            <br>
            <label>Enter SCP Image</label>
            <br>
            <input type="text" name="scp_image" placeholder="images/nameofimage.png" class="form-control">
            <br>
            <label>Enter SCP Description</label>
            <br>
            <textarea name="scp_description" class="form-control">Enter description: </textarea>
            <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>