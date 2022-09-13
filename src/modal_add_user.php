<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <label for="exampleModal">Select one or more of them:</label><br>
          <select class="form-select akstyle mt-2 aks-multiselect selectpicker" id="multiple-select" multiple="" aria-label="multiple select example" data-live-search="true" title="Choose Users">
              <?php foreach($user_data as $key => $user) {
                    echo '<option value="'.$user['user_id'].'" data-multipleSeparator=" " data-content="<span style=\'border:none; max-width:230px;\' class=\'mt-2 rounded-pill list-group-item list-group-item-action\'>
                            <img src=\'gdpr.png\' class=\'img-fluid rounded-circle img-thumbnail\' width=\'32\'/>&nbsp;
                            <span class=\'ml-1\'><strong>'.$user['user_name'].'</strong></span>&nbsp;
                            <span class=\'mt-2 float-end\'><i class=\'fa fa-circle text-success\'></i></span>
                        </span>">
                    </option>';
              } // fine foreach ?>
          </select>
          <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="add-user-chat">Add</button>
      </div>
    </div>
  </div>
</div>
