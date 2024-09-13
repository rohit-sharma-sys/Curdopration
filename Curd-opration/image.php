<!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
 
<body>
    <div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile[]" multiple value="" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload" value="upload">UPLOAD</button>
            </div>
        </form>
    </div>
  <style type="text/css">
    *{
    margin: 0;
      padding: 0;
      box-sizing: border-box;
}
 
#content{
    width: 50%;
    justify-content: center;
    align-items: center;
    margin: 20px auto;
    border: 1px solid #cbcbcb;
}
form{
    width: 50%;
    margin: 20px auto;
}
 
#display-image{
    width: 100%;
    justify-content: center;
    padding: 5px;
    margin: 15px;
}
img{
    margin: 5px;
    width: 350px;
    height: 250px;
}
.img_src{
    width: 200px;
    height: 200px;
}
th,tr,td{
    border: 1px solid black;
    border-collapse: collapse;
}
table{
    text-align: center;
    margin: auto;
}

.Checkbox {
            transform: scale(2);
            margin: 5px;
        }

    button.btn.btn-danger {
    margin: 10px;
}
th {
    font-size: 20px;
}
</style>

<?php
// If upload button is clicked ...
if (isset($_POST['upload'])) {
    $countfiles = count($_FILES['uploadfile']['name']);
    for($i=0;$i<$countfiles;$i++){
        $filename = $_FILES['uploadfile']['name'][$i];
        $tempname = $_FILES['uploadfile']['tmp_name'][$i];
        $folder = "./upload2/" . $filename;
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3 class='text-center'>Image uploaded successfully!</h3>";
        } else {
            echo "<h3>Failed to upload image!</h3>";
        }
    }
}
// If  single delete button is clicked ...
if (isset($_POST['delete_two'])) {
    $filepath = $_POST['filepath'];
    if (unlink($filepath)) {
        echo "<h3 class='text-center'>Image deleted successfully!</h3>";
    } else {
        echo "<h3>Failed to delete image!</h3>";
    }
}

// If delete selected button is clicked ...
if (isset($_POST['delete_selected'])) {
    $upload_folder = "./upload2/";
    $files = scandir($upload_folder);
    $success = true;
    foreach ($_POST['checkbox'] as $selected) {
        $file = $files[$selected];
        $filepath = $upload_folder . $file;
        if (!unlink($filepath)) {
            $success = false;
        }
    }
    if ($success) {
        echo "<h3 class='text-center'>Images deleted successfully!</h3>";
    } else {
        echo "<h3>Failed to delete one or more images!</h3>";
    }
}

//Display all uploaded images...
echo "<form method='POST' action=''>";
echo "<table style='width:100%; border:1px solid black;'>";
echo "<tr class='bg-success'>";
echo "<th> All  <input type='checkbox' class='Checkbox'  id='select-all'><button class='btn btn-danger' type='submit' name='delete_selected' onclick='return confirm(\"Are you sure you want to delete selected images\")'>Delete</button></th>";
echo "<th>Image</th>";
echo "<th>Action</th>";
echo "<th>Download</th>";
echo "</tr>";

  $upload_folder = "./upload2/";
    $files = scandir($upload_folder);
    foreach ($files as $key => $file) {
        if (in_array($file, array(".", ".."))) continue;
        $filepath = $upload_folder . $file;
        echo "<tr>";
        echo "<td><input type='checkbox' class='Checkbox' name='checkbox[]' value='$key'></td>";
        echo "<td><img class='img_src' src='$filepath'></td>";
        echo "<td>
                  <form method='POST' action=''>
                      <input type='hidden' name='filepath' value='$filepath'>
                      <button class='btn btn-danger' type='submit' name='delete_two' onclick='return confirm(\"Are You Sure To Delete This Image \")'>Delete</button>
                  </form>
              </td>";
    echo "<td><a class='btn bg-success text-white' href='".$upload_folder.$file."' download>Download</a></td>";
   echo "</tr>";
    }
    ?>

</table>
</form>

<script>
    const selectAllCheckbox = document.querySelector('#select-all');
    const checkboxes = document.querySelectorAll('.Checkbox');

    selectAllCheckbox.addEventListener('change', (event) => {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = event.target.checked;
        });
    });
</script>

