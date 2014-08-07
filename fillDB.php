<?php
require_once("connect.php");

$firstnames=array(
	"LongnameMcLongNamens",
	"Antonette",
	"Jacelyn",
	"Daren",
	"Mitch",
	"Ashanti",
	"Gabriella",
	"Nubia",
	"Marin",
	"Teodoro",
	"Dottie",
	"Moses",
	"Jewel",
	"Annett",
	"Larisa",
	"Karma",
	"Peggy",
	"Tanna",
	"Sarai",
	"Wilbert",
	"Jenell",
	"Olinda",
	"Nanette",
	"Rocco",
	"Avis",
	"Tyesha",
	"Mack",
	"Denisha",
	"Omer",
	"Hortencia",
	"Carin"
);
$lastnames=array(
	"LongnameMcLongNamensonsen",
	"Collings",
	"Mustain",
	"Beckman",
	"Raskin",
	"Zanchez",
	"Manthe",
	"Zahradnik",
	"Yerby",
	"Quackenbush",
	"Tagle",
	"Rowlett",
	"Moulton",
	"Sessions",
	"Hinnenkamp",
	"Blumstein",
	"Alspaugh",
	"Ashbrook",
	"Hagler",
	"Casterline",
	"Riva",
	"Holoman",
	"Bloomquist",
	"Podkowka",
	"Coupe",
	"Galle",
	"Predmore",
	"Parrett",
	"Trumble",
	"Sinkfield",
	"Negley"
	);

$emails=array(
	"rcxp@pzkrzj.com",
	"3d2o6_3@tnywgl9.com",
	"e1qv3a-f2i@xor-xhcm.com",
	"llqz_a7k-q@wbdav5bt-22w.com",
	"x4q1@d-upj0c.com",
	"9s0md@9odtiebh744z.com",
	"4qc@6owjyul8.com",
	"oruro-v0f@z0mu2fu.com",
	"lhygxjqk63gn@0t3s-fpuc.com",
	"a065couyz3@i5lrivk.com",
	"x-kpqkv87xqdym9@ooj9a9yj201.com",
	"a_ky0van6vhygx2@49wgl6dm4.com",
	"v3lukmtv-qd-@38s-tyvjqt.com",
	"723gtt4bicwto@dcktfikc2k.com",
	"887o1sipip@8ze99gtp.com",
	"t7fzdq262m@ivgc06tgj2.com",
	"r1eo9y6qjl@jo9m5yg.com",
	"odfrba.ik@13pgqttmfm2o.com",
	"5wnxjufi0jo@mknlsx.com",
	"ci2@v2b2d4f.com",
	"-mgvv115w0g-@htjzgk9isy4.com",
	"vnt1cl@worf0f5212.com",
	"-r0yxhw72iz--h@kp7n1s3hx1.com",
	"rcin3g6@x4p5nitv7.com",
	"d4-_f1r98@dwhuck3pa.com",
	"y3xrc8.z4rg7ie5@n3iixl6.com",
	"9ezlexu4mfip.i@b2yiv8mnjevr.com",
	"mx5i3ru8bbxn@g52fb481arwm.com",
	"rpmimz7d9vupq@uqa8w6x38qy.com",
	"eh6-bjnosz@bk286klj5.com",
	"test@test.com"
	);


echo "<pre>";
print_r($firstnames);
echo "</pre>";

echo "<pre>";
print_r($lastnames);
echo "</pre>";

echo "<pre>";
print_r($emails);
echo "</pre>";


for($i=0; $i<31; $i++){
	$result=mysql_query("INSERT INTO users (firstname,lastname,email,password) 
		VALUES('".$firstnames[$i]."','".$lastnames[$i]."','".$emails[$i]."','password') ");
	if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    //$message .= 'Whole query: ' . $query;
    die($message);
	}
}
?>

