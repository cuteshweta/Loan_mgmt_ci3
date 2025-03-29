<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - Loan Management System</title>
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
                <div class="d-flex justify-content-between mb-4">
                    <h2>My Loans</h2>
                    <div>
                        <a href="<?= base_url('customer/apply_loan') ?>" class="btn btn-primary">
                            Apply New Loan
                        </a>
                        <a href="<?= base_url('customer/repayments') ?>" class="btn btn-secondary">
                            View Repayments
                        </a>
                    </div>
                </div>

                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                <?php endif; ?>

                <div class="card shadow">
                    <div class="card-body">
                        <?php if(empty($loans)): ?>
                            <div class="text-center py-5">
                                <h4>No loans found</h4>
                                <p>Start by applying for a new loan</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Amount</th>
                                            <th>Tenure</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Applied Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($loans as $loan): ?>
                                        <tr>
                                            <td>$<?= number_format($loan->amount, 2) ?></td>
                                            <td><?= $loan->tenure ?> months</td>
                                            <td><?= htmlspecialchars($loan->purpose) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $loan->status === 'approved' ? 'success' : 
                                                    ($loan->status === 'rejected' ? 'danger' : 'warning') ?>">
                                                    <?= ucfirst($loan->status) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($loan->applied_at)) ?></td>
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
</body>
</html>