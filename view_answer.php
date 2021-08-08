<!DOCTYPE html>
<html lang="en">

<head>
</head>
<?php include('header.php') ?>
<?php include('auth.php') ?>
<?php include('db_connect.php') ?>
<?php
$quiz = $conn->query("SELECT * FROM quiz_list where id =" . $_GET['id'])->fetch_array();
$hist = $conn->query("SELECT * FROM history where quiz_id =" . $_GET['id'] . " and user_id = " . $_SESSION['login_id'])->fetch_array();
?>
<title><?php echo $quiz['title'] ?> | Answer Sheet</title>
</head>

<body>
	<style>
		/*li.answer{
			cursor: pointer;
		}
		li.answer:hover{
			background: #00c4ff3d;
		}*/
		li.answer input:checked {
			background: #00c4ff3d;
		}
	</style>
	<?php include('nav_bar.php') ?>

	<div class="container-fluid admin">
		<div class="col-md-12 alert alert-primary"><?php echo $quiz['title'] ?> | <?php echo $quiz['qpoints'] . ' Points Each Question' ?></div>
		<div class="col-md-12 alert alert-success">SCORE : <?php echo $hist['score'] . ' / ' .  $hist['total_score'] ?></div>
		<br>
		<div class="card">
			<div class="card-body">
				<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'] ?>">
				<input type="hidden" name="quiz_id" value="<?php echo $quiz['id'] ?>">
				<input type="hidden" name="qpoints" value="<?php echo $quiz['qpoints'] ?>">
				<?php
				$data_ans = $conn->query("SELECT * FROM answers where quiz_id = '" . $quiz['id'] . "' and user_id = '" . $_SESSION['login_id'] . "' order by id asc ");
				$i = 1;
				while ($row = $data_ans->fetch_assoc()) {
					$question = $conn->query("SELECT * FROM questions where id = '" . $row['question_id'] . "' ");
					$opt = $conn->query("SELECT * FROM question_opt where question_id = '" . $row['question_id'] . "' order by RAND() ");
					$answer = $conn->query("SELECT * FROM answers where quiz_id ='" . $quiz['id'] . "' and user_id= '" . $_SESSION['login_id'] . "' and question_id = '" . $row['question_id'] . "'  ")->fetch_array();
				?>

					<ul class="q-items list-group mt-4 mb-4 ?>">
						<li class="q-field list-group-item">
							<strong><?php echo ($i++) . '. '; ?> <?php
																$note_qs = $conn->query("SELECT * FROM questions where id = '" . $row['question_txt'] . "'");
																$temp =  $note_qs->fetch_assoc();
																echo $temp['question'];
																?></strong>
							<input type="hidden" name="question_id[<?php echo $row['id'] ?>]" value="<?php echo $row['id'] ?>">
							<br>
							<ul class='list-group mt-4 mb-4'>
								<?php while ($orow = $opt->fetch_assoc()) { ?>

									<li class="answer list-group-item <?php echo ($answer['option_id'] == $orow['id'] && $answer['is_right'] == 1 ? "bg-success" : $orow['is_right'] == 1) ? "bg-success" : "" ?>">
										<label><input type="radio" name="option_id[<?php echo $row['id'] ?>]" value="<?php echo $orow['id'] ?>" <?php echo $answer['option_id'] == $orow['id']  ? "checked='checked'" : "" ?>> <?php echo $orow['option_txt'] ?></label>
									</li>
								<?php } ?>

							</ul>

						</li>
					</ul>

				<?php } ?>
			</div>
		</div>
	</div>
	<center>
	<form method="get" action="student_quiz_list.php">
		<button class="btn btn-block btn-primary">Quiz List</button>
	</form>
	</center>
</body>
<script>
	$(document).ready(function() {
		$('input').attr('readonly', true)

	})
</script>

</html>