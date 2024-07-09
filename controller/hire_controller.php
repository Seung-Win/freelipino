<?php
require_once '../config.php';
session_start();

if (isset($_POST['save_freelancer'])) {
    $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);
    $client_id = $_SESSION['user_id'];
    $comment = mysqli_real_escape_string($conn, $_POST['jobDescription']);

    $insert_query = "INSERT INTO transactions (client_id, job_id, cl_comment)
                             VALUES (?, ?, ?)";
    $statement_insert = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($statement_insert, "iis", $client_id, $job_id, $comment);

    if (mysqli_stmt_execute($statement_insert)) {
        $res = [
            'status' => 200,
            'message' => 'Thank you for adding jobs'
        ];
        echo json_encode($res);
        exit;
    } else {
        $res = [
            'status' => 500,
            'message' => 'Error in adding job: ' . mysqli_error($conn)
        ];
        echo json_encode($res);
        exit;
    }
} else {
    // Failed to move the uploaded file
    $res = [
        'status' => 500,
        'message' => 'Failed to move the uploaded file'
    ];
    echo json_encode($res);
    exit;
}

// Image file upload failed
$res = [
    'status' => 422,
    'message' => 'Image upload failed'
];
echo json_encode($res);
exit;

$conn->close();
?>