<?php
// BASIC認証の設定
$username = 'XXX';
$password = 'XXX';
if (!isset($_SERVER['PHP_AUTH_USER']) ||
    !isset($_SERVER['PHP_AUTH_PW']) ||
    $_SERVER['PHP_AUTH_USER'] != $username ||
    $_SERVER['PHP_AUTH_PW'] != $password) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Unauthorized';
    exit;
}

// AWS SDK for PHPをインストールしている前提
require 'vendor/autoload.php';
use Aws\Ec2\Ec2Client;

// AWS認証情報を設定
$aws_access_key_id = 'XXX';
$aws_secret_access_key = 'XXX';

// インスタンス情報にリージョンを追加
$instances = [
    ['id' => 'i-XXX', 'name' => 'XXX', 'region' => 'us-west-1'],
    ['id' => 'i-XXX', 'name' => 'XXX', 'region' => 'us-west-1']
];

$message = '';

// リージョンごとのEC2クライアントを作成する関数
function getEc2Client($region) {
    global $aws_access_key_id, $aws_secret_access_key;
    return new Aws\Ec2\Ec2Client([
        'version' => 'latest',
        'region'  => $region,
        'credentials' => [
            'key'    => $aws_access_key_id,
            'secret' => $aws_secret_access_key,
        ]
    ]);
}

