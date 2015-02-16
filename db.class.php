<?php

class DB {

	private $conn;

	public function Connect () { 
		// pass in DATABASE_URL for heroku
		$dbopts = parse_url("postgres://nkzlkvpxsvgaju:o7jWWDI_iwBFjWh_iajwBT_eG8@ec2-50-17-202-29.compute-1.amazonaws.com:5432/d8q7r1902nq2jk");

		//$dbopts = parse_url(getenv('DATABASE_URL'));

		$dbname = ltrim($dbopts["path"],'/');
		$servername = $dbopts["host"];
		$port = $dbopts["port"];
		$user = $dbopts["user"];
		$password = $dbopts["pass"];

		try {
			$this->conn = new PDO("pgsql:dbname=$dbname;host=$servername;port=$port", $user, $password);
			// set the PDO error mode to exception
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch(PDOException $e) {
			echo "Connection error" . $e->getMessage();
		}
	}

	// automatically disconnect when destruct
	public function __destruct () {
		$this->conn = null;
	}

	public function InsertCar ($year, $model, $mile, $ms, $desc, $date) {
		$sql = "insert into car values (DEFAULT, '$year', '$model', $mile, $ms, '$desc', '$date' );";
		try{
			$this->conn->exec($sql);	
		} catch(PDOException $e) {
			echo "Insertion error" . $e->getMessage();
		}
	}

	public function DisplayCars () {
		$sql = "select * from car;";
		return $this->conn->query($sql);
	}
	
	public function DisplayOneCar ($id) {
		$sql = "select * from car where id = $id;";
		return $this->conn->query($sql);
	}

	public function DeleteOneCar ($id) {
		$sql = "DELETE FROM car WHERE id = $id;";
		$this->conn->exec($sql);
	}

	public function UpdateCar ($id, $year, $model, $mile, $ms, $desc, $date) {
		$sql = "update car set year = '$year', model = '$model', mileage = $mile, max_speed = $ms, description = '$desc', sale_date = '$date' where id = $id;";

		try{
			$this->conn->exec($sql);
		} catch(PDOException $e) {
			echo "Update error" . $e->getMessage();
		}
	}
	
	/* sales table related */
	public function DisplaySales () {
		$sql = "select * from sales;";
		return $this->conn->query($sql);
	}

	public function InsertSale ($id, $price, $date) {
		$sql = "insert into sales values ($id, $price, '$date' );"; 
		try{
			$this->conn->exec($sql);	
		} catch(PDOException $e) { 
			echo "Insertion error" . $e->getMessage();
		}
	}

	public function DisplayOneSale ($id) {
		$sql = "select * from sales where car_id = $id;";
		return $this->conn->query($sql);
	}

	public function DeleteOneSale ($id) {
		$sql = "DELETE FROM sales WHERE car_id = $id;";
		$this->conn->exec($sql);
	}

	public function UpdateSale ($id, $price, $date) {
		$sql = "update sales set car_id = $id, price = $price, sale_date = '$date' where car_id = $id;";
		try{
			$this->conn->exec($sql);
		} catch(PDOException $e) {
			echo "Update error" . $e->getMessage();
		}
	}
}
?>
