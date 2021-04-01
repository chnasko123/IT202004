function authenticate($db, $ucid, $pass) {   
    $s = "select * from users where ucid='$ucid' and pass='$pass'";
    echo "<br>SQL select: $s<br>";
    ($t = mysqli_query($db, $s))or die (mysqli_error($db));

    $num = mysqli_num_rows($t);
    if($num==0)
    {
        return false;
    }
    else
    {
        return true;
    }
}

function list_transactions($db, $ucid)
{
    $s = "select * from transactions where ucid='$ucid'";
    echo "<br>SQL select: $s<br>";
    ($t = mysqli_query($db, $s)) or die (mysqli_error($db));
    $num = mysqli_num_rows($t);
    echo "<br> There were $num rows retrieved from DB table. <br><br><br>";
    if( $num == 0)
    {
        echo "No transactions<br>";
    }
    echo "<table>";
    echo "<tr><th>ucid</th><th>amount</th><th>account</th><th>timestamp</th></tr>";
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
    {
        echo"<tr>";
        $ucid = $r["ucid"];
        $amount =$r["amount"];
        $account = $r["account"];
        $timestamp = $r["timestamp"];
        echo "<td>$ucid</td>";
        echo "<td>$amount</td>";
        echo "<td>$account</td>";
        echo "<td>$timestamp</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function perform($db, $ucid, $account, $amount)
{
  //Select from DB and run a check
  $s = "Select * from accounts where ucid = '$ucid' and account = '$account' and balance + '$amount' >= 0.00";
  ($t = mysqli_query($db, $s)) or die(mysqli_error($db));
  $num = mysqli_num_rows($t);
  if ($num == 0)
  {
  	exit("<br>An error occurred.");
  }
  
  //Insert the transaction
  $inst = "insert into transactions values ('$ucid', '$amount', '$account', NOW())";
  ($insert = mysqli_query($db, $inst)) or die(mysqli_error($db));
  //Update accounts
  $up = "update accounts set balance = balance + '$amount', mostRecentTrans = NOW() where ucid = '$ucid' and account = '$account'";
  ($update = mysqli_query($db, $up)) or die(mysqli_error($db));
}

function list_accounts($db, $ucid)
{
    $s = "select * from accounts where ucid='$ucid'";
    echo "<br>SQL select: $s<br>";
    ($t= mysqli_query($db, $s)) or die (mysqli_error($db));
    $num = mysqli_num_rows($t);
    echo "<br> There were $num rows retrieved from DB table. <br><br><br>";
    if( $num == 0)
    {
        echo "No accounts match that UCID!<br>";
    }
    echo "<table border = 2 width = 30%>";
    echo "<tr><th>ucid</th><th>balance</th><th>account</th><th>mostRecentTrans</th></tr>";
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
    {
        echo"<tr>";
        $ucid = $r["ucid"];
        $balance = $r["balance"];
        $account =$r["account"];
        $mostRecentTrans = $r["mostRecentTrans"];
        echo "<td>$ucid</td>";
        echo "<td>$balance</td>";
        echo "<td>$account</td>";
        echo "<td>$mostRecentTrans</td>";
        echo "</tr>";
    }
    echo "</table>";
}


function reset_account($db, $ucid, $account)
{
    $up = "update accounts set balance = '0', mostRecentTrans = NOW() where ucid='$ucid' and account='$account'";
    $del = "delete from transactions where ucid='$ucid' and account='$account'";
	($t= mysqli_query($db, $up)) or die (mysqli_error($db));
	($s= mysqli_query($db, $del)) or die (mysqli_error($db));
    echo "Re-initialized the account: $account and deleted corresponding transactions.";
}



function list_number_transactions($db, $ucid, $account, $n)
{
    $s = "select * from transactions where ucid='$ucid' and account='$account' ORDER BY timestamp DESC LIMIT $n";
    echo "<br>SQL select: $s<br>";
    ($t= mysqli_query($db, $s)) or die (mysqli_error($db));
    $num = mysqli_num_rows($t);
    echo "<br> There were $num rows retrieved from DB table. <br><br><br>";
    if( $num == 0)
    {
        echo "No transactions<br>";
    }
    echo "<table border = 2 width = 30%>";
    echo "<tr><th>ucid</th><th>amount</th><th>account</th><th>timestamp</th></tr>";
    while($r = mysqli_fetch_array($t, MYSQLI_ASSOC))
    {
        echo"<tr>";
        $ucid = $r["ucid"];
        $amount =$r["amount"];
        $account = $r["account"];
        $timestamp = $r["timestamp"];
        echo "<td>$ucid</td>";
        echo "<td>$amount</td>";
        echo "<td>$account</td>";
        echo "<td>$timestamp</td>";
        echo "</tr>";
    }
    echo "</table>";
}


?>
