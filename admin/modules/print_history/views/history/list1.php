<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Lịch sử in</title>
        <link rel="stylesheet" href="styles.css">
        <!-- jQuery & jQuery UI CSS -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <!-- jQuery & jQuery UI JS -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    </head>

    <style>
        body {
          font-family: Arial, sans-serif;
          margin: 20px;
          background: #f8f9fa;
        }

        h2 {
          margin-bottom: 20px;
        }

        .filters {
          display: flex;
          gap: 10px;
          margin-bottom: 20px;
          flex-wrap: wrap;
        }

        input[type="text"],
        select {
          padding: 6px 8px;
          border: 1px solid #ccc;
          border-radius: 4px;
        }

        .btn {
          padding: 6px 12px;
          border: none;
          border-radius: 4px;
          background: #dee2e6;
          cursor: pointer;
        }

        .btn.primary {
          background: #007bff;
          color: white;
        }

        table {
          width: 100%;
          border-collapse: collapse;
          background: white;
        }

        th, td {
          border: 1px solid #dee2e6;
          padding: 8px;
          text-align: left;
        }

        th {
          background: #f1f1f1;
        }

        a {
          color: blue;
          text-decoration: none;
        }
    </style>
    <body>
        <h2>Lịch sử in</h2>
        <div class="filters">
            <input type="text" placeholder="Tìm kiếm">
           <input type="text" id="start-date" placeholder="Thời gian in">
            <input type="text" id="end-date" placeholder="Đến">
            <button class="btn primary">Tìm kiếm</button>
            <button class="btn">Reset</button>
            <select>
                <option>-- Giờ --</option>
            </select>
            <select>
                <option>-- Kho --</option>
            </select>
            <select>
                <option>-- Sàn --</option>
            </select>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Kho</th>
                    <th>Sàn</th>
                    <th>Giờ</th>
                    <th>File in</th>
                    <th>File đếm</th>
                    <th>File excel tổng hợp theo khung</th>
                    <th>Trạng thái</th>
                    <th>Người in</th>
                    <th>Thời gian tạo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>VLA</td>
                    <td>Shopee</td>
                    <td>7H10</td>
                    <td><a href="#">Xem file</a></td>
                    <td><a href="#">Xem file</a></td>
                    <td><a href="#">Xem file excel</a></td>
                    <td>In thành công 28/28 order</td>
                    <td>admin</td>
                    <td>03/06/2025 07:11</td>
                </tr>
                
                
            </tbody>
        </table>


        <script>
            $(function() {
                $("#start-date").datepicker({
                  dateFormat: "dd/mm/yy"
                });
                $("#end-date").datepicker({
                  dateFormat: "dd/mm/yy"
                });
            });
    </script>
    </body>
</html>