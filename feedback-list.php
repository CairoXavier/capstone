<?php
    $pageTitle = "Feedback List";
    include 'header.php';
    include 'db_connect.php';
    include 'navbar.php';
?>
<div class="container w-50 my-3">
<h1 class="text-start my-5">Feedbacks</h1> 
<table class="table table-hover text-center">
	<thead>
    <tr>
    	<th scope="col">Feedback ID</th>
    	<th scope="col">Content</th>
    	<th scope="col">Sender</th>
    </tr>
	</thead>
	<tbody>
	<?php
        $q  = "SELECT * FROM feedbacks";
        $r = mysqli_query($conn, $q);
        
        while($row = mysqli_fetch_assoc($r)){
			$id      = $row['id'];
            $content = $row['content'];
            $sender  = $row['sender'];
            ?>
                <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $content; ?></td>
                <td><?php echo $sender; ?></td>
            </tr>
    <?php      
            }
    ?> 
	</tbody>
	</table>
</div>