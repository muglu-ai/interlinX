<?php
set_time_limit(0);
ini_set('max_execution_time', 0);
// Don't send PHP errors directly to the client (they can break JSON responses).
// Log errors to a file instead so we can inspect them on the server.
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/send_complimentary_delegates_error.log');

// Safely include the DB config. Use include_once and return a JSON error for AJAX
// requests if the file is missing instead of letting PHP emit a fatal and break
// JSON parsing on the client.
$db_file = __DIR__ . '/db.php';
if (!file_exists($db_file)) {
    if (isset($_POST['action']) && $_POST['action'] === 'send_selected') {
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'message' => 'Server configuration error: db.php not found'));
        exit;
    } else {
        // x
        echo '<h2>Configuration error</h2><p>Required file <code>db.php</code> not found.</p>';
        exit;
    }
}

include_once $db_file;

// Use dbCon2 connection
$db_connection = $dbCon2;

// API Configuration
$api_url = 'https://bengalurutechsummit.com/web/bts-interlinx/api/nano/register.php';
$auth_token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6IldrQ29DUGVydGc4NTIxQUdERyIsImV4cCI6MTY5MjcyNTE3OX0.vnHj8kkQCqlTRMeN4YsufEiLddKl11Q7j0qQcBCsASY';
$api_key = 'AIzaSDyD51Q_7VGymsxVBgD3Py4_8ibV3SO0';

// Function to prepare API data for a record
function prepareApiData($row) {
    $api_data = array(
        'email' => !empty($row['email']) ? $row['email'] : '',
        'fname' => !empty($row['first_name']) ? $row['first_name'] : '',
        'lname' => !empty($row['last_name']) ? $row['last_name'] : '',
        'designation' => !empty($row['job_title']) ? $row['job_title'] : '',
        'organisation' => !empty($row['organisation_name']) ? $row['organisation_name'] : '',
        'mobile' => !empty($row['mobile']) ? $row['mobile'] : ''
    );
    
    // Add optional fields if available
    if (!empty($row['title'])) {
        $api_data['title'] = $row['title'];
    }
    if (!empty($row['middle_name'])) {
        $api_data['middle_name'] = $row['middle_name'];
    }
    if (!empty($row['address'])) {
        $api_data['address'] = $row['address'];
    }
    if (!empty($row['city'])) {
        $api_data['city'] = $row['city'];
    }
    if (!empty($row['state'])) {
        $api_data['state'] = $row['state'];
    }
    if (!empty($row['country'])) {
        $api_data['country'] = $row['country'];
    }
    if (!empty($row['postal_code'])) {
        $api_data['postal_code'] = $row['postal_code'];
    }
    
    return $api_data;
}

// Handle API sending via AJAX
if (isset($_POST['action']) && $_POST['action'] == 'send_selected') {
    header('Content-Type: application/json');
    
    if (!isset($_POST['ids']) || empty($_POST['ids'])) {
        echo json_encode(array('success' => false, 'message' => 'No records selected'));
        exit;
    }
    
    $ids = json_decode($_POST['ids']);
    $success_count = 0;
    $error_count = 0;
    $results = array();
    
    foreach ($ids as $id) {
        $id = intval($id);
        
        // Fetch record
        // Note: removed trailing comma from NOT IN list to avoid SQL syntax errors
        $sql = "SELECT * FROM complimentary_delegates WHERE id = $id AND email NOT IN (
            'yvette.eechoud@minbuza.nl',
            'a.baccanari@ice.it',
            'giandomenico.milano@esteri.it',
            'null'
        )
        AND ticketType NOT IN (
            'Business Visitor Pass',
            'Buisness Visitor Pass',
            'Service Pass',
            'Exhibitor',
            'FMC Premium',
            'FMC GO'
        )";
        $result = mysqli_query($db_connection, $sql);
        
        if (!$result || mysqli_num_rows($result) == 0) {
            $error_count++;
            $results[] = array('id' => $id, 'status' => 'error', 'message' => 'Record not found');
            continue;
        }
        
        $row = mysqli_fetch_assoc($result);
      
        // Prepare JSON data for API using the function
        $api_data = prepareApiData($row);
        $json_data = json_encode($api_data);
        
        // Initialize cURL
        $ch = curl_init();
        
        curl_setopt_array($ch, array(
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $json_data,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $auth_token,
                'X-api-key: ' . $api_key
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ));
        
        // Execute API call
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        
        curl_close($ch);
        
        // // Update the record with API response
        // $escaped_response = mysqli_real_escape_string($db_connection, $response);
        // $escaped_json_data = mysqli_real_escape_string($db_connection, $json_data);
        
        // $update_sql = "UPDATE complimentary_delegates 
        //                SET api_data = '$escaped_json_data',
        //                    api_response = '$escaped_response',
        //                    api_sent = 1,
        //                    updated_at = NOW()
        //                WHERE id = $id";
        
        // mysqli_query($db_connection, $update_sql);
        
        // Check response
        if ($http_code >= 200 && $http_code < 300 && empty($curl_error)) {
            $success_count++;
            $results[] = array(
                'id' => $id,
                'email' => $row['email'],
                'status' => 'success',
                'message' => 'Successfully sent',
                'http_code' => $http_code
            );
        } else {
            $error_count++;
            $results[] = array(
                'id' => $id,
                'email' => $row['email'],
                'status' => 'error',
                'message' => 'Failed to send',
                'http_code' => $http_code,
                'error' => $curl_error
            );
        }
        
        // Small delay to avoid overwhelming the API
        usleep(100000); // 0.1 second delay
    }
    
    echo json_encode(array(
        'success' => true,
        'total' => count($ids),
        'success_count' => $success_count,
        'error_count' => $error_count,
        'results' => $results
    ));
    exit;
}

