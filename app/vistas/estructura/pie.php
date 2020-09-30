        </div>
    </div>

    <!-- Pie de Página -->
    <footer class="footer fixed-bottom bg-dark p-2">
      <div class="container text-center">
        <span class="text-muted">Este es el Pie</span>
      </div>
    </footer>
    
    
    <!-- Bootstrap -->
    <script src="../../../publico/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="../../../publico/js/popper/popper.min.js"></script>
    <script src="../../../publico/js/bootstrap/bootstrap.min.js"></script>
    <script src="../../../publico/js/bootstrap/bootstrapValidator.js"></script>

    <script src="../../../publico/js/validator.js"></script>

    <script>
    $(document).ready(function(){
        // Cambiar uso del input "contraseña"

        $("#proteger").click(function(){
          
            if(!this.checked)
            {
              $("#contraseña").attr('disabled', 'disabled');
            } else{
              $("#contraseña").removeAttr('disabled');
            }
        });
    });
    </script>
</body>
</html>