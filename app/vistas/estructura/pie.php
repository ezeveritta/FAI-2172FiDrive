<?php

# Cargo pie de página
if ($CONFIG["pie"])
{ 
?>

  <!-- Pie de Página -->
  <footer class="footer bg-white p-2 d-block">
    <div class="container text-center">
      <span class="text-muted">Este es el Pie</span>
    </div>
  </footer>

<?php 
} 

# Validación
if ($CONFIG["validator"][0])
{ 
?>

  <!-- Validator -->
  <script src="../../publico/js/validator-<?php echo $CONFIG["validator"][1] ?>.js"></script>

<?php } if ($CONFIG["extensiones"]["md5"]) { ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>
<?php } ?>

</body>
</html>