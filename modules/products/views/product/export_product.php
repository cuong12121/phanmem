<style>
    table td {
      padding: 5px 6px;
      border-right: 1px #ccc solid;
      border-bottom: 1px #ccc solid;
  }
  table th {
      padding: 5px 6px;
      border-right: 1px #ccc solid;
      border-bottom: 1px #ccc solid;
  }
  table {
    border-left: 1px #ccc solid;
    border-top: 1px #ccc solid;
}

</style>

<?php 

  $output='';
  $output .='
  <table class = "table" bordered="1">
  <tr style>
  <th>STT</th>
  <th>ID</th>
  <th>Name</th>
  <th>Code</th>
  <th>Thuong_hieu</th>
  <th>Danh_muc</th>
  <th>Price</th>
  <th>Price_old</th>
  <th>Link</th>
  <th>Link anh</th>
  <th>Bao_hanh</th>
  </tr>
  ';

  foreach ($export as $k => $item) {
    $image = str_replace('/original/', '/original/', $item->image);
    $link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->record_id.'&cid='.$item->category_id);

    $output .='
    <tr>
      <td>'.($k + 1).'</td>
      <td>'.$item -> id.'</td>
      <td>'.$item -> name.'</td>
      <td>'.$item -> code.'</td>
      <td>'.$item -> manufactory_name.'</td>
      <td>'.$item -> category_name.'</td>
      <td>'.$item -> price.'</td>
      <td>'.$item -> price_old.'</td>
      <td><a href="'.$link.'">'.$link.'</a></td>
      <td><a href="'.URL_ROOT.$image.'">'.URL_ROOT.$image.'</a></td>
      <td>'.$item -> gift.'</td>
    </tr>
    ';
  }
  $output .='</table>';
  // $output = mb_convert_encoding($output, 'utf-8');
  header('Content-Type: application/xls');
  echo '<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />';
  // header("Content-Transfer-Encoding: binary"); 
  header("Content-Type: text/html; charset=utf-8");
  header('Content-Disposition: attachment; filename=allproducts.xls');
  // header('Pragma: no-cache'); 

  echo $output;
  // die();
?>