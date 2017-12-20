<div class="container">
	  <div class="row">
		<div class="col">
		  Name
		  <a href="/test/sortByName">^</a>
		</div>
		<div class="col">
		  E-mail
		  <a href="/test/sortByEmail">^</a>
		</div>
		<div class="col">
		  Task
		</div>
		<div class="col">
		  Status Task
		  <a href="/test/sortByStatus" >^</a>
		</div>
	  </div>
	  <div id="content">
		  <?php 
			$con = mysqli_connect(DB_SERVER,DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
			if(isset($_COOKIE["SortBy"])) {
				$query =mysqli_query($con, "SELECT * FROM tasks WHERE status=1 ORDER BY ".$_COOKIE["SortBy"]);
			} else {
				$query =mysqli_query($con, "SELECT * FROM tasks WHERE status=1");
			}
			
			
			while($row=mysqli_fetch_assoc($query)):
		  ?>
			  <div class="row z">
				<div class="col name">
				<?php if($_SESSION['session_username'] == 'admin'): ?>
					<input type="radio" name="edit" value="<?php echo $row['id']; ?>">
				<?php endif; ?>
					
				  <?php echo $row['name']; ?>
				  
				  <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
				  
				</div>
				<div class="col email">
				  <?php echo $row['email']; ?>
				  <input type="hidden" name="email" value="<?php echo $row['email']; ?>">
				  
				</div>
				<div class="col text">
				<?php if($row['picture'] != ""): ?>
					<img src="/uploads/img/<?php echo $row['picture']; ?>">
				<?php endif; ?>
				
				  <?php echo $row['text']; ?>
				  <input type="hidden" name="text" value="<?php echo $row['text']; ?>">
				</div>
				<div class="col status">
				  <?php echo $row['status']; ?>
				  <input type="hidden" name="status" value="<?php echo $row['status']; ?>">
				  
				</div>
				
			  </div>
		  <?php endwhile; ?>
		  
	  </div>
	  <div id="pagingControls"></div>
	  <form action="/test/task" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col">
				  <input type="text" name="task_name">
				</div>
				<div class="col">
				  <input type="text" name="task_email">
				</div>
				<div class="col">
				  <input type="text" name="task_text">
				</div>
				<div class="col">
				  <input type="file" name="task_file"/>
				</div>
				<div class="col">
				  <input type="submit" value="Добавить задачу">
				</div>
		  </div>
	  </form>
	</div>
<?php if($_SESSION['session_username'] != 'default_user'): ?>
<form  action="/test/logout" method="post">
	<p class="submit">
		<input type="submit" class="button" value="Выйти" />
	</p>
</form>	
<?php endif; ?>