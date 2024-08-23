<!-- Modal Structure -->
<div class="modal fade" id="uniModal" tabindex="-1" aria-labelledby="uniModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <!-- Content will be loaded here via AJAX -->
      </div>
    </div>
  </div>
</div>

<script>
  function uni_modal(title, url) {
    $.ajax({
      url: url,
      success: function(response) {
        $('#uniModal .modal-body').html(response);
        $('#uniModal').modal('show');
      }
    });
  }
</script>
