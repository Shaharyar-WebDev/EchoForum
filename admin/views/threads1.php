<!-- Threads Management Page -->
<div class="text-center min-h-[77vh] flex flex-col items-center">
  <div class="overflow-x-auto relative w-full max-w-7xl">
    <!-- Loader for table (absolute positioned) -->
    <span id="table-loader" class="loading loading-spinner text-primary absolute" style="top: 30%; left: 50%; transform: translateX(-50%);"></span>
    <table class="table w-full">
      <!-- Table Head -->
      <thead>
        <tr>
          <th>Thread ID</th>
          <th>User ID</th>
          <th>Category ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Image</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <!-- Table Body: Rows will be populated dynamically -->
      <tbody id="table">
        <!-- Example static row for reference:
        <tr data-thread-id="1"
            data-user-id="101"
            data-cat-id="5"
            data-title="Sample Thread Title"
            data-description="This is a sample thread description."
            data-image="thread1.jpg"
            data-createdat="2025-02-15T10:00">
          <td>1</td>
          <td>101</td>
          <td>5</td>
          <td>Sample Thread Title</td>
          <td><textarea class="textarea" readonly>This is a sample thread description.</textarea></td>
          <td>
            <div class="mask mask-squircle w-10 h-10">
              <img src="http://127.0.0.1/echoforum/public/uploads/threadPosts/thread1.jpg" alt="Thread Image">
            </div>
          </td>
          <td>2025-02-15 10:00</td>
          <td class="flex gap-2">
            <button class="btn btn-primary btn-outline btn-sm update-btn">
              <i class="fas fa-edit"></i> Update
            </button>
            <button class="btn btn-error btn-outline btn-sm delete-btn">
              <i class="fas fa-trash"></i> Delete
            </button>
          </td>
        </tr>
        -->
      </tbody>
    </table>
  </div>
  <!-- Pagination Controls -->
  <div class="w-full text-center mt-4">
    <div class="join" id="pagination">
      <!-- Pagination buttons will be appended here -->
    </div>
  </div>
</div>

<!-- Update Modal for Threads -->
<input type="checkbox" id="update-modal" class="modal-toggle" />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Update Thread</h3>
    <hr class="mb-4">
    <form id="update-Thread-form">
      <!-- Hidden Thread ID -->
      <input type="hidden" id="modal-thread-id" name="thread-id" />
      <div class="form-control">
        <label class="label" for="modal-thread-title">
          <span class="label-text">Title</span>
        </label>
        <input type="text" id="modal-thread-title" name="thread-title" placeholder="Thread Title" class="input input-bordered" />
      </div>
      <div class="form-control">
        <label class="label" for="modal-thread-description">
          <span class="label-text">Description</span>
        </label>
        <textarea id="modal-thread-description" name="thread-description" placeholder="Thread Description" class="textarea textarea-bordered"></textarea>
      </div>
      <div class="form-control">
        <label class="label">Thread Image</label>
        <div class="flex items-center gap-4">
          <img id="modal-thread-image-preview" class="mask mask-squircle w-20" src="" alt="Thread Image" />
          <input type="file" id="modal-thread-image" name="thread-image" class="file-input file-input-bordered" />
        </div>
      </div>
      <div class="form-control">
        <label class="label" for="modal-thread-created-at">
          <span class="label-text">Created At</span>
        </label>
        <input type="datetime-local" id="modal-thread-created-at" name="created-at" class="input input-bordered" disabled />
      </div>
      <div class="modal-action">
        <button type="submit" class="btn btn-primary">Save</button>
        <label for="update-modal" class="btn">Cancel</label>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal for Threads -->
<input type="checkbox" id="delete-modal" class="modal-toggle" />
<div class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Confirm Deletion</h3>
    <p>Are you sure you want to delete this thread?</p>
    <div class="modal-action">
      <button class="btn btn-error" id="confirm-delete-button">Delete</button>
      <label for="delete-modal" class="btn">Cancel</label>
    </div>
  </div>
</div>
