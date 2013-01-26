<?php
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }
?>
<div id="checkout-alerts"></div>
<h2>Checkout a resource</h2>
<div class="modules well">
    <div class="resourcediv attention" style="display:inline-block;">
        <p><i class="icon-ok resource-ok" style="display:none;"></i>Choose a resource</p>
        <select name="resource" class="resource">
            <option></option>
            <?php
                $typesArray = getRTypesArray();
                foreach ($typesArray as $x) {
                    print '<option value="' .$x['type_id'] . '">' . $x['type_name'] . '</option>';
                }
            ?>
        </select>

    </div>
    <div class="datediv attention" style="display:none;">
        <p><i class="icon-ok date-ok" style="display:none;"></i>Select a date</p>

        <input type="text" name="checkoutdate" class="date" />
    </div>
    <div class="fullblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <?php for ($i = 0; $i < NUM_BLOCKS; $i++):?>
            <a href="./?action=reserve" class="btn reserve-link"><?php print $i+1 ?></a>
        <?php endfor; ?>
    </div>
    <div class="halfblocks attention" style="display:none;">
        <p>Choose the periods</p>
        <input type="" style="visibility:hidden"/>
        <table>

            <?php for ($i = 0; $i < NUM_BLOCKS; $i++): ?>
            <tr>
                <td><span style="padding-right:5px;">Block <?php print $i+1 ?></span></td>
                <td style="padding-right:5px;"><a href="./?action=reserve" id="<?php print $i+1 ?>1" class="btn reserve-link">1<sup>st</sup> half</a>
                <td><a href="./?action=reserve" id="<?php print $i+1?>2" class="btn reserve-link">2<sup>nd</sup> half</a>
            </tr>
            <?php  endfor; ?>
        </table>
    </div>
</div>
<?php if (isset($_GET['date'])) { ?>
    <script type="text/javascript" src="js/checkout.js.php?date=<?php print $_GET['date'] ?>" >
<?php }else { ?>
    <script type="text/javascript" src="js/checkout.js.php" >
<?php
}
