        </div>
    </div>

    <!-- Pie de Página -->
    <footer class="footer fixed-bottom bg-dark p-2">
      <div class="container text-center">
        <span class="text-muted">Este es el Pie</span>
      </div>
    </footer>
    
    
    <!-- Bootstrap -->
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

        // Integrar editor texto summernote
        $('#descripcion').summernote({
          airMode: true
        });
      });
    </script>
</body>
</html>