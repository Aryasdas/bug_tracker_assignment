<?php
function getAllBugs($conn) {
    $sql = "SELECT b.*, 
                   u1.username as reported_by_name, 
                   u2.username as assigned_to_name 
            FROM bugs b
            LEFT JOIN users u1 ON b.reported_by = u1.id
            LEFT JOIN users u2 ON b.assigned_to = u2.id
            ORDER BY b.created_at DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
function getAllUsers($conn) {
    $users = [];
    $query = "SELECT id, username FROM users ORDER BY username ASC";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    
    return $users;
}






function getBugsAssignedToUser($conn, $userId) {
    $stmt = $conn->prepare("SELECT b.*, u.username as reported_by_name 
                           FROM bugs b
                           JOIN users u ON b.reported_by = u.id
                           WHERE b.assigned_to = ?
                           ORDER BY b.created_at DESC");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}





function severityColor($severity) {
    return match ($severity) {
        'Critical' => 'danger',
        'High'     => 'warning',
        'Medium'   => 'primary',
        'Low'      => 'secondary',
        default    => 'light'
    };
}
function statusColor($status) {
    return match ($status) {
        'Open'        => 'info',
        'In Progress' => 'warning',
        'Resolved'    => 'success',
        'Closed'      => 'secondary',
        default       => 'light'
    };
}

function logActivity($conn, $user_id, $activity) {
    $stmt = $conn->prepare("INSERT INTO activity_log (user_id, activity, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $user_id, $activity);
    $stmt->execute();
}
function getBugsAssignedToDeveloper($conn, $developer_id) {
    $stmt = $conn->prepare("SELECT * FROM bugs WHERE assigned_to = ?");
    $stmt->bind_param("i", $developer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $bugs = [];
    while ($row = $result->fetch_assoc()) {
        $bugs[] = $row;
    }

    $stmt->close();
    return $bugs;
}


function getBugsReportedByUser($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM bugs WHERE reported_by = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $bugs = [];
    while ($row = $result->fetch_assoc()) {
        $bugs[] = $row;
    }

    $stmt->close();
    return $bugs;
}

?>

