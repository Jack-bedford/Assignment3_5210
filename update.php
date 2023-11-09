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
            
            if($_GET['update'])
            {
                $id = $_GET['update'];
                $recordID = $connection->prepare("select * from scp where id = ?");
                if(!$recordID)
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error preparing record for updating</div>";
                    exit;
                }
                $recordID->bind_param("i", $id);
                if($recordID->execute())
                {
                    echo "<div class='alert alert-success p-3 m-2'>Record ready for update</div>";
                    $temp = $recordID->get_result();
                    $row = $temp->fetch_assoc();
                    
                }
                else
                {
                    echo "<div class='alert alert-danger p-3 m-2'>Error: {$recordID->error}</div>";
                }
            }
            
            if(isset($_POST['update']))
            {
                // write a prepared statement to insert data
                $update = $connection->prepare("update scp set scp_name=?, scp_classification=?, scp_image=?, scp_description=? where id=?");
                $update->bind_param("ssssi", $_POST['scp_name'], $_POST['scp_classification'], $_POST['scp_image'], $_POST['scp_description'], $_POST['id']);
                
                if($update->execute())
                {
                    echo "
                        <div class='alert alert-success p-3'>Record successfully updated</div>
                    
                    ";
                }
                else
                {
                   echo "
                        <div class='alert alert-danger p-3'>Error: {$update->error}</div>
                    
                    "; 
                }
            }
      
      
      ?>
    <h1>Update a Record of a SCP subject</h1>
    <p><a href="index.php" class="btn btn-dark">Back to index page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="update.php" class="form-group">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label>SCP name(number)</label>
            <br>
            <input type="text" name="scp_name" placeholder="E.g: 001" class="form-control" required value="<?php echo $row['scp_name']; ?>">
            <br>
            <label>SCP Classification(Safe,Eculid,Keter)</label>
            <br>
            <input type="text" name="scp_classification" placeholder="classification..." class="form-control" value="<?php echo $row['scp_classification']; ?>">
            <br>
            <label>SCP Image</label>
            <br>
            <input type="text" name="scp_image" placeholder="images/nameofimage.png" class="form-control" value="<?php echo $row['scp_image']; ?>">
            <br>
            <label>SCP Description</label>
            <br>
            <textarea name="scp_description" class="form-control" ><?php echo $row['scp_description']; ?></textarea>
            <br><br>
            <input type="submit" name="update" class="btn btn-primary">
        </form>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>