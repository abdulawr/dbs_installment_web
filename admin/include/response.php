<?php
function showMessage($message,$type=true){
  // type true for success and false for error message
?>
<!-- Modal -->
<div class="modal fade" id="responseMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">

      <?php
      if($type){
      ?>
      <div class="alert alert-success" role="alert">
       <?php echo $message; ?>
      </div>
      <img onclick="Hide_Model()" class="img-thumbnail rounded mx-auto d-block" src="../images/response.gif" alt="">
      <?php
      }
      else{
        ?>
        <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
        </div>
        <img onclick="Hide_Model()" class="img-thumbnail rounded mx-auto d-block" src="../images/error.gif" alt="">
        <?php
      }
      ?>

      </div>
    </div>
  </div>
</div>

<script>
$('#responseMessage').modal()
setTimeout(function(){ $('#responseMessage').modal('hide')
 }, 10000);

 function Hide_Model(){
  $('#responseMessage').modal('hide')
 }

</script>
<?php
}
?>
