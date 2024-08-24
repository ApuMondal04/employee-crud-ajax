<?php include(CUSTOMER_HEAD); ?>

<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .full-screen-gradient {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(to right, #9160c5, #305aa0);
    }
    .card {
        width: 100%;
        max-width: 500px;
    }

    input:focus, select:focus, textarea:focus, button:focus {
        outline: none;
        box-shadow: none !important;
        border-color: transparent;
    }
</style>

<div class="full-screen-gradient">
    <div class="card">
        <div class="card-header text-center">
            <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Customer</h4>
        </div>
        <div class="card-body">
            <form action="<?php echo site_url('customers/update/'.$customer['id']); ?>" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user"></i> Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $customer['name']; ?>" required pattern="[A-Za-z\s]+" title="Please enter only letters and spaces.">
                </div>
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $customer['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="status"><i class="fas fa-toggle-on"></i> Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="active" <?php echo ($customer['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($customer['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Customer</button>
                    <a href="<?php echo site_url('customers'); ?>" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        const name = document.getElementById('name').value;
        const regex = /^[A-Za-z\s]+$/;

        if (!regex.test(name)) {
            alert('Please enter a valid name with only letters and spaces.');
            return false;
        }
        return true;
    }
</script>

<?php include(CUSTOMER_FOOT); ?>
