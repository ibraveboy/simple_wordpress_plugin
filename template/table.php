<div class="st-table" style="overflow-x:auto;">
  <table>
    <tr>
      <th></th>
      <th>Date</th>
      <th>Price</th>
    </tr>
    <tr>
      <th>Entry</th>
      <td><?php echo $entry_date; ?></td>
      <td><?php echo $entry_price; ?></td>
    </tr>
    <tr>
      <th>Exit</th>
      <td><?php echo $exit_date; ?></td>
      <td><?php echo $exit_price; ?></td>
    </tr>
  </table>
  <table class="two-column">
    <tr>
      <td>Position Size</td>
      <td><?php echo $position_size; ?></td>
    </tr>
    <tr>
      <td>Percentage</td>
      <td><span class="percentage"><?php echo $pl_percentage; ?></span></td>
    </tr>
    <tr>
      <td>Strike</td>
      <td><?php echo $strike; ?></td>
    </tr>
    <tr>
      <td>Expiration</td>
      <td><?php echo $expiration_date; ?></td>
    </tr>
  </table>
</div>