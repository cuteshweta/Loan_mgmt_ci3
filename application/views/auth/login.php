<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Loan Management System</title>
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
                        <h3 class="card-title text-center mb-4">User Login</h3>

                        <?php if($this->session->flashdata('error')): ?>
                            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
                        <?php endif; ?>

                        <?= form_open('auth/login') ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" 
                                    class="form-control" required autofocus>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" 
                                    class="form-control" required>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted">Don't have an account? 
                                    <a href="<?= base_url('register') ?>">Register here</a>
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