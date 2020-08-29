
<h2 class="simple-trading-heading">Fill All Fields </h2>
<p>All fields are required to successfully submit this form so please fill all the blank fields.</p>

<div class="st_container">
  <form action="" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="symbol">Symbol</label>
    </div>
    <div class="col-75">
      <input type="text" id="symbol" name="symbol" placeholder="Enter Symbol e.g. APPL">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="chart">Chart</label>
    </div>
    <div class="col-75">
      <input type="file" name="chart" value="Select Chart">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="entry-date">Entry Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="entry-date" name="entry_date" placeholder="Select a date">
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="exit-date">Exit Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="exit-date" name="exit_date" placeholder="Select a date">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="entry_price">Entry Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="entry_price" name="entry_price" placeholder="Enter Price">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="exit_price">Exit Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="exit_price" name="exit_price" placeholder="Enter Price">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="psize">Position Size</label>
    </div>
    <div class="col-75">
      <input type="text" id="psize" name="position_size" placeholder="Enter Position Size">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="type">Type</label>
    </div>
    <div class="col-75">
      <select id="type" name="type">
        <option value="long">Long</option>
        <option value="short">Short</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="stock">Stock</label>
    </div>
    <div class="col-75">
      <select id="stock" name="stock">
        <option value="option">Option</option>
        <option value="stock">Stock</option>
        <option value="future">Future</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="comments">Trade Comments</label>
    </div>
    <div class="col-75">
      <textarea id="comments" name="comments" placeholder="Write something.." style="height:200px"></textarea>
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="picture">Picture</label>
    </div>
    <div class="col-75">
      <input type="file" name="picture">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="strike_price">Strike Price</label>
    </div>
    <div class="col-75">
      <input type="text" id="strike_price" name="strike_price" placeholder="Enter Price">
    </div>
  </div>
  <div class="row">
    <div class="col-25">
      <label for="expiration_date">Expiration Date</label>
    </div>
    <div class="col-75">
      <input type="date" id="expiration_date" name="expiration_date" placeholder="Select a date">
    </div>
  </div>
  <div class="row">
    <input type="submit" name="stf_submit" value="Submit">
  </div>
  </form>
</div>
