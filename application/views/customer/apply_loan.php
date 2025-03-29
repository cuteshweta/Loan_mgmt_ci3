<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Loan - Loan Management System</title>
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
            <div class="col-md-8 mx-auto">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="mb-4">Apply for Loan</h2>

                        <?php if(validation_errors()): ?>
                            <div class="alert alert-danger"><?= validation_errors() ?></div>
                        <?php endif; ?>

                        <?= form_open('customer/apply_loan') ?>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Loan Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="amount" id="amount" 
                                        class="form-control" min="100" step="100" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tenure" class="form-label">Tenure (months)</label>
                                <select name="tenure" id="tenure" class="form-select" required>
                                    <option value="">Select Tenure</option>
                                    <?php for($i=3; $i<=24; $i+=3): ?>
                                        <option value="<?= $i ?>"><?= $i ?> months</option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="purpose" class="form-label">Loan Purpose</label>
                                <textarea name="purpose" id="purpose" 
                                    class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>