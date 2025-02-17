
<div class="text-center min-h-[77vh] flex flex-col items-center">
<div class="overflow-x-auto">
<span id="table-loader" class="loading loading-spinner text-primary absolute" style="top: 30%;"></span>
  <table class="table">
    <!-- head -->
    <thead>
      <tr>
        <th>User Id</th>
        <th>Avatar</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Bio</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="table">
      <!-- row 1 -->

    </tbody>
  </table>
</div>
<div class="w-full text-center mt-4">
<div class="join" id="pagination">

</div>
</div>

</div>

<!-- Update Modal -->
<input type="checkbox" id="update-modal" class="modal-toggle"/>
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Update User</h3>
    <hr>
    <form id="update-User-form">
      <!-- Form fields for updating the thread -->
      <div class="form-control">
        <label class="label">
          <span class="label-text">User Id</span>
        </label>
        <input id="modal-user-id" name="user-id" type="text" placeholder="User Id" class="input input-bordered"/>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Avatar</span>
        </label>
        <div class="flex items-center gap-4">
        <img
  class="mask mask-squircle w-20" id="modal-avatar-img"
  src="https://img.daisyui.com/images/stock/photo-1567653418876-5bb0e566e1c2.webp"/>
        <input id="avatar-input" name="avatar" type="file" placeholder="Avatar" class="file-input file-input-bordered"/>
        </div>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">User Name</span>
        </label>
        <input id="modal-user-name" name="user-name" type="text" placeholder="User Name" class="input input-bordered"/>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <input id="modal-email" name="email" type="text" placeholder="Email" class="input input-bordered"/>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Role</span>
        </label>
        <select name="role" id="modal-role" class="select select-bordered w-full">
        <option disabled selected>Select Role</option>
        <option value="0">User</option>
        <option value="1">Admin</option>
        </select>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Bio</span>
        </label>
        <textarea name="bio" class="textarea textarea-bordered" id="modal-bio"></textarea>
      </div>
      <div class="form-control">
        <label class="label">
          <span class="label-text">Created At</span>
        </label>
        <input id="modal-created-at" type="datetime-local" placeholder="Created At" class="input input-bordered" disabled/>
      </div>
      <!-- Add other fields as necessary -->
      <div class="modal-action">
        <button type="submit" id="confirm-update-btn" class="btn btn-primary">Save</button>
        <label for="update-modal" class="btn">Cancel</label>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<input type="checkbox" id="delete-modal" class="modal-toggle"/>
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p>Are you sure you want to delete this User?</p>
    <div class="modal-action">
      <button class="btn btn-error" id="confirm-delete-button">Delete</button>
      <label for="delete-modal" class="btn">Cancel</label>
    </div>
  </div>
</div>
