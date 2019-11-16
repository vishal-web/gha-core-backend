<style>
  table tr th {
    font-size:18px;
  }
 
</style>
<div class='default-padding cart'>
  <div class='container'>
    <h2>Your Cart</h2>
    <?php if (!empty($query)) { ?>
    <table border='0' class='table table-bordered'>
      <tr>
        <th></th>
        <th>Course Name</th>
        <th>Duration</th>
        <th>Price</th>  
      </tr>
      <?php 
        $total = 0;
        foreach ($query as $row) {  
          $course_title = '<a href="'.base_url('course/').$row['url_title'].'">'.$row['title'].'</a>';
          $total += $row['price'];
      ?>
      <tr>
        <td style='width:50px; text-align:center'><span data-id='<?=$row['cart_id']?>' class='label label-danger remove-cart-item'>X</span></td>
        <td><?=$course_title?></td>
        <td><?=$row['duration'].' Months'?></td>
        <td><?=currency_symbol('INR')?><?=(int)$row['price']?></td>
      </tr>
      <?php } ?>
      
      <tr>
        <td colspan="3" class='text-right'><b>Total</b></td>
        <td><?=number_in_inr($total)?></td>
      
      </tr>
       
    </table>

    <div class='text-right'>
      <a href='<?=base_url('cart/checkout')?>' class='btn btn-primary btn-lg'>Checkout <i class='fa fa-arrow-right'></i></a>
    </div>

    <?php } else {
      echo '<p>Your cart is currently empty.</p>';
    } ?>
  </div>
</div>