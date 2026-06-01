<?php

function dp_get_login_deletion_status($conn, $login_id)
{
    $login_id = (int) $login_id;
    $result = mysqli_query(
        $conn,
        "SELECT `deletion_request`, `account_status` FROM `login` WHERE `login_id` = '$login_id' LIMIT 1"
    );

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}

function dp_submit_deletion_request($conn, $login_id)
{
    $login_id = (int) $login_id;
    $status = dp_get_login_deletion_status($conn, $login_id);

    if (!$status) {
        return ['ok' => false, 'message' => 'Account not found.'];
    }

    if (isset($status['account_status']) && $status['account_status'] === 'deleted') {
        return ['ok' => false, 'message' => 'This account is already deleted.'];
    }

    if ((int) ($status['deletion_request'] ?? 0) === 1) {
        return [
            'ok' => false,
            'already_sent' => true,
            'message' => 'Wait for admin response. Request already sent.',
        ];
    }

    $update = mysqli_query($conn, "UPDATE `login` SET `deletion_request` = 1 WHERE `login_id` = '$login_id'");

    if ($update) {
        return [
            'ok' => true,
            'message' => 'Account deletion request sent to admin successfully.',
        ];
    }

    return ['ok' => false, 'message' => 'Could not send deletion request. Please try again.'];
}

function dp_clear_deletion_request($conn, $login_id)
{
    $login_id = (int) $login_id;
    return mysqli_query($conn, "UPDATE `login` SET `deletion_request` = 0 WHERE `login_id` = '$login_id'");
}

function dp_soft_delete_login($conn, $login_id, $role_id = null)
{
    $login_id = (int) $login_id;
    dp_clear_deletion_request($conn, $login_id);

    $sql = "UPDATE `login`
            SET `account_status` = 'deleted', `activation_request` = 0, `deletion_request` = 0
            WHERE `login_id` = '$login_id'";

    if ($role_id !== null) {
        $role_id = (int) $role_id;
        $sql .= " AND `role_id` = '$role_id'";
    }

    return mysqli_query($conn, $sql);
}
