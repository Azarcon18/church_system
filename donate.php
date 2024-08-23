<!-- donate.php -->
<div class="modal-header">
    <h5 class="modal-title" id="uniModalLabel">Donate</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="donation-form" method="post" action="process_donation.php">
        <div class="mb-3">
            <label for="donation-amount" class="form-label">Donation Amount</label>
            <input type="number" class="form-control" id="donation-amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="donor-name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="donor-name" name="donor_name" required>
        </div>
        <div class="mb-3">
            <label for="donor-email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="donor-email" name="donor_email" required>
        </div>
        <button type="submit" class="btn btn-primary">Donate</button>
    </form>
</div>
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
