<?php
    namespace App\Events;
    use App\Events\ActionEvent;
    use Illuminate\Support\Facades\Event;

    $actionId = "score_update";
    $actionData = array("team1_score" => 46)
    event(new ActionEvent($actionId, $actionData));
?>


<div class="container">
    <h1>Team A Score</h1>
    <div id="team1_score"></div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"> </script>
  <script>
    var sock = io("{{ env('REDIS_HOST') }}:{{ env('REDIS_PORT') }}");
    sock.on('action-channel-one:App\\Events\\ActionEvent', function (data){
        //data.actionId and data.actionData hold the data that was broadcast
        //process the data, add needed functionality here
        var action = data.actionId;
        var actionData = data.actionData;
        if(action == "score_update" && actionData.team1_score) {
                $("#team1_score").html(actionData.team1_score);
        }
    });
  </script>
