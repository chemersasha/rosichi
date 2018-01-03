<select name="<?php echo $sectionId ?>" id="<?php echo $sectionId ?>">
    <?php if(isset($items)) { foreach ($items as $value) { ?>
      <option value="<?php echo $value ?>"><?php echo $value ?></option>
    <?php }} ?>
    <option value="Нет">Нет</option>
    <option value="Бокс">Бокс</option>
    <option value="Пилатес">Пилатес</option>
    <option value="Йога">Йога</option>
</select></br>
<script>
  $(function() {
    var section = $("#<?php echo $sectionId ?>");
    section.selectmenu({
      width: 137
    });
    <?php
      if (isset($sectionValue)) {
        echo 'section.val("'.$sectionValue.'");';
        echo 'section.selectmenu("refresh");';
      }
    ?>
  });
</script>
