<?php
    include 'db.class.php';
 
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}

	if ( null==$id ) {
		header("Location: index.php");
	}
     
	if( !empty($_POST)) {
		$yearError = null;
		$modelError = null;
		$mileageError = null;
		$maxSpeedError = null;
		$descError = null;
		$dateError = null;
		 
		$year = $_POST['year'];
		$model = $_POST['model'];
		$mileage = $_POST['mileage'];
		$maxSpeed = $_POST['maxSpeed'];
		$desc = $_POST['desc'];
		$date = $_POST['date'];
		 
		// validate input, use regular expression
		$valid = true;

		if (empty($year)) {
		    $yearError = 'Please enter year';
		    $valid = false;
		} else if(!preg_match('/(\d{4})/', $year)) {
		    $yearError = 'invalid year';
		    $valid = false;
		}
		 
		if (empty($model)) {
		    $modelError = 'Please enter model';
		    $valid = false;
		}

		if (empty($mileage)) {
		    $mileageError = 'Please enter mileage';
		    $valid = false;
		} else if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $mileage)) {
		    $mileageError = 'invalid model';
		    $valid = false;
		}

		if (empty($maxSpeed)) {
		    $maxSpeedError = 'Please enter max speed';
		    $valid = false;
		} else if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $maxSpeed)) {
		    $maxSpeedError = 'invalid max speed';
		    $valid = false;
		}

		if (empty($desc)) {
		    $descError = 'Please enter description';
		    $valid = false;
        }

        if (empty($date)) {
            $dateError = 'Please enter date';
            $valid = false;
        } else if(!preg_match('/\d{4}\-[0-1][0-9]-[0-3][0-9]/', $date)) {
            $dateError = 'invalid date e.g. 2015-02-01';
            $valid = false;
	}
		 
		// update data
		if ($valid) {
		    // connect db
		    $pdo = new DB;
		    $pdo->Connect();
			
		    $pdo->UpdateCar ($id, $year, $model, $mileage, $maxSpeed, $desc, $date);

		    header("Location: index.php");
		}
        } else {
		$pdo = new DB;
		$pdo->Connect();
		$res = $pdo->DisplayOneCar($id);
		$data = $res->fetch(PDO::FETCH_ASSOC);
		$year = $data['year'];
		$model = $data['model'];
		$mileage = $data['mileage'];
		$maxSpeed = $data['max_speed'];
		$desc = $data['description'];
		$date = $data['sale_date'];
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
                        <h3>Update a car</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">

                      <div class="control-group <?php echo !empty($yearError)?'error':'';?>">
                        <label class="control-label">Year</label>
                        <div class="controls">
                            <input name="year" type="text"  placeholder="Year" value="<?php echo !empty($year)?$year:'';?>">
                            <?php if (!empty($yearError)): ?>
                                <span class="help-inline"><?php echo $yearError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($modelError)?'error':'';?>">
                        <label class="control-label">Model</label>
                        <div class="controls">
                            <input name="model" type="text" placeholder="Model" value="<?php echo !empty($model)?$model:'';?>">
                            <?php if (!empty($modelError)): ?>
                                <span class="help-inline"><?php echo $modelError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($mileageError)?'error':'';?>">
                        <label class="control-label">Mileage</label>
                        <div class="controls">
                            <input name="mileage" type="text"  placeholder="Mileage" value="<?php echo !empty($mileage)?$mileage:'';?>">
                            <?php if (!empty($mileageError)): ?>
                                <span class="help-inline"><?php echo $mileageError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($maxSpeedError)?'error':'';?>">
                        <label class="control-label">Max Speed</label>
                        <div class="controls">
                            <input name="maxSpeed" type="text"  placeholder="Max Speed" value="<?php echo !empty($maxSpeed)?$maxSpeed:'';?>">
                            <?php if (!empty($maxSpeedError)): ?>
                                <span class="help-inline"><?php echo $maxSpeedError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($descError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="desc" type="text"  placeholder="Description" value="<?php echo !empty($desc)?$desc:'';?>">
                            <?php if (!empty($descError)): ?>
                                <span class="help-inline"><?php echo $descError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                        <label class="control-label">Sold Date</label>
                        <div class="controls">
                            <input name="date" type="text"  placeholder="Sold Date" value="<?php echo !empty($date)?$date:'';?>">
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>

                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>

