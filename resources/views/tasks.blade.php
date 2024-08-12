<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- DataTables Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">

    <!-- DataTables Buttons Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.bootstrap5.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">To-Do List App</h1>

        <div class="input-group mb-3">
            <input type="text" id="taskInput" class="form-control" placeholder="Add New Task">
            <div class="input-group-append">
                <button class="btn btn-primary" id="addTaskButton">Add Task</button>
            </div>
        </div>

        <table class="table" id="task-list">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskList">
                <!-- Tasks will be appended here -->
            </tbody>
        </table>
        <!-- <button class="btn btn-secondary" id="showAllTasksButton">Show All Tasks</button> -->
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add CSRF Token to AJAX Requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table;
            $(function() {
                // Data Table Ajax
                table = $('#task-list').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "bFilter": true,
                    "bLengthChange": true,
                    "ordering": true,
                    "aaSorting": [],
                    "iDisplayLength": 20,
                    "responsive": true,
                    "searching": false,
                    "ajax": {
                        url: "/show",
                        "type": "GET",
                        "data": function(d) {

                        },
                        "dataType": "json",
                        "dataSrc": function(jsonData) {
                            return jsonData.data;
                        }
                    },

                    "columnDefs": [{
                            "targets": [0, 1, 2, 3], // Show only these columns by default
                            "visible": true,
                            "orderable": false,
                        },
                        {
                            "targets": '_all', // Hide the rest
                            "visible": false,
                            "orderable": false,
                        }
                    ],
                    // "fixedColumns": {
                    //     "leftColumns": 2
                    // },
                    "buttons": [{
                        extend: 'colvis',
                        text: 'Select Columns',
                        className: 'custom-colvis-button'
                    }],
                    "dom": 'Bfrtip',
                    // scrollCollapse: true,
                    scrollX: true,
                });
            });


            // Add Task Button Click Event
            $('#addTaskButton').on('click', function(e) {
                e.preventDefault();
                let taskName = $('#taskInput').val();

                if (taskName !== '') {
                    $.ajax({
                        url: '/tasks',
                        method: 'POST',
                        data: {
                            task: taskName
                        },
                        success: function(task) {
                            table.ajax.reload();
                            $('#taskInput').val('');
                        },
                        error: function(response) {
                            alert('Task already exists or an error occurred.');
                        }
                    });
                }
            });

            // Delete Task Event
            $(document).on('click', '.deleteTask', function() {
                if (confirm('Are you sure you want to delete this task?')) {
                    let taskId = $(this).data('id');

                    $.ajax({
                        url: `/tasks/${taskId}`,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                $(`#task-${taskId}`).remove();
                                table.ajax.reload();
                            }
                        }
                    });
                }
            });

            // Mark Task as Completed Event
            $(document).on('click', '.mark-complete', function() {
                let taskId = $(this).data('id');

                $.ajax({
                    url: `/tasks/${taskId}/status`,
                    method: 'PATCH',
                    success: function(task) {
                        table.ajax.reload();
                      
                    }
                });
            });
        });
    </script>
</body>

</html>