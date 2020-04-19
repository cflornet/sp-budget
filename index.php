<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<title>Budget</title>
	<?
		require "connectDB.req.php";
		if (isset($_POST['sbm']))
		{
			//echo "<br><br><br><br><br>Category:".$_POST['cat'];
			if($_POST['acc'] == 2)
			{
				$transactionAmount = $_POST['trn'] * -1;
			}
			else
			{
				$transactionAmount = $_POST['trn'];
			}
			$idCategory = $_POST['cat'];		
			$idPayment = $_POST['pay'];
			
			$transac=array();
			$transac[0]=$transactionAmount.";".$idCategory.";".$idPayment;
			$query = "INSERT INTO transactions (`transactionAmount`, `transactionDate`, `idCategory`, `idPayment`) VALUES (:transactionAmount, Now(), :idCategory, :idPayment);";

			$stmt=$pdo->prepare($query);

			$stmt->bindParam(':transactionAmount',$transactionAmount,PDO::PARAM_INT);
			//$stmt->bindParam(':transactionDate',$transactionDate,PDO::PARAM_STR);
			$stmt->bindParam(':idCategory',$idCategory,PDO::PARAM_INT);
			$stmt->bindParam(':idPayment',$idPayment,PDO::PARAM_INT); 


			
			foreach($transac as $key=>$value)
			{

  				list($transactionAmount, $idCategory, $idPayment)=explode(';',$value);

  				if($stmt->execute())
  				{
    				echo "<br><br><br><br>";
    				echo "La requete a été executé<br>";
    				//$stmt->debugDumpParams();
    				//echo "<br>";
    				//$lastId = $pdo->lastInsertId();
    				//echo "lastId == ".$lastId."<br>";
  				}
  				else
  				{
  					echo "<br><br><br><br>";
    				echo "La requete n'a pas été executé";
				}
			}
		}
	?>
</head>
<body>
	<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
		<a class="navbar-brand" href="#">
	  		BUDGET
		</a>
	  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
	    	<span class="navbar-toggler-icon"></span>
	  	</button>
	  	<div class="collapse navbar-collapse" id="navbarNavDropdown">
	    	<ul class="navbar-nav">
	      		<li class="nav-item dropdown">
	        		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          			Actions
	        		</a>
	        		<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
	        			<a class="dropdown-item" href="index.php">New</a>
	        			<a class="dropdown-item" href="balance.php">Balance</a>
	        		</div>
	      		</li>
	    	</ul>
	  	</div>
	</nav>	
	<div class="container">
		<div class="row">
			<div class="col">
				&nbsp;
			</div>
		</div>			
		<div class="row">
			<div class="col">
				&nbsp;
			</div>
		</div>			
		<div class="row">
			<div class="col">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class="col align-self-end" style="text-align:right;">
				New 
			</div>
		</div>
		<hr width=100%>
		<div class="card">
			<div class="card-body">
				<div class=row>
					&nbsp;
				</div>
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Form</h6>
						<form method="post">
							<div class=row>
								<div class="col-md-6">
									<div class="form-group">
				    					<label for="cat">Category</label>
				    					<select class="form-control" id="cat" name="cat">
											<?
												require "connectDB.req.php";
	
												$sql = "SELECT * FROM categories ORDER BY category;";
												$categs = $pdo -> query($sql);

												while ($categ = $categs -> fetch()) 
												{
	  												echo "<option value=".$categ['idCategory'].">".$categ['category']."</option>";
	  											}
	  										?>
				    					</select>		    					
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
				    					<label for="pay">Payment</label>
				    					<select class="form-control" id="pay" name="pay">
											<?
												require "connectDB.req.php";
	
												$sql = "SELECT * FROM payments ORDER BY paymentMethod;";
												$payments = $pdo -> query($sql);

												while ($payment = $payments -> fetch()) 
												{
	  												echo "<option value=".$payment['idPayment'].">".$payment['paymentMethod']."</option>";
	  											}
	  										?>
				    					</select>		    					
									</div>
								</div>
							</div>	
							<div class=row>
								<div class="col-md-12">
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="acc" id="acc1" value="1" checked>
										<label class="form-check-label" for="acc1">Income</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="acc" id="acc2" value="2">
										<label class="form-check-label" for="acc2">Expense</label>
									</div>
								</div>
							</div>
							<div class=row>
								<div class="col-md-12">
									<div class="form-group">
										<label for="pay">Payment</label>
										<input type="number" class="form-control" name="trn" required>
									</div>
								</div>
							</div>
							<div class=row>
								<div class="col-md-12">
									<input type="submit" class="btn btn-primary btn-lg btn-block" name="sbm" value="Next">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class=row>
					&nbsp;
				</div>
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Data</h6>
						<div class="table-responsive">
							<table class="table" id="tbp">
								<thead>
									<tr>
										<th>Date</th>
										<th>Category</th>
										<th>Payment</th>
										<th>Accounting</th>
										<th>Ammount</th>
									</tr>
								</thead>
								<tbody>
									<?
										require "connectDB.req.php";
										$sql = "SELECT t.transactionDate td,c.category ct,p.paymentMethod pm,CASE WHEN t.transactionAmount < 0 THEN 'Expense' ELSE 'Income' END ac,transactionAmount ta FROM transactions t,categories c,payments p WHERE t.idCategory = c.idCategory AND t.idPayment = p.idPayment ORDER BY t.transactionDate;";
											$trns = $pdo -> query($sql);

											while ($trn = $trns -> fetch()) 
												{
	  												echo "<tr>
	  														<td>".$trn['td']."</td>
	  														<td>".$trn['ct']."</td>
	  														<td>".$trn['pm']."</td>
	  														<td>".$trn['ac']."</td>
	  														<td>".$trn['ta']."</td>
	  													  </tr>";
	  											}
									?>
								</tbody>
							</table>	
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
</body>
</html>