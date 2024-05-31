<div class="modal fade small" id="subjectModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">New Subject</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="subjectForm">
                    <div class="form-group">
                        <label for="subjectName">Subject Name:</label>
                        <input type="text" class="form-control" id="subjectName" name="subjectName" required>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade small" id="subjectModalUpdate">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Subject Detail</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="subjectFormUpdate">
                    <div class="form-group">
                        <label for="subjectName">Subject Name:</label>
                        <input type="text" class="form-control" id="subjectName" name="subjectName" required>
                        <input type="hidden" id="subjectId" name="id" value="">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </form>
            </div>

        </div>
    </div>
</div>