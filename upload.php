<html>
<head>
<style type="text/css">
p {
  color: white;
}
[alt="www.000webhost.com"] {
    display: none;
}
</style>
</head>
<body bgcolor="#303030">
<?php
$ini = parse_ini_file("conf.ini");

$server = $ini["SERVER"];
$username = $ini["USERNAME"];
$password = $ini["PASSWORD"];
$database = $ini["NAME"];

if (!empty($_GET["video"]) and !empty($_GET["image"])) {
    try {
        $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $video = $_GET["video"];
        $image = $_GET["image"];

        $id = crc32($video . $image);

        $sql = "SELECT 1 FROM Urls WHERE id = :id";

        $stmt = $conn->prepare($sql);
		$stmt->execute([":id" => $id]);

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();

        if (empty($data)) {
            $sql = "INSERT INTO Urls (id, imageurl, videourl) VALUES (:id, :imageurl, :videourl)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":imageurl", $image);
            $stmt->bindValue(":videourl", $video);
            $stmt->execute();

            echo "Id: ". $id . "</p>";
        } else {
            echo "<p>Id: ". $id . " exists</p>";
        }
        
        $conn = null;
    } catch(PDOException $e) {    
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
</body>
</html>