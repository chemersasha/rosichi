<select name="<?php echo $sectionId ?>" id="<?php echo $sectionId ?>">
    <option value="Нет">Нет</option>
    <option value="Бокс">Бокс</option>
    <option value="Тренажеры">Тренажеры</option>
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
