
<html>
<head>

</head>
<body>
<form method="post" action="post.php" >

<label>Desired Link   </label><input name="link" type="text" required>
<br><br>
<label>Desired Name  </label><input name="name" type="text" required>
<br><br>
<label>Desired Score  </label>
<select name="score">
<?php for($i=0;$i<=15;$i++) echo '<option value="'.$i.'">'.$i.'</option>';?>
</select>
<br><br>
<input type="submit" value="Ok"/>

</form>
</body>
</html>
