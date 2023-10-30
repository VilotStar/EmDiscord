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
<?php
$ini = parse_ini_file("conf.ini");

$server = $ini["SERVER"];
$username = $ini["USERNAME"];
$password = $ini["PASSWORD"];
$database = $ini["NAME"];

$reg = "/Discordbot/i";

$browser = $_SERVER['HTTP_USER_AGENT'];

if (!empty($_GET["id"]) and preg_match($reg, $browser)) {
	try {
		$conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$id = $_GET["id"];

		$sql = "SELECT id, imageurl, videourl FROM Urls WHERE id = :id";
		
		$stmt = $conn->prepare($sql);
		$stmt->execute([":id" => $id]);

		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll()[0];
		$image = $data["imageurl"];
		$video = $data["videourl"];
		echo '<meta property="og:image" content="' . $image . '">';
		echo '<meta property="og:video:url" content="' . $video . '">';
		
		$conn = null;
	} catch(PDOException $e) {    
		echo "Connection failed: " . $e->getMessage();
	}
}
?>
<meta name="viewport" content="width=device-width">
<meta property="og:type" content="video.other">
<meta property="og:video:width" content="1280">
<meta property="og:video:height" content="720">
<meta property="theme-color" content="#C74600">
</head>
<body bgcolor="#303030">
<?php
if (!empty($_GET["id"])) {
    $id = $_GET["id"];
    echo '<p> Id: ' . $id . '</p>';
    echo "<p>Hide in discord:</p><p><code>
         ||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​||||​|| https://dischost.000webhostapp.com/discv2?id=" . $id . "</code></p>";
} else {
    echo '<p>Use the format https://dischost.000webhostapp.com/discv2?id=[id]</p>';
}
?>
</body>
</html>