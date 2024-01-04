
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../../js/assets/jquery.js"></script>
<script src="../../js/assets/sweetalert.js"></script>

<script src="../../js/assets/dataTables/jquery.dataTables.min.js"></script>
<script src="../../js/assets/dataTables/jquery.dataTables.min.js"></script>
<script src="../../js/assets/dataTables/dataTables.buttons.min.js"></script>
<script src="../../js/assets/dataTables/jszip.min.js"></script>
<script src="../../js/assets/dataTables/pdfmake.min.js"></script>
<script src="../../js/assets/dataTables/vfs_fonts.js"></script>
<script src="../../js/assets/dataTables/buttons.html5.min.js"></script>
<script src="../../js/assets/dataTables/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script src="../../js/global.js"></script>

<script>
  $(document).ready(function() {
    $('.select').select2({
      maximumSelectionSize: 5, // Set the maximum number of visible options
      placeholder: 'Select an option', // Optional placeholder text
    });
  });
</script>

<?php
    if(isset($_SESSION['error'])){
        ?>
            <script>
                Swal.fire({title: "There's a Problem", text: "<?php echo $_SESSION['error'] ?>", icon: 'error'});
            </script>
        <?php
        unset($_SESSION['error']);
    }

    if(isset($_SESSION['success'])){
        ?>
            <script>
                Swal.fire({title: 'SUCCESS', text: "<?php echo $_SESSION['success'] ?>", icon: 'success'});
            </script>
        <?php
        unset($_SESSION['success']);
    }
?>