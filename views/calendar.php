<h2>Checkout a resource</h2>
<br />Choose a resource<br />
<select name="resource" class="resource">
    <option></option>
    <option value="1">Laptop Cart</option>
    <option value="2">Computer Lab</option>
    <option value="3">Lecture Hall</option>
</select><br />
<div class="datediv" style="display:none;">
    <br />Select a date<br />
    <input type="text" name="date" class="date" /><br />
</div>
<div class="blockdiv" style="display:none;">
    <br />Choose the periods<br />
    <div class="btn-group" style="display:inline-block;">
        <a href="./?action=reserve" class="btn">1</a>
        <a href="./?action=reserve" class="btn">2</a>
        <a href="./?action=reserve" class="disabled btn">3</a>
        <a href="./?action=reserve" class="btn">4</a>
        <!-- ./?action=reserve&date=10/10/10&resource=1&block=1&new=1 -->
    </div>
</div>
<script type="text/javascript">
$date = "";
$type = "";
$('.resource').change(function() {
    $('.datediv').css('display', 'block');
    $date = $('.datediv').contents;
});
$('.date').change(function() {
    $.ajax({
        url: "./?action=checkAvailability&date=" + $date + "&type=" + $type,
        cache: false
    }).done(function(html) {
        $('.datediv').append(html);
    });
    $('.blockdiv').css('display', 'block');
});
</script>
