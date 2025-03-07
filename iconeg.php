<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .view-btn {
            background-color: #008CBA;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .fa {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<?php
// Sample person data
$persons = array(
    array("id" => 1, "name" => "John"),
    array("id" => 2, "name" => "Alice")
);
?>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($persons as $person) : ?>
        <tr>
            <td><?php echo $person['id']; ?></td>
            <td><?php echo $person['name']; ?></td>
            <td>
                <button class="btn edit-btn"><i class="fas fa-edit"></i></button>
                <button class="btn view-btn"><i class="fas fa-eye"></i></button>
                <button class="btn delete-btn"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
