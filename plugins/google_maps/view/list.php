<?php $location_list = $google_maps->get_all(); ?>

<table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Id</th>
        <th>Location name</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	<?php foreach($location_list as $location): ?>
		      <tr>
		      	<td><?= $location->id ?></td>
		        <td><?= $location->location_name ?></td>
		        <td><?= $location->latitude ?></td>
		        <td><?= $location->longitude ?></td>
		        <td></td>
		      </tr> 
      	<?php endforeach; ?>

    </tbody>
  </table>
