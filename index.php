<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <script>
	var people, asc1 = 1,
            asc2 = 1,
            asc3 = 1;
        window.onload = function () {
            car = document.getElementById("car");
        }

        function sort_table(tbody, col, asc) {
            var rows = tbody.rows,
                rlen = rows.length,
                arr = new Array(),
                i, j, cells, clen;
            // fill the array with values from the table
            for (i = 0; i < rlen; i++) {
                cells = rows[i].cells;
                clen = cells.length;
                arr[i] = new Array();
                for (j = 0; j < clen; j++) {
                    arr[i][j] = cells[j].innerHTML;
                }
            }
            // sort the array by the specified column number (col) and order (asc)
            arr.sort(function (a, b) {
                return (a[col] == b[col]) ? 0 : ((a[col] > b[col]) ? asc : -1 * asc);
            });
            // replace existing rows with new rows created from the sorted array
            for (i = 0; i < rlen; i++) {
                rows[i].innerHTML = "<td>" + arr[i].join("</td><td>") + "</td>";
            }
        }
    </script>
    <style>
        th {
            cursor: pointer;
        }
    </style>
</head>
 
<body>
<h1>Car dealership</h1>
	    <div class="container">
		    <div class="row">
			<h3>Cars</h3>
		    </div>
		    <div id = "div1" class="row">
			<p> <a href="create.php" class="btn btn-success">Add</a>
			</p>
			<table id="cars" class="table table-striped table-bordered" cellspacing="0" width="100%">

			  <thead>
			    <tr>
			      <th>ID</th>
			      <!-- every click changes the asc values, so that we can sort on ascending and descending one after the other -->
			      <th onclick = "sort_table(car, 1, asc1);asc1 *= -1; asc2 = 1; asc3 = 1;">Year</th>
			      <th onclick = "sort_table(car, 2, asc2); asc2 *= -1; asc3 = 1; asc1 = 1;">Model</th>
			      <th>Mileage</th>
			      <th>Maximal Speed</th>
			      <th>Description</th>
			      <th>Sold Date</th>
			      <th>Action</th>
			    </tr>
			  </thead>

			  <tbody id = "car">
			  <?php
			   include_once 'db.class.php';
			   $pdo = new DB;
			   $pdo->Connect();
			   foreach ($pdo->DisplayCars() as $row) {
				    echo '<tr>';
				    echo '<td>'. $row['id'] . '</td>';
				    echo '<td>'. $row['year'] . '</td>';
				    echo '<td>'. $row['model'] . '</td>';
				    echo '<td>'. $row['mileage'] . '</td>';
				    echo '<td>'. $row['max_speed'] . '</td>';
				    echo '<td>'. $row['description'] . '</td>';
				    echo '<td>'. $row['sale_date'] . '</td>';
				    echo '<td><a class="btn" href="update.php?id='.$row['id'].'">Update</a></td>';
				    echo '<td><a class="btn" href="delete.php?id='.$row['id'].'">Delete</a></td>';
				    echo '</tr>';
			   }
			  ?>
			  </tbody>
		    </table>
		</div>

		    <div class="row">
			<h3>Sales</h3>
		    </div>
		    <div class="row">
			<p> <a href="create_sale.php" class="btn btn-success">Add</a>
			</p>
			<table class="table table-striped table-bordered">
			  <thead>
			    <tr>
			      <th>Car ID</th>
			      <th>Price</th>
			      <th>Sold Date</th>
			      <th>Action</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php
			   include_once 'db.class.php';
			   $pdo = new DB;
			   $pdo->Connect();
			   foreach ($pdo->DisplaySales() as $row) {
				    echo '<tr>';
				    echo '<td>'. $row['car_id'] . '</td>';
				    echo '<td>'. $row['price'] . '</td>';
				    echo '<td>'. $row['sale_date'] . '</td>';
				    echo '<td><a class="btn" href="update_sale.php?id='.$row['car_id'].'">Update</a></td>';
				    echo '<td><a class="btn" href="delete_sale.php?id='.$row['car_id'].'">Delete</a></td>';
				    echo '</tr>';
			   }
			  ?>
			  </tbody>
		    </table>
		</div>
	    </div> <!-- /container -->

</body>
</html>
