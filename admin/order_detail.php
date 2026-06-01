<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';

// Validate order_id
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header('location: view_order.php');
    exit;
}
$order_id = (int) $_GET['order_id'];

// ── 1. ORDER MASTER ───────────────────────────────────────────────────────────
$sql_om = "SELECT om.*, c.first_name, c.last_name, c.email AS cust_email,
                   c.phone AS cust_phone_profile, c.address AS cust_address,
                   c.area AS cust_area, c.pincode AS cust_pincode,
                   ci.city_name
           FROM order_master om
           LEFT JOIN customer c  ON om.customer_id = c.customer_id
           LEFT JOIN city ci     ON c.city_id = ci.city_id
           WHERE om.order_id = ?";
$stmt = mysqli_prepare($conn, $sql_om);
mysqli_stmt_bind_param($stmt, 'i', $order_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    header('location: view_order.php');
    exit;
}

// ── 2. ORDER ITEMS (user_order) ───────────────────────────────────────────────
$sql_items = "SELECT uo.*, s.service_name, cat.category_name,
                     sp.sp_name, sp.email AS sp_email, sp.phone AS sp_phone,
                     sp.area AS sp_area, sp.pincode AS sp_pincode,
                     ci2.city_name AS sp_city,
                     sp.wallet_balance, sp.status AS sp_status
              FROM user_order uo
              LEFT JOIN service s    ON uo.service_id = s.service_id
              LEFT JOIN category cat ON s.category_id = cat.category_id
              LEFT JOIN sp           ON uo.sp_id = sp.sp_id
              LEFT JOIN city ci2     ON sp.city_id = ci2.city_id
              WHERE uo.order_id = ?";
$stmt2 = mysqli_prepare($conn, $sql_items);
mysqli_stmt_bind_param($stmt2, 'i', $order_id);
mysqli_stmt_execute($stmt2);
$items_result = mysqli_stmt_get_result($stmt2);
$items = [];
while ($row = mysqli_fetch_assoc($items_result)) {
    $items[] = $row;
}

// ── 3. CUSTOMER REVIEWS (SP rated customer) ───────────────────────────────────
$sql_cr = "SELECT cr.*, sp.sp_name FROM customer_reviews cr
           LEFT JOIN sp ON cr.sp_id = sp.sp_id
           WHERE cr.order_id = ?";
$stmt3 = mysqli_prepare($conn, $sql_cr);
mysqli_stmt_bind_param($stmt3, 'i', $order_id);
mysqli_stmt_execute($stmt3);
$cr_result = mysqli_stmt_get_result($stmt3);
$customer_reviews = [];
while ($row = mysqli_fetch_assoc($cr_result)) {
    $customer_reviews[] = $row;
}

// ── 4. SP REVIEWS (customer rated SP) ────────────────────────────────────────
$sql_sr = "SELECT sr.*, sp.sp_name FROM sp_reviews sr
           LEFT JOIN sp ON sr.sp_id = sp.sp_id
           WHERE sr.order_id = ?";
$stmt4 = mysqli_prepare($conn, $sql_sr);
mysqli_stmt_bind_param($stmt4, 'i', $order_id);
mysqli_stmt_execute($stmt4);
$sr_result = mysqli_stmt_get_result($stmt4);
$sp_reviews = [];
while ($row = mysqli_fetch_assoc($sr_result)) {
    $sp_reviews[] = $row;
}

// ── Helper: overall order status ──────────────────────────────────────────────
function getOverallStatus($items) {
    if (empty($items)) return 'pending';
    $statuses = array_column($items, 'status');
    if (in_array('cancelled', $statuses)) return 'cancelled';
    if (in_array('rejected', $statuses))  return 'rejected';
    if (in_array('inprogress', $statuses)) return 'inprogress';
    if (in_array('confirm', $statuses))    return 'confirmed';
    if (in_array('completed', $statuses))  return 'completed';
    if (in_array('uncompleted', $statuses)) return 'uncompleted';
    return $statuses[0] ?? 'pending';
}
function statusBadge($status) {
    $map = [
        'completed'   => 'success',
        'inprogress'  => 'primary',
        'confirm'     => 'primary',
        'confirmed'   => 'primary',
        'rejected'    => 'danger',
        'cancelled'   => 'danger',
        'uncompleted' => 'warning',
        'pending'     => 'secondary',
    ];
    return $map[strtolower($status)] ?? 'secondary';
}
function starRating($rating) {
    $html = '';
    for ($i = 1; $i <= 5; $i++) {
        $html .= '<i class="fa fa-star' . ($i <= $rating ? '' : '-o') . '" style="color:#f5a623;"></i>';
    }
    return $html;
}

