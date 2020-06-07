<h5>Here you can find your booking history:</h5>

<table style="max-width: 100rem;">
	<thead>
		<th>Booking ID</th>
		<th>Packages</th>
		<th>Price</th>
		<th>Extras</th>
		<th>Payment Status</th>
		<th>Booking Date</th>
		<th><a href="" id="log-out">Log Out</a></th>
	</thead> 
	<tbody>
<?php foreach($account as $a) : ?>
	<tr>
		<td><?= $a->ID ?></td>
		<td><?php
			if(is_array($a->childspackages)){
				foreach($a->childspackages as $pack){
					$decoded = json_decode(urldecode($pack));
				    if($decoded){
				      foreach ($decoded as $child) {
				        //var_dump($child);
				        echo '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
				      }
				    }
					//echo $pack . '<br/>';
				}
			} 
			else{
				$pack = $a->childspackages;
				$decoded = json_decode(urldecode($pack));
			    if($decoded){
			      foreach ($decoded as $child) {
			        //var_dump($child);
			        echo '<p><b>' . $child->child . '</b>: ' . $child->package.'</p>'; 
			      }
			    }
			}		
		?></td>
		<td><?= $a->price ?>€</td>
		<td><?php 
		    $extras = get_post_meta( $a->ID , 'extras' , true );
		    $qnt = get_post_meta( $a->ID , 'extras_quantity' , true );

		    //var_dump($extras);

		    $counter = 0;
		    foreach($qnt as $key=>$q){
			 	 if($q > 0){
		      echo $q.' x ' . $extras[$counter] . '<br/>';
		      $counter ++;
			   }
		    }
		?></td>
		<td><?= $a->pay_status ?></td>
		<td><?= $a->post_date ?></td>

	</tr>
<?php endforeach; ?>
</tbody>
</table>


