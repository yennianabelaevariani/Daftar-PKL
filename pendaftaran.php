    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Daftar Pengguna</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <style>
            /* Reset CSS */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: Arial, sans-serif;
                background-color: #121212;
                color: #fff;
                display: flex;
            }

            /* Sidebar */
            .sidebar {
                width: 250px;
                height: 100vh;
                background-color: #1a191f;
                padding-top: 20px;
                border-right: 2px solid #333;
            }

            .sl {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
                color: #fff;
                margin-bottom: 40px;
            }

            .sidebar__menu {
                list-style: none;
                padding: 0;
            }

            .sidebar__menu li {
                margin-bottom: 10px;
            }

            .sidebar__menu a {
                display: block;
                color: #c0c0c0;
                padding: 12px 20px;
                text-decoration: none;
                font-size: 16px;
                transition: 0.3s ease;
            }

            .sidebar__menu a:hover {
                background-color: #333;
                color: #f9ab00;
            }

            /* Main Content */
            .main-content {
                flex-grow: 1;
                padding: 20px;
            }

            .main-content h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }

            .main-content .controls {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            .controls .add-button {
                background-color: #f9ab00;
                color: #121212;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                font-size: 14px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .controls .add-button:hover {
                background-color: #ffa726;
            }

            /* Table */
            .catalog__table {
                width: 100%;
                border-collapse: collapse;
                border-radius: 8px;
                overflow: hidden;
                background-color: #222028;
            }

            .catalog__table thead {
                background-color: #1a191f;
            }

            .catalog__table th,
            .catalog__table td {
                padding: 15px 20px;
                text-align: left;
                border: none;
            }

            .catalog__table th {
                font-size: 14px;
                color: #c0c0c0;
                font-weight: 400;
            }

            .catalog__table tbody tr {
                border-bottom: 1px solid #333;
            }

            .catalog__table tbody tr:hover {
                background-color: #333;
            }

            .catalog__table tbody td {
                color: #fff;
            }

            .status-visible {
                color: #28a745;
                font-weight: bold;
            }

            /* Action Buttons */
            .catalog__btns {
                display: flex;
                gap: 10px;
            }

            .catalog__btn {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border-radius: 4px;
                background-color: rgba(255, 255, 255, 0.05);
                color: #fff;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .catalog__btn--view {
                background-color: rgba(255, 195, 18, 0.1);
            }

            .catalog__btn--view:hover {
                background-color: rgba(255, 195, 18, 0.2);
            }

            .catalog__btn--edit {
                background-color: rgba(55, 150, 246, 0.1);
            }

            .catalog__btn--edit:hover {
                background-color: rgba(55, 150, 246, 0.2);
            }

            .catalog__btn--delete {
                background-color: rgba(235, 87, 87, 0.1);
            }

            .catalog__btn--delete:hover {
                background-color: rgba(235, 87, 87, 0.2);
            }
        </style>
    </head>

    <body>
        <?php
        require 'koneksi.php';
        $query = "SELECT * FROM internships";
        $result = $conn->query($query);

        if (!$result) {
            die("Error: " . $conn->error);
        }
        ?>

        <div class="sidebar">
            <div class="sl">Menu</div>
            <ul class="sidebar__menu">
                <li><a href="profile.php">Profile</a></li>
                <li><a href="#"> Pendaftaran</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="logout.php"> Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Internships</h1>
            <div class="controls">
                <button class="add-button">Add Internship</button>
            </div>

            <div class="catalog">
                <table class="catalog__table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Perusahaan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Pembimbing Perusahaan</th>
                            <th>Kontak Pembimbing</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['pembimbing_perusahaan']); ?></td>
                                <td><?php echo htmlspecialchars($row['contact_pembimbing']); ?></td>
                                <td class="status-<?php echo strtolower(str_replace(' ', '-', $row['status'])); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </td>
                                <td class="catalog__btns">
                                    <button class="catalog__btn catalog__btn--view"><i class="fas fa-eye"></i></button>
                                    <button class="catalog__btn catalog__btn--edit"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="catalog__btn catalog__btn--delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        $conn->close();
        ?>

    </body>

    </html>