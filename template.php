<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .copy-btn { cursor: pointer; }
        .password-cell { max-width: 150px; }
        .table-container { margin: 20px 0; border-radius: 8px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .controls { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-5">
        <h1 class="text-center mb-4">User Account Generator</h1>
        
        <div class="controls">
            <form method="get" class="row g-3 justify-content-center">
                <div class="col-auto">
                    <label class="form-label">Number of Users:</label>
                    <input type="number" name="count" value="<?= $count ?>" min="1" max="100" class="form-control">
                </div>
                <div class="col-auto">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Generate Users</button>
                </div>
                <div class="col-auto">
                    <label class="form-label">&nbsp;</label>
                    <a href="?format=json&count=<?= $count ?>" class="btn btn-secondary d-block">Download JSON</a>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table id="usersTable" class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>UUID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><small><?= htmlspecialchars($user['user_id']) ?></small></td>
                        <td><?= htmlspecialchars($user['full_name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><code><?= htmlspecialchars($user['username']) ?></code></td>
                        <td class="password-cell">
                            <code><?= htmlspecialchars($user['password']['raw']) ?></code>
                            <i class="copy-btn bi bi-clipboard" data-clipboard-text="<?= htmlspecialchars($user['password']['raw']) ?>"></i>
                        </td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary copy-row" data-user='<?= json_encode($user) ?>'>
                                Copy All
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                order: [[5, 'desc']],
                pageLength: 25
            });
            
            new ClipboardJS('.copy-btn');
            
            $('.copy-row').click(function() {
                const userData = $(this).data('user');
                navigator.clipboard.writeText(JSON.stringify(userData, null, 2));
                alert('User data copied to clipboard!');
            });
        });
    </script>
</body>
</html>
