<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details - Loan Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-badge { font-size: 0.9rem; }
        .overdue { background-color: #fff3cd; border-left: 4px solid #ffc107; }
        .paid { background-color: #d4edda; border-left: 4px solid #28a745; }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">Loan System</a>
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
                    <h2>Loan Details</h2>
                    <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                        ← Back to Dashboard
                    </a>
                </div>

                <!-- Loan Summary Card -->
                <div class="card mb-4 shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Loan Information</h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Borrower</dt>
                                    <dd class="col-sm-8"><?= htmlspecialchars($loan->username) ?></dd>

                                    <dt class="col-sm-4">Amount</dt>
                                    <dd class="col-sm-8">$<?= number_format($loan->amount, 2) ?></dd>

                                    <dt class="col-sm-4">Tenure</dt>
                                    <dd class="col-sm-8"><?= $loan->tenure ?> months</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">Status</dt>
                                    <dd class="col-sm-8">
                                        <span class="badge status-badge bg-<?= 
                                            $loan->status === 'approved' ? 'success' : 
                                            ($loan->status === 'rejected' ? 'danger' : 'warning') ?>">
                                            <?= ucfirst($loan->status) ?>
                                        </span>
                                    </dd>

                                    <dt class="col-sm-4">Applied Date</dt>
                                    <dd class="col-sm-8"><?= date('M d, Y', strtotime($loan->applied_at)) ?></dd>

                                    <dt class="col-sm-4">Purpose</dt>
                                    <dd class="col-sm-8"><?= htmlspecialchars($loan->purpose) ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Repayment Schedule -->
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Repayment Schedule</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Installment #</th>
                                        <th>Amount</th>
                                        <th>Due Date</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($repayments as $index => $repayment): ?>
                                    <tr class="<?= 
                                        $repayment->status === 'paid' ? 'paid' : 
                                        (strtotime($repayment->due_date) < time() ? 'overdue' : '') ?>">
                                        <td><?= $index + 1 ?></td>
                                        <td>$<?= number_format($repayment->amount, 2) ?></td>
                                        <td><?= date('M d, Y', strtotime($repayment->due_date)) ?></td>
                                        <td>
                                            <?= $repayment->paid_at ? 
                                                date('M d, Y', strtotime($repayment->paid_at)) : '—' ?>
                                        </td>
                                        <td>
                                            <span class="badge status-badge bg-<?= 
                                                $repayment->status === 'paid' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($repayment->status) ?>
                                            </span>
                                            <?php if(strtotime($repayment->due_date) < time() && $repayment->status === 'pending'): ?>
                                                <span class="badge bg-danger">Overdue</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($repayment->status === 'pending'): ?>
                                                <?= ceil((strtotime($repayment->due_date) - time()) / (60 * 60 * 24)) ?> days
                                            <?php else: ?>
                                                —
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Stats -->
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Total Paid</h6>
                                        <h4 class="card-title text-success">
                                            $<?= number_format(array_reduce($repayments, function($carry, $r) { 
                                                return $carry + ($r->status === 'paid' ? $r->amount : 0); 
                                            }, 0), 2) ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Total Remaining</h6>
                                        <h4 class="card-title text-warning">
                                            $<?= number_format(array_reduce($repayments, function($carry, $r) { 
                                                return $carry + ($r->status === 'pending' ? $r->amount : 0); 
                                            }, 0), 2) ?>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                    <?php if($repayments!==[])
                                    {?>
                                        <div class="card">
                                        <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">Progress</h6>
                                        <div class="progress" style="height: 25px;">
                                            <?php 
                                           
                                                $paid = array_reduce($repayments, function($c, $r) { 
                                                    return $c + ($r->status === 'paid' ? 1 : 0); 
                                                }, 0);
                                                $percent = ($paid / count($repayments)) * 100;
                                            ?>
                                            <div class="progress-bar bg-success" 
                                                 role="progressbar" 
                                                 style="width: <?= $percent ?>%" 
                                                 aria-valuenow="<?= $percent ?>" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                                <?= round($percent) ?>%
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                   <?php }?>
                                    
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Add tooltip for overdue items
        $('.overdue').attr('title', 'This payment is overdue').tooltip();
    });
    </script>
</body>
</html>