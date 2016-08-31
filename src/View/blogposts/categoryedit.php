
<div class='container main-container'>
<h2 class='col-md-12'>Edit categories:</h2>



<div class='col-md-12 container' style='margin-top:3%;margin-left:15%;'>
  <form action=admin/category/edit/<?php echo $data['instance']->id ?> class='form-inline' role='form' method='POST'>
    <input type='hidden' class='form-control' name='id' value=<?php echo $data['instance']->id ?> >
      ID: <?php echo $data['instance']->id ?> &nbsp
      <input type='text' class='form-control' name='category_name' value='<?php echo $data['instance']->name ?>' required>

    <button type='submit' class='btn btn-default'>Save</button>
  </form>

</div>

<div style='margin-top:15%;'>
    <a href='admin/category'><button type='button' class='btn btn-info'>Back to categories</button></a>
</div>
</br>
</br>

</div>