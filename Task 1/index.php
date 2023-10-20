<html>

<head>
    <title>PHP Starter</title>
    <style>
        .records {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        .records td,
        .records th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .records tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .records tr:hover {
            background-color: #ddd;
        }

        .records th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .scroll-div {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <h1>Dataset</h1>
    <div class="scroll-div">
        <table class="records">
            <tr>
                <th>#</th>
                <th>Investor ID</th>
                <th>Syndicate ID</th>
                <th>Transaction Amount</th>
                <th>Date</th>
            </tr>
            <?php
            $dataset = [];
            $investments = [];
            $investorUniqueInvestments = [];

            for ($i = 1; $i < 101; $i++) {
                $investorId = rand(1, 10); // Assuming 10 investors
                $syndicateId = rand(101, 110); // Assuming 10 syndicates
                $transactionAmount = rand(500, 5000); // Random transaction amount between 500 and 5000
                $transactionDate = date('Y-m-d', strtotime("2023-10-01 +$i days"));

                $dataset[] = [
                    'investor_id' => $investorId,
                    'syndicate_id' => $syndicateId,
                    'transaction_amount' => $transactionAmount,
                    'transaction_date' => $transactionDate,
                ];

                // checking for unique investments and adding up total amount
                if (isset($investments[$investorId][$syndicateId]))
                    $investments[$investorId]['total_amount'] += $transactionAmount;
                else {
                    $investments[$investorId][$syndicateId] = TRUE;
                    $investments[$investorId]['total_amount'] = $transactionAmount;
                    $investorUniqueInvestments[$investorId] = isset($investorUniqueInvestments[$investorId]) ? $investorUniqueInvestments[$investorId] + 1 : 1;
                }

                echo "<tr>
                    <td>$i</td>
                    <td>$investorId</td>
                    <td>$syndicateId</td>
                    <td>$transactionAmount</td>
                    <td>$transactionDate</td>
                </tr>";
            }
            ?>
        </table>
    </div>

    <h1>Top 5 Investors</h1>
    <table class="records">
        <tr>
            <th>#</th>
            <th>Investor ID</th>
            <th>Total Invested Amount</th>
        </tr>
        <?php
        arsort($investorUniqueInvestments);
        $i = 1;
        foreach ($investorUniqueInvestments as $key => $value) {
            echo "<tr>
                <td>$i</td>
                <td>$key</td>
                <td>" . $investments[$key]['total_amount'] . " (in $value syndicates)</td>
            </tr>";
            if (++$i > 5)
                break;
        }
        ?>
    </table>
</body>

</html>
