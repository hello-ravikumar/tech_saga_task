@csrf
<div class="modal-header">
    <h5 class="modal-title" id="customerModalLabel">Customer Detail</h5>
    <b id=customerName></b>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="customerVerificaton">Change Verification Status</label>
        <select class="form-control" id="customerVerificaton" name="verification">
            <option value="pending" {{ $customer->customer == "pending" ? 'selected': ''}}>Pending</option>
            <option value="approve" {{ $customer->customer == "approve" ? 'selected': ''}}>Approve</option>
            <option value="reject" {{ $customer->customer == "reject" ? 'selected': ''}}>Reject</option>

        </select>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger text-dark" id="customerModalClose">Close</button>
    <button type="submit" class="btn btn-info text-dark">Save changes</button>
</div>