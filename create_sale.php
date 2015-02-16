<?php
     
    include 'db.class.php';
 
    if ( !empty($_POST)) {

        $car_idError = null;
        $priceError = null;
        $dateError = null;
         
        $car_id = $_POST['car_id'];
        $price = $_POST['price'];
        $date = $_POST['date'];
         
        // validate input, use regular expression
        $valid = true;

        if (empty($car_id)) {
            $car_idError = 'Please enter car_id';
            $valid = false;
        } else if(!preg_match('/[0-9]+/', $car_id)) {
            $car_idError = 'invalid car_id';
            $valid = false;
	}
         
        if (empty($price)) {
            $priceError = 'Please enter price';
            $valid = false;
        } else if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $price)) {
            $priceError = 'invalid price';
            $valid = false;
	}

        if (empty($date)) {
            $dateError = 'Please enter date';
            $valid = false;
        } else if(!preg_match('/\d{4}\-[0-1][0-9]-[0-3][0-9]/', $date)) {
            $dateError = 'invalid date e.g. 2015-02-01';
            $valid = false;
	}
         
        if ($valid) {
	    // connect db
	    $pdo = new DB;
	    $pdo->Connect();

	    // insert data
            $pdo->InsertSale ($car_id, $price, $date);

    	    // redirect back to index.php
            header("Location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Add a new sale</h3>
                    </div>
             
                    <form class="form-horizontal" action="create_sale.php" method="post">

                      <div class="control-group <?php echo !empty($car_idError)?'error':'';?>">
                        <label class="control-label">Car ID</label>
                        <div class="controls">
                            <input name="car_id" type="text"  placeholder="Car ID" value="<?php echo !empty($car_id)?$car_id:'';?>">
                            <?php if (!empty($car_idError)): ?>
                                <span class="help-inline"><?php echo $car_idError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($priceError)?'error':'';?>">
                        <label class="control-label">Price</label>
                        <div class="controls">
                            <input name="price" type="text" placeholder="Price" value="<?php echo !empty($price)?$price:'';?>">
                            <?php if (!empty($priceError)): ?>
                                <span class="help-inline"><?php echo $priceError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                        <label class="control-label">Sold Date</label>
                        <div class="controls">
                            <input name="date" type="text"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
