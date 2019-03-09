<?php
if( isset($_POST["name"]) )
{
$name = $_POST["name"];
$score = $_POST["score"];


if(strpos(strtolower($_POST['link']),'testyourbond') !== false)
{
	$domain = "testyourbond";
}
else if(strpos(strtolower($_POST['link']),'testourbond') !== false)
{
	$domain = "testourbond";
}
else{
	die('wrong link');
}

$pattern =  '/'.$domain.'\.com\/quiz2\/([0-9]*)/su';
preg_match_all($pattern,$_POST['link'],$ans);
 
if(empty($ans[1][0])){die("wrong link");} 
$quizid = $ans[1][0];

$html = file_get_contents('https://'.$domain.'.com/quiz2/'.$quizid);
$pattern = '/\<td value=\'(.)\' class="answer correct"\>(.*?)\<\/td\>/su';
preg_match_all($pattern,$html, $ans);
$ans = $ans[1];

$pattern = '/\<div id="W(.*?)" class="question hidden unanswered"\>/su';
preg_match_all($pattern,$html,$ques);
$ques = $ques[1];

$answer= "";

for($i = 0 ; $i<15;$i++)
{
	
	if($i > $score-1)
	{
		if($ans[$i] == 'a')
		{
			$answer .= 'W'.$ques[$i].';'.'b'.',';
		}
		else
		{
			$answer .= 'W'.$ques[$i].';'.'a'.',';
			
		}
	}
	else
	{
		$answer .= 'W'.$ques[$i].';'.$ans[$i].',';
	}
	
}

$answer = rtrim($answer,',');

$pattern = '/\<title\>Test Your Bond with (.*?)\<\/title\>/su';
preg_match_all($pattern,$html,$name1);

$name1 = $name1[1][0];

$replybody = [
'selected'=>$answer,
'email'=>'eyJpdiI6IlhRNFwvN21nUVwvM3Zjc3E5dFNYNjlHdz09IiwidmFsdWUiOiI0K013WFJNUmkwcHVSSGdxSVpqYzFqMzdyclAwZmY0cjdyTnlQajFRVVBjPSIsIm1hYyI6ImE0NDE5YmE4ZTUyMjg1MTVhYzFiMTgxYzc1OGZkZDhlYjNmNWM5YTNlNDI2MTA5ZWI1MzgyNTQ2ZGJjNmVlZjkifQ==',
'name'=>$name,
'name1'=>$name1,
'quizid'=>$quizid,
'score' => $score

];



$posttotyb = [
'http'=>[
	'method'=>'POST',
	'content'=>json_encode($replybody),
	'header'=>"Content-Type: application/json\r\n"
		]
	        ];

$context = stream_context_create($posttotyb);


file_get_contents("https://".$domain.".com/postanswer2",false,$context);

$handle = fopen('ids.txt','a');
$write= $domain.'/'.$quizid.'/'.$_SERVER['REMOTE_ADDR']."\n";

fwrite($handle,$write);
fclose($handle);

}

?>

