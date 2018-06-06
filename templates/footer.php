<?php

$rt = select("*", "tbl_info", "id=1 LIMIT 1");
$run = mysqli_fetch_assoc($rt);

?>

<footer>
  <marquee>
    <?= $run['isi']; ?>
  </marquee>
</footer>
</body>
</html>
