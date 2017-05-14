<?php
/**
 * Created by PhpStorm.
 * User: bozhangeorgiev
 * Date: 5/12/17
 * Time: 11:58 AM
 */
?>

<form action="/api/v1/csv/get_csv_from_upload" method="post" enctype="multipart/form-data">

  <p><input type="file" name="csv_file">
  <p><button type="submit">Submit</button>
</form>