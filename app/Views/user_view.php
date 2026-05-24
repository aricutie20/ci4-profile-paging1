<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Hub | User Directory & Paging</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        
        header {
            background-color: #fff;
            padding: 20px 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 24px;
            color: #111827;
            margin: 0;
            font-weight: 600;
        }

        header .brand-logo {
            font-weight: 600;
            color: #4f46e5; 
            font-size: 28px;
            margin: 0;
        }

        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* --- Grid Layout --- */
        .grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 40px;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4b5563;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: inherit;
        }

        input[type="file"] {
            padding: 10px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: #4338ca;
        }

        /* --- Table Styling --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f9fafb;
            color: #6b7280;
            font-weight: 500;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .no-avatar {
            display: inline-block;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e5e7eb;
            color: #9ca3af;
            text-align: center;
            line-height: 50px;
            font-size: 14px;
        }

        /* --- Pagination & Search --- */
        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-form input {
            flex-grow: 1;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            color: #4b5563;
            text-decoration: none;
        }

        .pagination a:hover {
            background-color: #f3f4f6;
        }

        .pagination .active {
            background-color: #4f46e5;
            color: #fff;
            border-color: #4f46e5;
        }

        /* --- Unique / Fun --- */
        .avatar-label-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-circle {
            background-color: #e0e7ff;
            color: #4f46e5;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>

<header>
    <div class="brand-logo">PH</div> <h1>Profile Hub</h1>
</header>

<div class="container">
    <div class="grid">
        <div class="card">
            <div class="icon-circle">
                <i class="fas fa-user-plus"></i> </div>
            <h2>Create New Profile</h2>
            <p style="color: #6b7280; margin-bottom: 30px;">Add a new user to the directory.</p>
            <form action="<?= base_url('users/upload') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required>
                </div>
                <div class="form-group">
                    <label for="avatar">Upload Avatar</label>
                    <input type="file" id="avatar" name="avatar" required>
                </div>
                <button type="submit">Create Profile</button>
            </form>
        </div>

        <div class="card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>User Directory</h2>
                <form action="<?= base_url('users') ?>" method="get" class="search-form">
                    <input type="text" name="search" placeholder="Search by name..." value="<?= esc($search) ?>">
                    <button type="submit">Search</button>
                </form>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users) && count($users) > 0): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($user['avatar'])): ?>
                                        <img src="<?= base_url('uploads/' . $user['avatar']) ?>" alt="Avatar" class="user-avatar">
                                    <?php else: ?>
                                        <span class="no-avatar">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($user['name']) ?></td>
                                <td><?= esc($user['email']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/你的_kit_code.js" crossorigin="anonymous"></script> </body>
</html>