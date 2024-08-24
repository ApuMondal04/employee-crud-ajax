<?php include(CUSTOMER_HEAD); ?>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h1 class="card-title">Customers</h1>
            <div class="d-flex">
                <a href="<?php echo site_url('customers/create'); ?>" class="btn btn-primary me-2"><i class="fas fa-user-plus"></i> Add Customer</a>
                <a href="<?php echo site_url('employees'); ?>" class="btn btn-info"><i class="fas fa-arrow-left"></i> Back to Employees</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered" id="customerTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(CUSTOMER_FOOT); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        
        if ($.fn.DataTable.isDataTable('#customerTable')) {
            $('#customerTable').DataTable().destroy();
        }

       
        $('#customerTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('customers/fetch_data'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "status", "render": function(data) {
                    return data === 'active' ? '<i class="fas fa-circle text-success"></i>' : '<i class="fas fa-circle text-muted"></i>';
                }},
                { "data": "actions", "orderable": false }
            ],
            "language": {
                "processing": "" 
            }
        });

    });

    function confirmDelete(customerId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('customers/delete/'); ?>" + customerId;
            }
        });
    }
</script>

<style>
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-sm {
        font-size: 0.875rem;
        padding: 0.25rem 0.5rem;
    }
    .text-center {
        text-align: center;
    }
    .d-flex a {
        margin-right: 0.5rem; 
    }
    .d-flex a:last-child {
        margin-right: 0; 
    }
    .ms-2 {
        margin-left: 0.5rem !important;
    }

    .d-flex a, .d-flex button {
        margin-right: 0.5rem; 
    }
    .d-flex a:last-child, .d-flex button:last-child {
        margin-right: 0; 
    }

    .dataTables_processing {
    display: none !important;
}

div.dataTables_wrapper div.dataTables_processing {
    display: none !important;
}


.action-buttons a, .action-buttons button {
    margin-right: 5px;
}

.action-buttons a:last-child, .action-buttons button:last-child {
    margin-right: 0;
}
</style>