// インスタンスの状態を取得するためのエンドポイントを追加
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_status') {
    $instance_id = $_GET['instance_id'] ?? null;
    $instance_region = $_GET['region'] ?? null;

    if ($instance_id && $instance_region) {
        $client = getEc2Client($instance_region);
        try {
            $result = $client->describeInstances(['InstanceIds' => [$instance_id]]);
            $instance = $result['Reservations'][0]['Instances'][0];
            echo json_encode([
                'state' => $instance['State']['Name'],
                'type' => $instance['InstanceType']
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Invalid parameters']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance_id = $_POST['instance_id'] ?? null;
    $action = $_POST['action'] ?? null;
    $instance_type = $_POST['instance_type'] ?? null;

    if ($instance_id && $action) {
        // インスタンスIDからリージョンを取得
        $instance_region = array_values(array_filter($instances, function($instance) use ($instance_id) {
            return $instance['id'] === $instance_id;
        }))[0]['region'] ?? null;

        if ($instance_region) {
            $client = getEc2Client($instance_region);
            try {
                switch ($action) {
                    case 'start':
                        $client->startInstances(['InstanceIds' => [$instance_id]]);
                        $message = "Started instance {$instance_id} in {$instance_region}";
                        break;
                    case 'stop':
                        $client->stopInstances(['InstanceIds' => [$instance_id]]);
                        $message = "Stopped instance {$instance_id} in {$instance_region}";
                        break;
                    case 'force-stop':
                        $client->stopInstances(['InstanceIds' => [$instance_id], 'Force' => true]);
                        $message = "Force stopped instance {$instance_id} in {$instance_region}";
                        break;
                    case 'modify':
                        if ($instance_type && in_array($instance_type, ['t3a.medium', 't3a.large'])) {
                            try {
                                $client->modifyInstanceAttribute([
                                    'InstanceId' => $instance_id,
                                    'InstanceType' => ['Value' => $instance_type],
                                ]);
                                $message = "Modified instance {$instance_id} to {$instance_type} in {$instance_region}";
                            } catch (Exception $e) {
                                $message = "Error: " . $e->getMessage();
                            }
                        } else {
                            $message = "Invalid instance type";
                        }
                        break;
                    default:
                        $message = "Invalid action";
                }
            } catch (Exception $e) {
                $message = "Error: " . $e->getMessage();
            }
        } else {
            $message = "Error: Instance region not found";
        }
    }
}

// 現在のインスタンス状態を取得
$instanceStates = [];
foreach ($instances as $instance) {
    $client = getEc2Client($instance['region']);
    $describeInstances = $client->describeInstances(['InstanceIds' => [$instance['id']]]);
    foreach ($describeInstances['Reservations'] as $reservation) {
        foreach ($reservation['Instances'] as $ec2Instance) {
            $instanceStates[$instance['id']] = [
                'state' => $ec2Instance['State']['Name'],
                'type' => $ec2Instance['InstanceType']
            ];
        }
    }
}

function getRowClass($state, $type) {
    if ($state === 'running') {
        return $type === 't3a.large' ? 'running-large' : 'running';
    } elseif ($state === 'stopped') {
        return 'stopped';
    }
    return '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EC2 Instance Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            overflow: auto;
            padding: 0 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            background: #333;
            color: #fff;
            border: none;
            padding: 7px 15px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            font-family: inherit;
        }
        .btn:hover {
            background: #444;
        }
        .message {
            background: #f4f4f4;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            color: green;
            border-left: 5px solid green;
        }
        .error {
            color: red;
            border-left: 5px solid red;
        }
        .running {
            background-color: #90EE90;
        }
        .running-large {
            background-color: #228B22;
            color: white;
        }
        .stopped {
            background-color: #FF6347;
        }
        @media (max-width: 600px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }
            tr {
                margin-bottom: 15px;
            }
            td {
                border: none;
                position: relative;
                padding-left: 50%;
            }
            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                font-weight: bold;
            }
        }
    </style>
    <script>
        function updateAllInstanceStatuses() {
            const instances = document.querySelectorAll('tr[data-instance-id]');
            instances.forEach(instance => {
                const instanceId = instance.dataset.instanceId;
                const region = instance.querySelector('td[data-label="Region"]').textContent;
                updateInstanceStatus(instanceId, region);
            });
        }

        function updateInstanceStatus(instanceId, region) {
            fetch(`index2.php?action=get_status&instance_id=${instanceId}&region=${region}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    const row = document.querySelector(`tr[data-instance-id="${instanceId}"]`);
                    const stateCell = row.querySelector('td[data-label="State"]');
                    const typeCell = row.querySelector('td[data-label="Type"]');

                    stateCell.textContent = data.state;
                    typeCell.textContent = data.type;

                    // 行のクラスを更新
                    row.className = getRowClass(data.state, data.type);
                });
        }

        function getRowClass(state, type) {
            if (state === 'running') {
                return type === 't3a.large' ? 'running-large' : 'running';
            } else if (state === 'stopped') {
                return 'stopped';
            }
            return '';
        }

        // 15秒ごとに全インスタンスの状態を更新
        setInterval(updateAllInstanceStatuses, 15000);

        function modifyInstanceType(instanceId, region, newType) {
            const steps = ['stopping', 'stopped', 'modifying', 'starting', 'running'];
            let currentStep = 0;

            function updateStatus() {
                updateInstanceStatus(instanceId, region);
                fetch(`index2.php?action=get_status&instance_id=${instanceId}&region=${region}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error(data.error);
                            return;
                        }

                        console.log(`Current state: ${data.state}, Current type: ${data.type}, Target type: ${newType}, Step: ${steps[currentStep]}`);

                        const stateCell = document.querySelector(`tr[data-instance-id="${instanceId}"] td[data-label="State"]`);
                        const typeCell = document.querySelector(`tr[data-instance-id="${instanceId}"] td[data-label="Type"]`);

                        stateCell.textContent = `${data.state} (${steps[currentStep]})`;
                        typeCell.textContent = data.type;

                        if (currentStep === 0 && data.state === 'stopped') {
                            console.log('Instance stopped. Proceeding to modify type.');
                            currentStep = 1;
                            modifyType();
                        } else if (currentStep === 1 && data.type === newType) {
                            console.log('Type modified. Proceeding to start instance.');
                            currentStep = 2;
                            startInstance();
                        } else if (currentStep === 2 && data.state === 'running') {
                            console.log('Instance started. Process complete.');
                            clearInterval(intervalId);
                            alert(`インスタンス ${instanceId} のタイプが ${newType} に変更され、再起動されました。`);
                        }
                    });
            }

            function stopInstance() {
                console.log('Stopping instance...');
                fetch('index2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `instance_id=${instanceId}&action=stop`
                }).then(() => console.log('Stop request sent.'));
            }

            function modifyType() {
                console.log('Modifying instance type...');
                fetch('index2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `instance_id=${instanceId}&action=modify&instance_type=${newType}`
                }).then(() => console.log('Modify type request sent.'));
            }

            function startInstance() {
                console.log('Starting instance...');
                fetch('index2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `instance_id=${instanceId}&action=start`
                }).then(() => console.log('Start request sent.'));
            }

            stopInstance();
            const intervalId = setInterval(updateStatus, 5000);
        }

        // Modify Type button event listener
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (e.submitter.name === 'action' && e.submitter.value === 'modify') {
                        e.preventDefault();
                        const instanceId = this.querySelector('input[name="instance_id"]').value;
                        const region = this.closest('tr').querySelector('td[data-label="Region"]').textContent;
                        const newType = this.querySelector('select[name="instance_type"]').value;
                        modifyInstanceType(instanceId, region, newType);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>EC2 Instance Manager</h1>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Instance ID</th>
                    <th>Region</th>
                    <th>State</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($instances as $instance): ?>
                    <?php 
                    $state = $instanceStates[$instance['id']]['state'] ?? 'Unknown';
                    $type = $instanceStates[$instance['id']]['type'] ?? 'Unknown';
                    $rowClass = getRowClass($state, $type);
                    ?>
                    <tr class="<?php echo $rowClass; ?>" data-instance-id="<?php echo htmlspecialchars($instance['id']); ?>">
                        <td data-label="Name"><?php echo htmlspecialchars($instance['name']); ?></td>
                        <td data-label="Instance ID"><?php echo htmlspecialchars($instance['id']); ?></td>
                        <td data-label="Region"><?php echo htmlspecialchars($instance['region']); ?></td>
                        <td data-label="State"><?php echo htmlspecialchars($state); ?></td>
                        <td data-label="Type"><?php echo htmlspecialchars($type); ?></td>
                        <td data-label="Actions">
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="instance_id" value="<?php echo htmlspecialchars($instance['id']); ?>">
                                <button type="submit" name="action" value="start" class="btn">Start</button>
                                <button type="submit" name="action" value="stop" class="btn">Stop</button>
                                <button type="submit" name="action" value="force-stop" class="btn">Force Stop</button>
                                <select name="instance_type">
                                    <option value="t3a.medium">t3a.medium</option>
                                    <option value="t3a.large">t3a.large</option>
                                </select>
                                <button type="submit" name="action" value="modify" class="btn">Modify Type</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