$overall_status = getOverallStatus($items);
?>

<!-- ═══════════════════════════ CUSTOM STYLES ═══════════════════════════ -->
<style>
    .od-card          { border:none; border-radius:10px; box-shadow:0 2px 12px rgba(0,0,0,.08); margin-bottom:20px; }
    .od-card .card-header { border-radius:10px 10px 0 0; font-weight:700; font-size:.95rem; padding:12px 18px; }
    .od-card .card-body   { padding:18px; }
    .detail-row       { display:flex; padding:7px 0; border-bottom:1px solid #f0f0f0; }
    .detail-row:last-child { border-bottom:none; }
    .detail-label     { min-width:160px; font-weight:600; color:#555; font-size:.85rem; }
    .detail-value     { color:#222; font-size:.88rem; }
    .status-pill      { padding:5px 14px; border-radius:20px; font-size:.8rem; font-weight:700; display:inline-block; }
    .timeline         { border-left:3px solid #dee2e6; padding-left:20px; margin-left:10px; }
    .tl-item          { position:relative; padding-bottom:18px; }
    .tl-item:last-child { padding-bottom:0; }
    .tl-dot           { width:13px; height:13px; border-radius:50%; position:absolute; left:-26px; top:4px; }
    .od-summary-box   { background:linear-gradient(135deg,#1a3a6b,#2563b0); color:#fff; border-radius:10px; padding:20px 24px; margin-bottom:20px; }
    .od-summary-box h2 { font-size:2rem; font-weight:800; margin:0; }
    .od-summary-box small { opacity:.75; }
    .item-card        { background:#f8f9fb; border-radius:8px; padding:14px 18px; margin-bottom:12px; border-left:4px solid #2563b0; }
    .sp-avatar        { width:40px; height:40px; background:#2563b0; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1.1rem; flex-shrink:0; }
</style>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">

    <!-- ── Breadcrumb ── -->
    <div class="row mb-3">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <div>
                <h5 class="mb-0"><strong>Order Detail</strong></h5>
                <span class="text-secondary small">
                    Dashboard <i class="fa fa-angle-right"></i>
                    <a href="view_order.php">View Orders</a>
                    <i class="fa fa-angle-right"></i> Order #<?php echo $order_id; ?>
                </span>
            </div>
            <a href="view_order.php" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left mr-1"></i> Back to Orders
            </a>
        </div>
    </div>

    <!-- ── Summary Banner ── -->
    <div class="od-summary-box">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small>Order ID</small>
                <h2>#<?php echo $order_id; ?></h2>
                <span class="badge badge-light text-dark p-2 mr-2">
                    <?php echo $order['pay_mode']; ?>
                </span>
                <span class="badge badge-<?php echo statusBadge($overall_status); ?> p-2">
                    <?php echo ucfirst($overall_status); ?>
                </span>
                <?php if (!empty($order['urgency_level']) && $order['urgency_level'] != 'normal'): ?>
                    <span class="badge badge-warning p-2 ml-1">
                        <i class="fa fa-exclamation-triangle mr-1"></i><?php echo ucfirst($order['urgency_level']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="col-md-3 text-center mt-3 mt-md-0">
                <small>Order Date</small>
                <div style="font-size:1rem;font-weight:600;"><?php echo date('d M Y', strtotime($order['order_date'])); ?></div>
                <small><?php echo date('h:i A', strtotime($order['order_date'])); ?></small>
            </div>
            <div class="col-md-3 text-center mt-3 mt-md-0">
                <small>Total Amount</small>
                <div style="font-size:1.6rem;font-weight:800;">Rs. <?php echo number_format($order['total'], 0); ?></div>
                <?php if ($order['commission'] > 0): ?>
                    <small>Commission: Rs. <?php echo number_format($order['commission'], 2); ?></small>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- ══════════════════ LEFT COLUMN ══════════════════ -->
        <div class="col-lg-6">

            <!-- Customer Info -->
            <div class="card od-card">
                <div class="card-header bg-primary text-white">
                    <i class="fa fa-user mr-2"></i> Customer Information
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <span class="detail-label">Full Name</span>
                        <span class="detail-value font-weight-bold">
                            <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Order Name</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['full_name']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value">
                            <?php if (!empty($order['cust_email'])): ?>
                                <a href="mailto:<?php echo htmlspecialchars($order['cust_email']); ?>">
                                    <?php echo htmlspecialchars($order['cust_email']); ?>
                                </a>
                            <?php else: echo '—'; endif; ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone (Profile)</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['cust_phone_profile'] ?? '—'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Phone (Order)</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['phone']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">City</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['city_name'] ?? '—'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Area</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['cust_area'] ?? '—'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Delivery Address</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['address']); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Pincode</span>
                        <span class="detail-value"><?php echo htmlspecialchars($order['pincode']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Payment & Dates -->
            <div class="card od-card">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-money mr-2"></i> Payment & Schedule
                </div>
                <div class="card-body">
                    <div class="detail-row">
                        <span class="detail-label">Payment Mode</span>
                        <span class="detail-value">
                            <span class="badge badge-info p-2"><?php echo $order['pay_mode']; ?></span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Total Amount</span>
                        <span class="detail-value font-weight-bold text-success" style="font-size:1.1rem;">
                            Rs. <?php echo number_format($order['total'], 0); ?>
                        </span>
                    </div>
                    <?php if ($order['base_total']): ?>
                    <div class="detail-row">
                        <span class="detail-label">Base Total</span>
                        <span class="detail-value">Rs. <?php echo number_format($order['base_total'], 2); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="detail-row">
                        <span class="detail-label">Commission (5%)</span>
                        <span class="detail-value text-danger font-weight-bold">
                            Rs. <?php echo number_format($order['commission'], 2); ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Urgency Level</span>
                        <span class="detail-value">
                            <?php
                            $urg = $order['urgency_level'] ?? 'normal';
                            $urg_badge = ['normal'=>'secondary','urgent'=>'warning','emergency'=>'danger'];
                            echo '<span class="badge badge-' . ($urg_badge[$urg] ?? 'secondary') . ' p-1">' . ucfirst($urg) . '</span>';
                            ?>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Order Date</span>
                        <span class="detail-value"><?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Due / Schedule Date</span>
                        <span class="detail-value"><?php echo date('d M Y, h:i A', strtotime($order['due_date'])); ?></span>
                    </div>
                </div>
            </div>

            <!-- Reviews given by customer on SP -->
            <div class="card od-card">
                <div class="card-header bg-warning text-dark">
                    <i class="fa fa-star mr-2"></i> Customer → SP Reviews
                </div>
                <div class="card-body">
                    <?php if (empty($customer_reviews)): ?>
                        <p class="text-muted mb-0"><i class="fa fa-info-circle mr-1"></i> No reviews submitted by customer yet.</p>
                    <?php else: ?>
                        <?php foreach ($customer_reviews as $rev): ?>
                            <div class="mb-3 p-3" style="background:#fffbee;border-radius:8px;border-left:4px solid #f5a623;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong><?php echo htmlspecialchars($rev['sp_name'] ?? 'SP'); ?></strong>
                                    <span><?php echo starRating($rev['rating']); ?></span>
                                </div>
                                <p class="mb-1 mt-2 text-muted small">"<?php echo htmlspecialchars($rev['review_text']); ?>"</p>
                                <small class="text-muted"><?php echo date('d M Y', strtotime($rev['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /left column -->

        <!-- ══════════════════ RIGHT COLUMN ══════════════════ -->
        <div class="col-lg-6">

            <!-- Services & SP Details -->
            <div class="card od-card">
                <div class="card-header" style="background:#1a3a6b;color:#fff;">
                    <i class="fa fa-list-alt mr-2"></i> Services Ordered
                    <span class="badge badge-light text-dark ml-2"><?php echo count($items); ?> item(s)</span>
                </div>
                <div class="card-body">
                    <?php if (empty($items)): ?>
                        <p class="text-muted">No service items found for this order.</p>
                    <?php else: ?>
                        <?php foreach ($items as $item):
                            $istatus = $item['status'] ?? 'pending';
                        ?>
                        <div class="item-card">
                            <!-- Service Header -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong style="font-size:.95rem;"><?php echo htmlspecialchars($item['service_title']); ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <?php echo htmlspecialchars($item['category_name'] ?? ''); ?> &rsaquo;
                                        <?php echo htmlspecialchars($item['service_name'] ?? ''); ?>
                                    </small>
                                </div>
                                <span class="badge badge-<?php echo statusBadge($istatus); ?> p-2">
                                    <?php echo ucfirst($istatus); ?>
                                </span>
                            </div>

                            <!-- Price & Qty -->
                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted">Unit Price</small>
                                    <div class="font-weight-bold">Rs. <?php echo number_format((float)$item['price'], 0); ?></div>
                                </div>
                                <div class="col-3">
                                    <small class="text-muted">Qty</small>
                                    <div class="font-weight-bold"><?php echo $item['qty']; ?></div>
                                </div>
                                <div class="col-3">
                                    <small class="text-muted">Subtotal</small>
                                    <div class="font-weight-bold text-success">
                                        Rs. <?php echo number_format((float)$item['price'] * $item['qty'], 0); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- SP Info -->
                            <hr style="margin:8px 0;">
                            <div class="d-flex align-items-center mb-2">
                                <div class="sp-avatar mr-3">
                                    <?php echo strtoupper(substr($item['sp_name'] ?? 'S', 0, 1)); ?>
                                </div>
                                <div>
                                    <div class="font-weight-bold" style="font-size:.9rem;">
                                        <?php echo htmlspecialchars($item['sp_name'] ?? '—'); ?>
                                        <span class="badge badge-<?php echo ($item['sp_status'] == 'active') ? 'success' : 'danger'; ?> ml-1" style="font-size:.65rem;">
                                            <?php echo ucfirst($item['sp_status'] ?? ''); ?>
                                        </span>
                                    </div>
                                    <small class="text-muted">Service Provider</small>
                                </div>
                            </div>
                            <div style="font-size:.82rem;" class="ml-1">
                                <?php if (!empty($item['sp_email'])): ?>
                                <div><i class="fa fa-envelope mr-1 text-muted"></i>
                                    <a href="mailto:<?php echo htmlspecialchars($item['sp_email']); ?>">
                                        <?php echo htmlspecialchars($item['sp_email']); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($item['sp_phone'])): ?>
                                <div><i class="fa fa-phone mr-1 text-muted"></i>
                                    <?php echo htmlspecialchars($item['sp_phone']); ?>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($item['sp_city'])): ?>
                                <div><i class="fa fa-map-marker mr-1 text-muted"></i>
                                    <?php echo htmlspecialchars($item['sp_city']); ?>
                                    <?php echo !empty($item['sp_area']) ? ' – ' . htmlspecialchars($item['sp_area']) : ''; ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Status Timeline for this item -->
                            <div class="mt-2 pt-2" style="border-top:1px dashed #ddd;">
                                <small class="text-muted font-weight-bold">Order Timeline</small>
                                <div class="timeline mt-2">
                                    <?php
                                    $tl_steps = [
                                        ['status'=>'pending',     'label'=>'Order Placed',       'color'=>'#6c757d'],
                                        ['status'=>'confirm',     'label'=>'SP Approved / Confirmed','color'=>'#007bff'],
                                        ['status'=>'inprogress',  'label'=>'Service In Progress', 'color'=>'#17a2b8'],
                                        ['status'=>'completed',   'label'=>'Service Completed',  'color'=>'#28a745'],
                                        ['status'=>'rejected',    'label'=>'Rejected by SP',     'color'=>'#dc3545'],
                                        ['status'=>'cancelled',   'label'=>'Cancelled by Customer','color'=>'#dc3545'],
                                        ['status'=>'uncompleted', 'label'=>'Marked Uncompleted', 'color'=>'#ffc107'],
                                    ];
                                    // Define natural order for progress
                                    $progress_order = ['pending','confirm','inprogress','completed'];
                                    $current = strtolower($item['status']);
                                    $is_terminal = in_array($current, ['rejected','cancelled','uncompleted']);

                                    // Decide which steps to show
                                    $show_steps = [];
                                    foreach ($tl_steps as $step) {
                                        if (in_array($step['status'], $progress_order)) {
                                            $show_steps[] = $step;
                                        } elseif ($step['status'] === $current && $is_terminal) {
                                            $show_steps[] = $step;
                                        }
                                    }

                                    foreach ($show_steps as $step):
                                        $is_current  = ($step['status'] === $current);
                                        $step_idx    = array_search($step['status'], $progress_order);
                                        $curr_idx    = array_search($current, $progress_order);
                                        $is_done     = ($step_idx !== false && $curr_idx !== false && $step_idx <= $curr_idx) || ($is_terminal && $is_current);
                                        $dot_bg      = $is_done ? $step['color'] : '#dee2e6';
                                    ?>
                                    <div class="tl-item">
                                        <div class="tl-dot" style="background:<?php echo $dot_bg; ?>;"></div>
                                        <span style="font-size:.8rem;font-weight:<?php echo $is_current ? '700' : '400'; ?>;color:<?php echo $is_done ? '#333' : '#aaa'; ?>;">
                                            <?php echo $step['label']; ?>
                                            <?php if ($is_current): ?>
                                                <span class="badge badge-<?php echo statusBadge($current); ?> ml-1" style="font-size:.65rem;">Current</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SP Reviews on Customer -->
            <div class="card od-card">
                <div class="card-header bg-info text-white">
                    <i class="fa fa-star mr-2"></i> SP → Customer Reviews
                </div>
                <div class="card-body">
                    <?php if (empty($sp_reviews)): ?>
                        <p class="text-muted mb-0"><i class="fa fa-info-circle mr-1"></i> No reviews given by SP yet.</p>
                    <?php else: ?>
                        <?php foreach ($sp_reviews as $rev): ?>
                            <div class="mb-3 p-3" style="background:#f0f8ff;border-radius:8px;border-left:4px solid #17a2b8;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong><?php echo htmlspecialchars($rev['sp_name'] ?? 'SP'); ?></strong>
                                    <span><?php echo starRating($rev['rating']); ?></span>
                                </div>
                                <p class="mb-1 mt-2 text-muted small">"<?php echo htmlspecialchars($rev['review_text']); ?>"</p>
                                <small class="text-muted"><?php echo date('d M Y', strtotime($rev['created_at'])); ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /right column -->
    </div><!-- /row -->

    <!-- ── Order Summary Footer ── -->
    <div class="card od-card">
        <div class="card-header bg-dark text-white">
            <i class="fa fa-calculator mr-2"></i> Order Financial Summary
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <div style="font-size:.8rem;color:#999;text-transform:uppercase;font-weight:600;">Total Services</div>
                    <div style="font-size:1.6rem;font-weight:800;color:#1a3a6b;"><?php echo count($items); ?></div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div style="font-size:.8rem;color:#999;text-transform:uppercase;font-weight:600;">Order Amount</div>
                    <div style="font-size:1.6rem;font-weight:800;color:#28a745;">Rs. <?php echo number_format($order['total'], 0); ?></div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div style="font-size:.8rem;color:#999;text-transform:uppercase;font-weight:600;">Platform Commission</div>
                    <div style="font-size:1.6rem;font-weight:800;color:#dc3545;">Rs. <?php echo number_format($order['commission'], 2); ?></div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div style="font-size:.8rem;color:#999;text-transform:uppercase;font-weight:600;">SP Earnings</div>
                    <div style="font-size:1.6rem;font-weight:800;color:#007bff;">
                        Rs. <?php echo number_format(max(0, $order['total'] - $order['commission']), 2); ?>
                    </div>
                </div>
            </div>

            <!-- Status breakdown -->
            <?php
            $status_counts = [];
            foreach ($items as $item) {
                $s = $item['status'] ?? 'pending';
                $status_counts[$s] = ($status_counts[$s] ?? 0) + 1;
            }
            ?>
            <?php if (!empty($status_counts)): ?>
            <hr>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <?php foreach ($status_counts as $st => $cnt): ?>
                    <span class="badge badge-<?php echo statusBadge($st); ?> p-2 mr-2" style="font-size:.85rem;">
                        <?php echo ucfirst($st); ?>: <?php echo $cnt; ?>
                    </span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Page JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>

</div><!-- /content -->

<?php include 'assets/include/admin_footer.php'; ?>
