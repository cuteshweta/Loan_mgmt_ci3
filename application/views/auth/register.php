<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Loan Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <nav class="navbar navbar-light bg-light mb-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= base_url() ?>">Loan System</a>
            </div>
        </nav>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Create Account</h3>

                        <?php if(validation_errors()): ?>
                            <div class="alert alert-danger"><?= validation_errors() ?></div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('success')): ?>
                            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                        <?php endif; ?>

                        <?= form_open('auth/register') ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" 
                                    class="form-control" value="<?= set_value('username') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" 
                                    class="form-control" minlength="6" required>
                            </div>

                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" 
                                    class="form-control" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Register</button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted">Already have an account? 
                                    <a href="<?= base_url('login') ?>">Login here</a>
                                </p>
                            </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>