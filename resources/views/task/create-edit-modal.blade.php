<div class="modal-header">
    <h5 class="modal-title" id="taskModalHeading">Create Task</h5>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="task-title" class="col-form-label">Title</label>
        <input type="text" class="form-control" id="task-title" name="title" placeholder="Enter Task title"
            value="{{isset($task)?$task->title:''}}">
    </div>
    <div class="form-group">
        <label for="decriprion" class="col-form-label">Description</label>
        <textarea class="form-control" id="decriprion"
            name="description">{{isset($task)?$task->description:''}}</textarea>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status">
            <option value="open" {{isset($task) && $task->status == "open"? 'selected' : ''}}>Open</option>
            <option value="in-progress" {{isset($task) && $task->status == "in-progress"? 'selected' : ''}}>In-progress
            </option>
            <option value="completed" {{isset($task) && $task->status == "completed"? 'selected' : ''}}>completed
            </option>
        </select>
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-info text-dark">{{isset($task) ? 'Update' : 'Save'}}</button>
</div>