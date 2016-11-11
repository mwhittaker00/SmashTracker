<?php
  function twitchGame($gameName){
    $twitchFile = file_get_contents('https://api.twitch.tv/kraken/streams?game='.$gameName);
    $twitch = json_decode($twitchFile);
    $obj = $twitch->streams;
    $i = 0;
    $arr = array();
    foreach ( $obj as $stream){

      $arr[$i]['channelName'] = $stream->channel->name;
      $arr[$i]['displayName'] = $stream->channel->display_name;
      $arr[$i]['game'] = $stream->game;
      $arr[$i]['viewers'] = $stream->viewers;
      $arr[$i]['followers'] = $stream->channel->followers;
      $arr[$i]['preview'] = $stream->preview->medium;

      if ( $arr[$i]['game'] == 'Moon' ){
        $arr[$i]['game'] = 'Project M';
      } else{}

      $i++;
    }
    return $arr;

  }

  function randomStream($data){
    $rand = array_rand($data);
    $randChannel = $data[$rand];
    $rand2 = array_rand($randChannel);
    $randStream = $randChannel[$rand2];

    return $randStream;
  }

  $PM1 = 'Moon';
  $PM2 = 'Project+M';
  $SSB = 'Super+Smash+Bros.';
  $melee = $SSB.'+Melee';
  $brawl = $SSB.'+Brawl';
  $wiiU = $SSB.'+for+Wii+U';

  $info['wiiU'] = twitchGame($wiiU);
  $info['melee'] = twitchGame($melee);
  $info['pm1'] = twitchGame($PM1);
  $info['pm2'] = twitchGame($PM2);
  $info['ssb'] = twitchGame($SSB);
  $info['brawl'] = twitchGame($brawl);

  /*  print_r($info);
  $i = 0;
  for ($i = 0; $i <= 5; $i++){
    foreach ( $info[$i]['channel'] as $key ){
      $channels[] = $key;
    }

    foreach ( $info[$i]['preview'] as $key ){
      $previews = $previews.$key;
    }
  }
  */

  $randStream = randomStream($info);
  while ( !count($randStream) ){
    $randStream = randomStream($info);
  }




  $channelName = $randStream['channelName'];
  $displayName = $randStream['displayName'];
  $gameName = $randStream['game'];
  $viewers = $randStream['viewers'];
  $followers = $randStream['followers'];
  $preview = $randStream['preview'];

?>
