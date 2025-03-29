<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repayments - Loan Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .overdue { background-color: #ffe6e6; }
        .paid { background-color: #e6ffe6; }
    </style>
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
                <div class="d-flex justify-content-between mb-4">
                    <h2>My Repayments</h2>
                    <div class="h4 text-danger">
                    <a href="<?= base_url('customer/apply_loan') ?>" class="btn btn-primary">
                            Apply New Loan
                        </a>
                    <?php
                     $amount=number_format($total_pending, 2);
                        echo"Total Pending: $".$amount ;
                    
                    ?>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <?php if(empty($repayments)): ?>
                            <div class="text-center py-5">
                                <h4>No repayments found</h4>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Loan Amount</th>
                                            <th>Installment</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Days Left</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($repayments as $repayment): ?>
                                        <tr class="<?= 
                                            $repayment->status === 'paid' ? 'paid' : 
                                            (strtotime($repayment->due_date) < time() ? 'overdue' : '') ?>">
                                            <td>$<?= number_format($repayment->loan_amount, 2) ?></td>
                                            <td>$<?= number_format($repayment->amount, 2) ?></td>
                                            <td><?= date('M d, Y', strtotime($repayment->due_date)) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $repayment->status === 'paid' ? 'success' : 'warning' ?>">
                                                    <?= ucfirst($repayment->status) ?>
                                                </span>
                                                <?php if(strtotime($repayment->due_date) < time() && $repayment->status === 'pending'): ?>
                                                    <span class="badge bg-danger">Overdue</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($repayment->status === 'pending'): ?>
                                                    <?= ceil((strtotime($repayment->due_date) - time()) / (60 * 60 * 24)) ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($repayment->status === 'pending'): ?>
                                                    <button class="btn btn-sm btn-success pay-btn" 
                                                        data-id="<?= $repayment->id ?>"
                                                        data-amount="<?= $repayment->amount ?>">
                                                        Pay Now
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.pay-btn').click(function() {
            const repaymentId = $(this).data('id');
            const amount = $(this).data('amount');
            
            if(confirm(`Confirm payment of $${amount}?`)) {
                $.post('<?= base_url("customer/make_payment") ?>', {
                    repayment_id: repaymentId,
                    amount: amount,
                    <?= $this->security->get_csrf_token_name() ?>: '<?= $this->security->get_csrf_hash() ?>'
                }).done(function() {
                    location.reload();
                }).fail(function(xhr) {
                    alert('Payment failed: ' + xhr.responseText);
                });
            }
        });
    });
    </script>
</body>
</html>