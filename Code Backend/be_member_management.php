<?php
include "be_db_conn.php";

class Member {
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;

    public function __construct($id, $firstName, $lastName, $email, $phone) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }
}

class MemberList {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addMember($firstName, $lastName, $email, $phone) {
        $stmt = $this->conn->prepare("INSERT INTO members (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $phone);
        $stmt->execute();
        $stmt->close();
        echo "Member added successfully!";
    }

    public function getAllMembers() {
        $result = $this->conn->query("SELECT * FROM members");
        if ($result->num_rows > 0) {
            echo "<table class='member-table'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["member_id"] . "</td>";
                echo "<td>" . $row["first_name"] . "</td>";
                echo "<td>" . $row["last_name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No members added yet.";
        }
    }
}



$memberList = new MemberList($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    $memberList->addMember($firstName, $lastName, $email, $phone);
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Management System - Member Management</title>
    <link rel="stylesheet" type="text/css" href="be_style_management.css">
</head>
<body>
    <h2>Add a New Member</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName"><br>
        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName"><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email"><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone"><br><br>
        <input type="submit" value="Add Member">
    </form>

    <h2>Member List</h2>
    <?php $memberList->getAllMembers(); ?><br>
    <button onclick="window.location.href='be_home.php'">Home</button>
</body>
</html>

<?php
// Schließen Sie die MySQL-Verbindung am Ende
$conn->close();
?>
