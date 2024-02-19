
	  <?php
      if (!isset($conn)) {
          include 'db_connect.php';
//    include 'date/jdf.php';
      }

	    if (isset($_GET['id'])) 
	           {
				     $id = $_GET['id'];
				     $query = "SELECT * " .
				             "FROM tbl_uploads WHERE fileid = '$id'";
				     $result = mysqli_query($conn,$query) or die('Error, query failed');

				     list($id, $file, $type, $size,$content) = mysqli_fetch_array($result);
				 				   //echo $id . $file . $type . $size;
				 				   //echo 'sampath';


				     header("Content-type: $type");
				     header("Content-Disposition: attachment; filename=$file");

				     ob_clean();
				     flush();

				     echo $content;
				     mysqli_close($conn);
				     exit;
	           }

	       ?>
