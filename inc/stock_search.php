<!-- // nb: add <form> & </form> on either side of this include!
// Depending on where you want your form to redirect to you'll want
// to change your form action, but the inner bits of the form don't
// need to change.
// also your form_type hidden input needs to be outside! -->

    <label for="item_name">Name: </label>
    <input type="text" name="item_name" id="item_name"/>
    <br />
    <label for="brand">Brand: </label>
    <input type="text" name="brand" id="brand" />
    <br />
    <label for="qty">Quantity: </label>
    <input type="number" name="qty" id="qty" />
    <br />
    <label for="price">Price: </label>
    <select name="price_range_symbol">
      <option value=">">&gt;</option>
      <option value="<">&lt;</option>
      <option value="=">=</option>
    </select>
    <input type="number" step="any" name="price" id="price" />
    <br />

    <button type="submit">Submit!</button>
    <button type="reset">Reset</button>
