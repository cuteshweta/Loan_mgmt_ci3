<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Loan Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="#">Loan System</a>
                <div class="navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('auth/logout') ?>">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row">
            <div class="col-md-10 mx-auto">
                <h2 class="mb-4">Loan Applications</h2>
                
                <!-- Status Filter -->
                <div class="mb-3">
                    <select class="form-select" id="statusFilter" onchange="filterLoans(this.value)">
                        <option value="">All Applications</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <!-- Loans Table -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Tenure</th>
                                        <th>Status</th>
                                        <th>Applied Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($loans as $loan): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($loan->username) ?></td>
                                        <td>$<?= number_format($loan->amount, 2) ?></td>
                                        <td><?= $loan->tenure ?> months</td>
                                        <td>
                                            <span class="badge bg-<?= 
                                                $loan->status === 'approved' ? 'success' : 
                                                ($loan->status === 'rejected' ? 'danger' : 'warning') ?>">
                                                <?= ucfirst($loan->status) ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($loan->applied_at)) ?></td>
                                        <td>
                                            <?php if($loan->status === 'pending'): ?>
                                                <button class="btn btn-sm btn-success approve-btn" 
                                                    data-id="<?= $loan->id ?>">
                                                    Approve
                                                </button>
                                                <button class="btn btn-sm btn-danger reject-btn" 
                                                    data-id="<?= $loan->id ?>">
                                                    Reject
                                                </button>
                                            <?php endif; ?>
                                            <a href="<?= base_url('admin/loans/'.$loan->id) ?>" 
                                               class="btn btn-sm btn-info">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Handle Approve/Reject actions
        $('.approve-btn, .reject-btn').click(function() {
            const action = $(this).hasClass('approve-btn') ? 'approved' : 'rejected';
            const loanId = $(this).data('id');
            
            $.post('<?= base_url("admin/update_loan_status") ?>', {
                loan_id: loanId,
                status: action,
                <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
            }).done(function() {
                location.reload();
            }).fail(function(xhr) {
                
                alert('Error: ' + xhr.responseText);
            });
        });

        // Set initial filter value
        const urlParams = new URLSearchParams(window.location.search);
        const statusFilter = urlParams.get('status');
        if(statusFilter) {
            $('#statusFilter').val(statusFilter);
        }
    });

    function filterLoans(status) {
        window.location.href = '<?= base_url("admin/dashboard") ?>?status=' + status;
    }
    </script>
</body>
</html>