// Excluded ticket types
$excluded_ticket_types = array('Business Visitor Pass','Buisness Visitor Pass', 'Service Pass', 'Exhibitor', 'FMC Premium', 'FMC GO');

// Build SQL query to fetch records
// Filter: first_name is not null and not empty, and ticketType is not in excluded list
$excluded_list = "'" . implode("','", array_map(function($item) use ($db_connection) {
    return mysqli_real_escape_string($db_connection, $item);
}, $excluded_ticket_types)) . "'";

$sql = "SELECT * FROM complimentary_delegates 
        WHERE first_name IS NOT NULL 
        AND first_name != '' 
        AND ticketType NOT IN ($excluded_list)
        ORDER BY id DESC";

$result = mysqli_query($db_connection, $sql) or die('Query failed: ' . mysqli_error($db_connection));

$records = array();
while ($row = mysqli_fetch_assoc($result)) {
    $row['api_json'] = json_encode(prepareApiData($row), JSON_PRETTY_PRINT);
    $records[] = $row;
}

$total_records = count($records);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complimentary Delegates - API Sender</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 10px;
        }
        
        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .info-item {
            font-size: 14px;
            color: #666;
        }
        
        .info-item strong {
            color: #333;
            font-size: 16px;
        }
        
        .action-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            padding: 15px;
            background: #e3f2fd;
            border-radius: 5px;
            align-items: center;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background: #45a049;
        }
        
        .btn-secondary {
            background: #2196F3;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #0b7dda;
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .selected-count {
            margin-left: auto;
            font-weight: 600;
            color: #2196F3;
        }
        
        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        thead {
            background: #2196F3;
            color: white;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        tbody tr {
            transition: background-color 0.2s;
        }
        
        tbody tr:hover {
            background-color: #f5f5f5;
        }
        
        tbody tr.selected {
            background-color: #e3f2fd;
        }
        
        .checkbox-cell {
            width: 50px;
            text-align: center;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-sent {
            background: #4CAF50;
            color: white;
        }
        
        .status-pending {
            background: #ff9800;
            color: white;
        }
        
        .results-panel {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
        
        .results-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .results-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #2196F3;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        
        .preview-btn {
            background: #9c27b0;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .preview-btn:hover {
            background: #7b1fa2;
        }
        
        .json-preview-row {
            display: none;
        }
        
        .json-preview-row.show {
            display: table-row;
        }
        
        .json-preview-cell {
            padding: 15px;
            background: #f8f9fa;
            border-top: 2px solid #2196F3;
        }
        
        .json-content {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            overflow-x: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .json-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 8px;
            width: 80%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: #000;
        }
        
        .preview-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        
        .selected-preview {
            margin-top: 20px;
            padding: 15px;
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            display: none;
        }
        
        .selected-preview.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complimentary Delegates - API Sender</h1>
        
        <div class="header-info">
            <div class="info-item">
                Total Records: <strong><?php echo $total_records; ?></strong>
            </div>
            <div class="info-item">
                <button class="btn btn-secondary" onclick="location.reload()">Refresh</button>
            </div>
        </div>
        
        <div class="action-bar">
            <button class="btn btn-secondary" onclick="selectAll()">Select All</button>
            <button class="btn btn-secondary" onclick="deselectAll()">Deselect All</button>
            <button class="btn btn-primary" id="sendBtn" onclick="sendSelected()" disabled>Send Selected</button>
            <span class="selected-count" id="selectedCount">0 selected</span>
        </div>
        
        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p style="margin-top: 10px;">Sending records to API...</p>
        </div>
        
        <div class="results-panel" id="resultsPanel"></div>
        
        <div class="selected-preview" id="selectedPreview">
            <h3>Selected Records JSON Preview</h3>
            <div id="selectedJsonContent"></div>
            <div class="preview-actions">
                <button class="btn btn-secondary" onclick="hideSelectedPreview()">Close Preview</button>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="checkbox-cell">
                            <input type="checkbox" class="checkbox" id="selectAllCheckbox" onchange="toggleAll(this)">
                        </th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Ticket Type</th>
                        <th>Title</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Job Title</th>
                        <th>Organization</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Preview</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($records)): ?>
                        <tr>
                            <td colspan="15" style="text-align: center; padding: 40px;">
                                No records found matching the criteria.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($records as $row): ?>
                            <tr data-id="<?php echo $row['id']; ?>" class="data-row">
                                <td class="checkbox-cell">
                                    <input type="checkbox" 
                                           class="checkbox record-checkbox" 
                                           value="<?php echo $row['id']; ?>"
                                           data-json='<?php echo htmlspecialchars($row['api_json'], ENT_QUOTES); ?>'
                                           onchange="updateSelectedCount()"
                                           >
                                </td>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td>
                                    <?php if ($row['api_sent'] == 1): ?>
                                        <span class="status-badge status-sent">Sent</span>
                                    <?php else: ?>
                                        <span class="status-badge status-pending">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['ticketType'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['title'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['first_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['last_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['mobile'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['job_title'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['organisation_name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['city'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['state'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['country'] ?? ''); ?></td>
                                <td>
                                    <button class="preview-btn" onclick="showJsonPreview(<?php echo $row['id']; ?>, <?php echo htmlspecialchars(json_encode(prepareApiData($row)), ENT_QUOTES); ?>)">
                                        Preview JSON
                                    </button>
                                </td>
                            </tr>
                            <tr class="json-preview-row" id="preview-<?php echo $row['id']; ?>">
                                <td colspan="15" class="json-preview-cell">
                                    <div class="json-label">JSON Payload for Record ID: <?php echo $row['id']; ?></div>
                                    <div class="json-content" id="json-content-<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['api_json']); ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- JSON Preview Modal -->
    <div id="jsonModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>JSON Preview</h2>
            <div class="json-label">Record ID: <span id="modalRecordId"></span></div>
            <div class="json-content" id="modalJsonContent"></div>
        </div>
    </div>
    
    <script>
        function updateSelectedCount() {
            const checkboxes = document.querySelectorAll('.record-checkbox:checked:not(:disabled)');
            const count = checkboxes.length;
            document.getElementById('selectedCount').textContent = count + ' selected';
            document.getElementById('sendBtn').disabled = count === 0;
            
            // Update row highlighting
            checkboxes.forEach(cb => {
                cb.closest('tr').classList.add('selected');
            });
            
            document.querySelectorAll('.record-checkbox').forEach(cb => {
                if (!cb.checked) {
                    cb.closest('tr').classList.remove('selected');
                }
            });
            
            // Update selected preview
            updateSelectedPreview();
        }
        
        function updateSelectedPreview() {
            const checkboxes = document.querySelectorAll('.record-checkbox:checked:not(:disabled)');
            if (checkboxes.length === 0) {
                document.getElementById('selectedPreview').classList.remove('show');
                return;
            }
            
            let html = '<h4>JSON Payloads for Selected Records:</h4>';
            checkboxes.forEach((cb, index) => {
                const row = cb.closest('tr');
                const recordId = cb.value;
                const jsonData = cb.getAttribute('data-json');
                
                try {
                    const jsonObj = JSON.parse(jsonData);
                    html += `<div style="margin-bottom: 20px; padding: 10px; background: white; border-radius: 5px; border-left: 4px solid #2196F3;">`;
                    html += `<strong>Record ID: ${recordId}</strong>`;
                    html += `<div class="json-content" style="margin-top: 10px;">${JSON.stringify(jsonObj, null, 2)}</div>`;
                    html += `</div>`;
                } catch(e) {
                    html += `<div style="margin-bottom: 20px; padding: 10px; background: #f8d7da; border-radius: 5px;">`;
                    html += `<strong>Record ID: ${recordId}</strong> - Error parsing JSON`;
                    html += `</div>`;
                }
            });
            
            document.getElementById('selectedJsonContent').innerHTML = html;
            document.getElementById('selectedPreview').classList.add('show');
        }
        
        function hideSelectedPreview() {
            document.getElementById('selectedPreview').classList.remove('show');
        }
        
        function showJsonPreview(recordId, jsonData) {
            const modal = document.getElementById('jsonModal');
            const modalRecordId = document.getElementById('modalRecordId');
            const modalJsonContent = document.getElementById('modalJsonContent');
            
            modalRecordId.textContent = recordId;
            
            try {
                const jsonObj = typeof jsonData === 'string' ? JSON.parse(jsonData) : jsonData;
                modalJsonContent.textContent = JSON.stringify(jsonObj, null, 2);
            } catch(e) {
                modalJsonContent.textContent = typeof jsonData === 'string' ? jsonData : JSON.stringify(jsonData, null, 2);
            }
            
            modal.style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('jsonModal').style.display = 'none';
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('jsonModal');
            if (event.target == modal) {
                closeModal();
            }
        }
        
        function selectAll() {
            document.querySelectorAll('.record-checkbox:not(:disabled)').forEach(cb => {
                cb.checked = true;
            });
            document.getElementById('selectAllCheckbox').checked = true;
            updateSelectedCount();
        }
        
        function deselectAll() {
            document.querySelectorAll('.record-checkbox').forEach(cb => {
                cb.checked = false;
            });
            document.getElementById('selectAllCheckbox').checked = false;
            updateSelectedCount();
        }
        
        function toggleAll(checkbox) {
            if (checkbox.checked) {
                selectAll();
            } else {
                deselectAll();
            }
        }
        
        function sendSelected() {
            const checkboxes = document.querySelectorAll('.record-checkbox:checked:not(:disabled)');
            
            if (checkboxes.length === 0) {
                alert('Please select at least one record to send.');
                return;
            }
            
            if (!confirm(`Are you sure you want to send ${checkboxes.length} record(s) to the API?`)) {
                return;
            }
            
            const ids = Array.from(checkboxes).map(cb => cb.value);
            
            // Show loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('resultsPanel').style.display = 'none';
            document.getElementById('sendBtn').disabled = true;
            
            // Send via AJAX
            const formData = new FormData();
            formData.append('action', 'send_selected');
            formData.append('ids', JSON.stringify(ids));
            
            fetch('send_complimentary_delegates.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                
                const resultsPanel = document.getElementById('resultsPanel');
                resultsPanel.style.display = 'block';
                
                if (data.success) {
                    let html = `<h3>Results Summary</h3>`;
                    html += `<p><strong>Total:</strong> ${data.total} | <strong>Success:</strong> ${data.success_count} | <strong>Failed:</strong> ${data.error_count}</p>`;
                    
                    if (data.error_count > 0) {
                        resultsPanel.className = 'results-panel results-error';
                        html += `<h4>Failed Records:</h4><ul>`;
                        data.results.forEach(r => {
                            if (r.status === 'error') {
                                html += `<li>ID ${r.id} (${r.email}): ${r.message} - HTTP ${r.http_code}</li>`;
                            }
                        });
                        html += `</ul>`;
                    } else {
                        resultsPanel.className = 'results-panel results-success';
                    }
                    
                    resultsPanel.innerHTML = html;
                    
                    // Update UI - mark sent records
                    data.results.forEach(r => {
                        if (r.status === 'success') {
                            const row = document.querySelector(`tr[data-id="${r.id}"]`);
                            if (row) {
                                const checkbox = row.querySelector('.record-checkbox');
                                checkbox.disabled = true;
                                checkbox.checked = false;
                                
                                const statusCell = row.cells[2];
                                statusCell.innerHTML = '<span class="status-badge status-sent">Sent</span>';
                            }
                        }
                    });
                    
                    // Refresh page after 3 seconds if all successful
                    if (data.error_count === 0) {
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    }
                } else {
                    resultsPanel.className = 'results-panel results-error';
                    resultsPanel.innerHTML = `<p>Error: ${data.message}</p>`;
                }
                
                updateSelectedCount();
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                const resultsPanel = document.getElementById('resultsPanel');
                resultsPanel.style.display = 'block';
                resultsPanel.className = 'results-panel results-error';
                resultsPanel.innerHTML = `<p>Error: ${error.message}</p>`;
                updateSelectedCount();
            });
        }
    </script>
</body>
</html>
<?php
mysqli_close($db_connection);
?>
